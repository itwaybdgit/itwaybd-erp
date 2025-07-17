<?php

namespace App\Http\Controllers;

use App\Models\BandwidthCustomer;
use App\Models\BandwidthCustomerPackage;
use App\Models\CapUncap;
use App\Models\Item;
use App\Models\ResellerUpgradation;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CapUncapController extends Controller
{

    protected $routeName = 'upgradation';
    protected $viewName = 'admin.pages.bandwidthsale.capuncap';

    protected function getModel() {

        return new CapUncap();

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request): View {
        $page_title = "Reseller Upgradation";
        $page_heading = "Reseller Upgradation List";
        $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $model = $this->getModel()->orderBy('id','DESC')->get();
        // dd(get_defined_vars());
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
        $customers = BandwidthCustomer::all();

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
            ResellerUpgradation::create([
                'customer_id'=> $request->customer,
                'package'=>  json_encode($request->except('_token','total','customer')),
                'apply_date'=>  date('Y-m-d'),
                'status'=>  'pending',
                'created_by'=>  auth()->user()->id,
            ]);

            DB::commit();
            return back()->with('success', 'Data Store Successfully');
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
       return view($this->viewName . '.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            $upgradation->update(['apply_date' => $request->date,'status'=>"approve"]);

            DB::commit();
            return back()->with('success', 'Data Store Successfully');
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
