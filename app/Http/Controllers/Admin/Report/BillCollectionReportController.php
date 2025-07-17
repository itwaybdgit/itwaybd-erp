<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountTransaction;
use App\Models\Billing;
use App\Models\Customer;
use App\Models\Zone;
use Illuminate\Http\Request;

class BillCollectionReportController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::where('company_id', auth()->user()->company_id)->get();
        $zones = Zone::where('company_id', auth()->user()->company_id)->get();

        if ($request->method() == "POST") {

            // $this->validate($request, [
            //     'month' => ['required'],
            // ]);
            $monthlybill = new Billing();
            $monthlybill = $monthlybill->rightJoin('customers', 'customers.id', '=', 'billings.customer_id')
                ->select('customers.name as name', 'customers.username as username', 'customers.phone as phone', 'customers.client_id as client_id', 'customers.zone_id as zone_id', 'billings.*')
                ->where('billings.company_id', auth()->user()->company_id);
            if ($request->customer !== 'all') {
                $monthlybill = $monthlybill->where('billings.customer_id', $request->customer);
            }

            if ($request->zone !== 'all') {
                $monthlybill = $monthlybill->where('customers.zone_id', $request->zone);
            }

            if ($request->type !== 'all') {
                $monthlybill = $monthlybill->where('protocol_type_id', $request->type);
            }

            if ($request->status !== 'all') {
                $monthlybill = $monthlybill->where('billings.status', $request->status);
            }

            if ($request->month) {
                $monthlybill = $monthlybill->whereMonth('billings.date_', date('m', strtotime($request->month)));
            }
            // dd($monthlybill);
            $monthlybill = $monthlybill->get();
        }

        return view('admin.pages.reports.billcollection.index', get_defined_vars());
    }
}
