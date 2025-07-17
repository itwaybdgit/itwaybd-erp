<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BandwidthCustomerPackage;


class ReportReportController extends Controller
{

    public function billingperiod(Request $request)
    {
        if ($request->method() == "POST") {


            $billing = BandwidthCustomerPackage::with('item', 'customer') // Eager load the related 'item'
                ->where(function ($query) use ($request) {
                    // Check for the 'payment_date_monthly' for the selected month
                    $query->whereMonth('payment_date_monthly', date('m', strtotime($request->month)))
                        ->orWhereMonth('payment_date_yearly', date('m', strtotime($request->month)));

                    // Check for the installments' date in the 'installment_date' column
                    $query->orWhere("installment_date", "LIKE", "%" . date('Y-m', strtotime($request->month)) . "%");

                });

            if ($request->billing_frequency != "All") {
                $billing = $billing->where("billing_frequency", $request->billing_frequency);
            }

            $billing = $billing->get();
        }

        return view('report.billingperiod', get_defined_vars());
    }
}
