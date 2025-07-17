<?php

namespace App\Http\Controllers;

use App\Models\BandwidthCustomer;
use App\Models\BandwidthCustomerPackage;
use App\Models\Item;
use App\Models\ResellerCapUncap;
use App\Models\ResellerDowngradation;
use App\Models\ResellerUpgradation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ResellerCapUncapController extends Controller {
    protected $routeName = 'capuncap';
    protected $viewName = 'admin.pages.bandwidthsale.capuncap';

    protected function getModel() {
        return new ResellerCapUncap();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request): View {
        $page_title = "Reseller Uncap";
        $page_heading = "Reseller Uncap";
        $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;

        $employeecheck = auth()->user()->employee;
        if($employeecheck){
            $model = $this->getModel()->where('created_by', auth()->user()->id);
        }else{
            $model = $this->getModel();
        }
        $model = $model->orderBy('id','DESC')->get();
        return view($this->viewName . '.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $page_title = "Reseller capuncap";
        $page_heading = "Reseller capuncap";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $customers = BandwidthCustomer::where('created_by',auth()->user()->id)->get();
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
            ResellerCapUncap::create([
                'customer_id' => $request->customer,
                'package' => json_encode($request->except('_token','total','customer',"apply_date")),
                'apply_date' => $request->apply_date,
                'status' => 'pending',
                'created_by' => auth()->user()->id,
                'sale_head' => 1,
            ]);

            setNotification("team_leader","New Sale Head Aprrove Request",route('uncap_salehead.index'));


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
    public function show(ResellerCapUncap $capuncap)
    {
       $page_title = "Reseller capuncap";
       $page_heading = "Reseller capuncap";
       $back_url = route($this->routeName . '.index');
       $customers = BandwidthCustomer::all();
       $editOption = $capuncap;
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
    public function update(Request $request, ResellerCapUncap $capuncap)
    {
        try {
            DB::beginTransaction();
            $capuncap->update(['apply_date' => $request->date]);

            $capuncap = ResellerCapUncap::find($capuncap->id);

            // Decode the JSON data from the request
            $packageData = [
                'item_id' => $request->item_id,
                'quantity' => $request->quantity,
                'customer_id' => $request->customer_id,
                // 'old_quantity' => $request->old_quantity,
                // 'total_quantity' => $request->total_quantity
            ];

            // Update the package column
            $capuncap->update(['package' => json_encode($packageData)]);

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
