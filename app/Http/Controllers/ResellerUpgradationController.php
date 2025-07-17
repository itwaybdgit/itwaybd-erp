<?php

namespace App\Http\Controllers;

use App\Models\BandwidthCustomer;
use App\Models\BandwidthCustomerPackage;
use App\Models\Item;
use App\Models\ResellerUpgradation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ResellerUpgradationController extends Controller
{

    protected $routeName = 'upgradation';
    protected $viewName = 'admin.pages.bandwidthsale.upgradation';

    protected function getModel()
    {
        return new ResellerUpgradation();
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request): View
    {
        $page_title = "Reseller Upgradation";
        $page_heading = "Reseller Upgradation List";
        $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;

        $employeecheck = auth()->user()->employee;
        if ($employeecheck) {
            $model = $this->getModel()->where('created_by', auth()->user()->id);
        } else {
            $model = $this->getModel();
        }

        $model = $model->orderBy('id', 'DESC')->get();
        return view($this->viewName . '.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $page_title = "Reseller Upgradation";
        $page_heading = "Reseller Upgradation";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $customers = BandwidthCustomer::where('created_by', auth()->user()->id)->get();
        $items = Item::get();
        if (isset($request->customer)) {
            $selectedCustomer = BandwidthCustomerPackage::where('bandwidht_customer_id', $request->customer)->get();
        } else {
            $selectedCustomer = false;
        }
        return view($this->viewName . '.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $resellerup = ResellerUpgradation::where('status', "pending")->where('customer_id', $request->customer)->first();

            if ($resellerup) {
                return redirect()->route('upgradation.index')->with('success', 'Alreaedy Request one!');
            }

            ResellerUpgradation::create([
                'customer_id' => $request->customer,
                'package' =>  json_encode($request->except('_token', 'total', 'customer')),
                'apply_date' => $request->apply_date,
                'status' =>  'pending',
                'created_by' =>  auth()->user()->id,
            ]);
            setNotification('team_leader', "New upgradtion Approve Request",route('upgradtion_salehead.index'));


            $customer = BandwidthCustomer::find($request->customer);
            $customer->sales_approve = "2";
            $customer->save();

            DB::commit();
            return redirect()->route('upgradation.index')->with('success', 'Data Store successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $this->getError($e));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ResellerUpgradation $upgradation)
    {
        $page_title = "Reseller Upgradation";
        $page_heading = "Reseller Upgradation";
        $back_url = route($this->routeName . '.index');
        $customers = BandwidthCustomer::all();
        $editOption = $upgradation;
        $items = Item::where('status', 'active')->get();
        $resellerUpgradation = ResellerUpgradation::where('customer_id', $upgradation->customer_id)->first();
        $package = json_decode($resellerUpgradation->package);
        return view($this->viewName . '.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ResellerUpgradation $upgradation)
    {
        $page_title = "Reseller Upgradation";
        $page_heading = "Reseller Upgradation";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $customers = BandwidthCustomer::where('created_by', auth()->user()->id)->get();
        $items = Item::get();
        $editOption = $upgradation;
        $package = json_decode($upgradation->package);
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ResellerUpgradation $upgradation)
    {
        try {
            DB::beginTransaction();

            $upgradation->update([
                'package' => json_encode($request->except('_token', 'total', 'customer')),
                'apply_date' => $request->apply_date,
            ]);
            DB::commit();
            return back()->with('success', 'Data Updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $this->getError($e));
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
