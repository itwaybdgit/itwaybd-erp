<?php

namespace App\Http\Controllers;

use App\Models\BandwidthCustomer;
use App\Models\BandwidthCustomerPackage;
use App\Models\Item;
use App\Models\ResellerDiscontinue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ResellerDiscontinueController extends Controller
{
    protected $routeName = 'discontinue';
    protected $viewName = 'admin.pages.bandwidthsale.discontinue';

    protected function getModel() {
        return new ResellerDiscontinue();
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
        $page_title = "Reseller Discontinue";
        $page_heading = "Reseller Discontinue List";
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
        $page_title = "Reseller Discontinue";
        $page_heading = "Reseller Discontinue";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');

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
        $valideted = $this->validate($request, [
            'customer_id' => ['required'],
            'apply_date' => ['required'],
            'reason' => ['required'],
        ]);


        try {
            DB::beginTransaction();
            $resellerup = ResellerDiscontinue::where('status',"pending")->where('customer_id',$request->customer)->first();

            if($resellerup){
            return redirect()->route('optimize.index')->with('success', 'Alreaedy Request one!');
            }

            $valideted['apply_date'] = $request->apply_date;
            $valideted['sale_head_approve'] = "1";
            $valideted['created_by'] = auth()->user()->id;

            ResellerDiscontinue::create($valideted);
            setNotification("team_leader","New discontinue Approve Request",route('discontinue_salehead.index'));


            DB::commit();
            return redirect()->route('discontinue.index')->with('success', 'Data Store successfully!');
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
    public function show(ResellerDiscontinue $discontinue)
    {
       $page_title = "Reseller Discontinue";
       $page_heading = "Reseller Discontinue";
       $back_url = route($this->routeName . '.index');
       $customers = BandwidthCustomer::all();
       $editOption = $discontinue;
       $customer = $discontinue->customer;
       $items = Item::where('status', 'active')->get();
       return view($this->viewName . '.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ResellerDiscontinue $discontinue)
    {
        $page_title = "Reseller Discontinue";
        $page_heading = "Reseller Discontinue";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');

        $employeecheck = auth()->user()->employee;
        if($employeecheck){
            $customers = BandwidthCustomer::where('created_by',auth()->user()->id)->get();
        }else{
            $customers = BandwidthCustomer::get();
        }

        $items = Item::get();
        $selectedCustomer = BandwidthCustomerPackage::where('bandwidht_customer_id', $discontinue->customer_id)->get();

        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ResellerDiscontinue $discontinue)
    {
        try {
            DB::beginTransaction();
            $discontinue->update(['apply_date' => $request->date,'status'=>"approve"]);

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
