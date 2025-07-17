<?php

namespace App\Console;

use App\Helpers\Billing;
use App\Helpers\MikrotikConnection;
use App\Models\Company;
use App\Models\Customer;
use App\Models\MacCustomerBill;
use App\Models\MacReseller;
use App\Models\MeetingTime;
use App\Models\MikrotikServer;
use App\Models\MPPPProfile;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use \RouterOS\Query;

class Kernel extends ConsoleKernel
{
    use MikrotikConnection;
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // auto line off expire date customer
        foreach (['09:00', '10:00', '11:00','12:00'] as $time) {
        $schedule->call(function () {
            try {
                $customerExpired = Customer::where('billing_status_id', 5)->where('protocol_type_id', 3)->where('auto_line_off', 'yes')->whereDate('exp_date', today()->format('Y-m-d'))->get();
                if ($customerExpired->isNotEmpty()) {
                    foreach ($customerExpired as $customer) {
                        $customer->update(['disabled' => 'true', 'billing_status_id' => 4]);
                        $client = $this->client($customer->server_id);

                        $query =  new Query('/ppp/secret/set');
                        $query->equal('.id', $customer->mid);
                        $query->equal('disabled', 'true');
                        $client->query($query)->read();

                        $find = $client->query('/ppp/active/print', ['name', $customer->username])->read();
                        if ($find) {
                            $query =  new Query('/ppp/active/remove');
                            $query->equal('.id', $find[0]['.id']);
                            $client->query($query)->read();
                        }

                        $message = messageconvert($customer, $customer->getCompany->billing_exp_msg);
                        // $message = "Dear client, your account has been deactivated. Client Code: " . str_pad(($customer->id), 4, "0", STR_PAD_LEFT) . " User Name: " . $customer->username . " Password: " . $customer->m_password . " Customer Name: " . $customer->name . " Package: " . $customer->getMProfile->name . " Monthly Bill: " . $customer->bill_amount . " Billing Last Date: " . Carbon::parse($customer->exp_date)->format('d-M-Y') . " Thanks & Regards " . $customer->getCompany->company_name;
                        sendSms($customer->phone, $message);

                        $transaction['date'] = now();
                        $transaction['local_id'] = $customer->id;
                        $transaction['type'] = 12;
                        $transaction['company_id'] = $customer->company_id;
                        $transaction['note'] = $customer->name ?? "" . " Disabled By Software Reason: Today Expire date";
                        Transaction::create($transaction);
                    }
                }
                return "Billing expired update successfully";
            } catch (\Exception $e) {
                dd('error: ' . $e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile());
            }
        })->timezone('Asia/Dhaka')->daily()->at($time);
       }

        // Send all customer when month start
        $schedule->call(function () {
          Artisan::call('monthlysms:send');
        })->monthlyOn(1, '9:00');

        // deducted fun macreseller customer when line is active
        $schedule->call(function () {
            try {
                $macResellers = MacReseller::get();
                foreach ($macResellers as $macReseller) {
                    if ($macReseller->expire_date < date('d')) {
                        $customers = Customer::where('company_id', $macReseller->getUser->company_id)->whereIn('disabled', ['false', 10])->get();
                        foreach ($customers  as  $customer) {
                            $charge = 0;
                            if ($macReseller->reseller_type == "prepaid") {

                                if ($customer->protocol_type_id == 3) {
                                    $charge = $macReseller->tariff->package->where('m_profile_id', $customer->m_p_p_p_profile)->pluck('rate')->first();
                                } elseif ($customer->protocol_type_id == 1) {
                                    $charge = $macReseller->tariff->package->where('m_static_id', $customer->queue_id)->pluck('rate')->first();
                                }

                                $dateAsString = Carbon::parse($macReseller->created_at)->format('Y-m');

                                if ($dateAsString == date('Y-m')) {
                                    $dateAsString = Carbon::parse($macReseller->created_at)->format('Y-m-d');
                                    $date = Carbon::parse(Carbon::now()->endOfMonth()->format('Y-m-d'));
                                    $diff = $date->diffInDays($dateAsString);
                                    $charge = (int) (($charge / 30) * $diff);
                                }

                                $checkbill = MacCustomerBill::where('customer_id', $customer->id)->whereMonth('date_', date('m'))->whereYear('date_', date('Y'));
                                if (!$checkbill->first()) {
                                    if ($macReseller->recharge_balance < $charge) {
                                        DB::table('customers')->where('company_id', $macReseller->getUser->company_id)->where('disabled', 'false')->update(['disabled' => '10']);
                                    } else {
                                        DB::table('customers')->where('company_id', $macReseller->getUser->company_id)->where('disabled', '10')->update(['disabled' => 'false']);
                                        $macReseller->update(['recharge_balance' => $macReseller->recharge_balance - $charge]);
                                        $checkbill->create([
                                            'customer_id' => $customer->id,
                                            'date_' => today()->format('Y-m-d'),
                                            'charge' => $charge,
                                            'company_id' =>  $customer->company_id ?? 0,
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }
                return "Billing expired update successfully";
            } catch (\Throwable $th) {
                DB::rollback();
                return "Billing expired update successfully";
            }
        })->everyMinute();

        // $schedule->command('User:Store')->everyFourMinutes();
        $schedule->command('attendance:store')->everyFiveMinutes();

        $schedule->call(function () {
            try {
                $billing = new Billing();
                $billing->start();
                return "Billing Update successfully";
            } catch (\Throwable $th) {
                DB::rollback();
                return "Billing update successfully";
            }
        })->everyMinute();

        $schedule->command('send:meeting-remarks');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
