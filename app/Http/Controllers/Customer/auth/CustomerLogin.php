<?php

namespace App\Http\Controllers\Customer\auth;

use App\Http\Controllers\Controller;
use App\Models\AccountTransaction;
use App\Models\BandwidthSaleInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ResellerCapUncap;
use App\Models\ResellerDowngradation;
use App\Models\ResellerOptimize;
use App\Models\ResellerUpgradation;
class CustomerLogin extends Controller
{
    public function customer(Request $request)
    {
        if($request->method() == "POST"){
          $this->validate($request,[
              'username'=> "required",
              'password'=> "required",
          ]);

          if(Auth::guard('customer')->attempt(['username' => $request->username,'password' => $request->password])){
            return redirect()->route('customer.dashboard');
          }else{
              return back()->with('failed','Invalid Username Or Password');
          }
        }
        return view('auth.customer_login');
    }

    public function dashboard()
    {
        $monthbillgenerate = 0;
        $approve = ResellerOptimize::where('status','pending')->where('customer_id',auth()->guard('bandwidthcustomer')->id() ?? 0)->count();
        $upgradtionapprove = ResellerUpgradation::where('status','pending')->where('customer_id',auth()->guard('bandwidthcustomer')->id() ?? 0)->count();
        $downgradtionapprove = ResellerDowngradation::where('status','pending')->where('customer_id',auth()->guard('bandwidthcustomer')->id() ?? 0)->count();
        $reselleruncap = ResellerCapUncap::where('status','pending')->where('customer_id',auth()->guard('bandwidthcustomer')->id() ?? 0)->count();

        $saleinvoice = BandwidthSaleInvoice::with('detaile')->where("customer_id",auth()->guard("bandwidthcustomer")->id())->where('billing_month', date('F Y'))->get();

        $monthbillgenerate += $saleinvoice->sum('total');

        $monthlydeu = AccountTransaction::where('type', 5)
        ->whereNotIn('account_id', [5,14])
        ->where('customer_id', '=', auth()->guard("bandwidthcustomer")->id())
        ->whereYear('created_at', '=', now()->year)
        ->whereMonth('created_at', '=', now()->month)
        ->selectRaw('sum(debit) as debit, sum(credit) as credit')
        ->first();

    // Calculate the difference
    $differencedeu =$monthlydeu->credit - $monthlydeu->debit;

        $monthlycollected = AccountTransaction::where('type', 5)
        ->whereNotIn('account_id', [5,14])
        ->where('customer_id', '=', auth()->guard("bandwidthcustomer")->id())
        ->whereYear('created_at', '=', now()->year)
        ->whereMonth('created_at', '=', now()->month)
        ->selectRaw('sum(debit) as debit')
        ->first();

    // Get the sum of debit
    $differencecollected = $monthlycollected->debit;
        return view('customer.pages.dashboard',get_defined_vars());
    }


    public function customerlogout()
    {
        //logout user
        auth()->logout();
        // redirect to homepage
        return redirect()->route('customer.login');
    }

}
