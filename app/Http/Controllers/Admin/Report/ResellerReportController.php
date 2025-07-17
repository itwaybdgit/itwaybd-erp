<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Mail\ResellerLedger;
use App\Models\AccountTransaction;
use App\Models\BandwidthCustomer;
use App\Models\Business;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResellerReportController extends Controller
{
    //
    public function index(Request $request)
    {
        $customers = BandwidthCustomer::get();
        if ($request->method() == "POST") {
            $reseller = new AccountTransaction();
            $reseller = $reseller::with('resellerCustomer')->where('type', 5)->where('account_id', "!=", 5);
            if ($request->customer !== 'all') {
                $reseller = $reseller->where('customer_id', $request->customer);
            }
            $reseller = $reseller->get();
        }
        $business = Business::get();
        return view('admin.pages.reports.reseller.index', get_defined_vars());
    }

    public function teamhead(Request $request)
    {
        $teams = Team::get();
        if ($request->method() == "POST") {
            $employee = Employee::where('team',$request->team)->pluck('user_id')->toArray();

            $bandwidthcustomer = new BandwidthCustomer();
            $bandwidthcustomer = $bandwidthcustomer::whereIn('created_by', $employee);
            $bandwidthcustomer = $bandwidthcustomer->whereDate('created_at', ">=" ,$request->from_date);
            $bandwidthcustomer = $bandwidthcustomer->whereDate('created_at', "<=" ,$request->to_date);
            $bandwidthcustomer = $bandwidthcustomer->get();
        }

        $business = Business::get();
        return view('admin.pages.reports.reseller.teamhead', get_defined_vars());
    }

    function invoice(Request $request) {
        $business = Business::find($request->business_id);
        $saleinvoiceid = BandwidthCustomer::find($request->customer);
        $reseller = new AccountTransaction();
        $reseller = $reseller::with('resellerCustomer')->where('type', 5)->where('account_id', "!=", 5);
        if ($request->customer !== 'all') {
            $reseller = $reseller->where('customer_id', $request->customer);
        }
        $reseller = $reseller->get();

        $emails = explode(',',$saleinvoiceid->billing_email);

         foreach($emails as $email){
             Mail::to($email)->send(new ResellerLedger($business,$saleinvoiceid,$reseller));

         }
        return view('admin.pages.reports.reseller.invoice',get_defined_vars());
    }
}
