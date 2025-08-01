<?php

namespace App\Console\Commands;

use App\Helpers\Billing;
use App\Models\Customer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use \RouterOS\Query;

class Monthlysms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthlysms:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Is for billing expired';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */


    public function handle()
    {
        $customers = Customer::where('billing_status_id', 5)->get();
        foreach ($customers as $customer) {
            $text = $customer->getCompany->billing_exp_msg;
            $message = messageconvert($customer, $text);
            sendSms($customer->phone, $message);
        }
        return "Billing expired update successfully";
    }
}
