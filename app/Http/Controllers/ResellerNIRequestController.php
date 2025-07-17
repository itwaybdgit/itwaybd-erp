<?php

namespace App\Http\Controllers;

use App\Models\BandwidthCustomer;
use App\Models\BandwidthCustomerPackage;
use App\Models\District;
use App\Models\Division;
use App\Models\Item;
use App\Models\ResellerNIRequest;
use App\Models\ResellerOptimize;
use App\Models\ResellerUpgradation;
use App\Models\Upozilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ResellerNIRequestController extends Controller
{
    protected $routeName = 'nirequest';
    protected $viewName = 'admin.pages.bandwidthsale.nirequest';

    protected function getModel() {
        return new ResellerNIRequest();
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */

     protected function tableColumnNames()
     {
         return [

             [
                 'label' => 'SL',
                 'data' => 'id',
                 'searchable' => true,
             ],
             [
                 'label' => 'Customer',
                 'data' => 'company_name',
                 'searchable' => false,
                 'relation' => 'customer',
             ],
             [
                 'label' => 'Apply Date',
                 'data' => 'apply_date',
                 'searchable' => false,
             ],
             [
                 'label' => 'Status',
                 'data' => 'status',
                 'searchable' => false,
             ],

             [
                 'label' => 'Action',
                 'data' => 'action',
                 'class' => 'text-nowrap',
                 'orderable' => false,
                 'searchable' => false,
             ],

         ];
     }

    public function index(Request $request): View {
        $page_title = "Reseller NI Request";
        $page_heading = "Reseller NI Request";
        $create_url = route($this->routeName . '.create');
        $ajax_url = route($this->routeName . '.dataProcessing');
        $is_show_checkbox = false;
        $model = $this->getModel()->orderBy('id','DESC')->get();
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        return view('admin.pages.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataProcessing()
    {
        $employeecheck = auth()->user()->employee;
        if($employeecheck){
            $model = $this->getModel()->where('created_by', auth()->user()->id);
        }else{
            $model = $this->getModel();
        }

        return $this->getDataResponse(
            //Model Instance
            $model,
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName,
            true,
            [
                [
                    'method_name' => 'show',
                    'class' => 'btn-info  btn-sm',
                    'fontawesome' => 'fa fa-eye',
                    'text' => '',
                    'title' => 'Show',
                ],
            ]

        );
    }

    public function create(Request $request)
    {
        $page_title = "Reseller NI Request";
        $page_heading = "Reseller NI Request";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');

        $items = Item::where('status', 'active')->get();
        $divisions = Division::get();
        $districts = District::get();
        $upazilas = Upozilla::get();

        $employeecheck = auth()->user()->employee;
        if($employeecheck){
            $customers = BandwidthCustomer::where('created_by',auth()->user()->id)->get();
        }else{
            $customers = BandwidthCustomer::get();
        }
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
            $resellerup = ResellerNIRequest::where('status',"pending")->where('customer_id',$request->customer)->first();

            if($resellerup){
            return redirect()->route('nirequest.index')->with('success', 'Alreaedy Request one!');
            }

            $package = $request->except('_token','customer');

            ResellerNIRequest::create([
                'customer_id'=> $request->customer,
                'package'=>  json_encode($package),
                'apply_date'=> $request->apply_date,
                'status'=>  'pending',
                'sale_head_approve'=>   "1",
                'created_by'=>  auth()->user()->id,
            ]);


            DB::commit();
            return redirect()->route('nirequest.index')->with('success', 'Data Store successfully!');
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
    public function show(ResellerOptimize $optimize)
    {
       $page_title = "Reseller NI Request";
       $page_heading = "Reseller NI Request";
       $back_url = route($this->routeName . '.index');
       $customers = BandwidthCustomer::all();
       $editOption = $optimize;
       $items = Item::where('status', 'active')->get();
       $package = json_decode($optimize->package);
       return view($this->viewName . '.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ResellerOptimize $optimize)
    {
        $page_title = "Reseller NI Request";
        $page_heading = "Reseller NI Request";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');

        $employeecheck = auth()->user()->employee;
        if($employeecheck){
            $customers = BandwidthCustomer::where('created_by',auth()->user()->id)->get();
        }else{
            $customers = BandwidthCustomer::get();
        }
        $items = Item::get();
        $selectedCustomer = BandwidthCustomerPackage::where('bandwidht_customer_id', $optimize->customer_id)->get();

        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ResellerOptimize $optimize)
    {
        try {
            DB::beginTransaction();
            $optimize->update(['apply_date' => $request->date,'status'=>"approve"]);

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
