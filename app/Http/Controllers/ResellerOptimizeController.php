<?php

namespace App\Http\Controllers;

use App\Models\BandwidthCustomer;
use App\Models\BandwidthCustomerPackage;
use App\Models\Item;
use App\Models\ResellerOptimize;
use App\Models\ResellerUpgradation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ResellerOptimizeController extends Controller
{
    protected $routeName = 'optimize';
    protected $viewName = 'admin.pages.bandwidthsale.optimize';

    protected function getModel() {
        return new ResellerOptimize();
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

     public function index(Request $request): View
     {
         $page_title = "Reseller Optimize";
         $page_heading = "Reseller Optimize List";
         $create_url = route($this->routeName . '.create');
         $ajax_url = route($this->routeName . '.dataProcessing');
         $is_show_checkbox = false;
         $model = $this->getModel()->orderBy('id', 'DESC')->get();
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
                // [
                //     'method_name' => 'destroy',
                //     'class' => 'btn-danger btn-sm',
                //     'fontawesome' => 'fa fa-trash',
                //     'text' => '',
                //     'title' => 'Delete',
                //     'code' => 'onclick="return confirm(`Are You Sure , you want to Confirm`)"',
                // ],
            ]

        );
    }

    public function create(Request $request)
    {
        $page_title = "Reseller Optimize";
        $page_heading = "Reseller Optimize";
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
    try {
        // Validate that at least one input field is filled
        $request->validate([
            'change_quantity' => [
                function ($attribute, $value, $fail) use ($request) {
                    if (empty($value[0]) && empty($request->input('quantity')[0])) {
                        $fail("At least one field should be filled.");
                    }
                },
            ],
            'quantity' => [
                function ($attribute, $value, $fail) use ($request) {
                    if (empty($value[0]) && empty($request->input('change_quantity')[0])) {
                        $fail("At least one field should be filled.");
                    }
                },
            ],
        ]);
        DB::beginTransaction();

        // Check if there is already a pending request for the same customer
        $resellerup = ResellerOptimize::where('status', 'pending')
            ->where('customer_id', $request->customer)
            ->first();

        if ($resellerup) {
            return redirect()->route('optimize.index')->with('success', 'Already requested one!');
        }

        // Create package data
        $package = [];
        $local = $request->except('_token', 'total2', 'total1', 'apply_date', 'customer');
        foreach ($local as $key => $item) {
            $packageitem = [];
            foreach ($item as $key1 => $value) {
                // Check if either change_quantity or quantity is filled
                if (!empty($local['change_quantity'][$key1]) || !empty($local['quantity'][$key1])) {
                    // Add the value to the packageitem array
                    $packageitem[] = $value;
                }
            }
            // Add the packageitem to the package array only if at least one field is filled
            if (!empty($packageitem)) {
                $package[$key] = $packageitem;
            }
        }

        $package['total2'] = $request->total2;
        $package['total1'] = $request->total1;

        // Create ResellerOptimize instance
        ResellerOptimize::create([
            'customer_id' => $request->customer,
            'package' => json_encode($package),
            'apply_date' => $request->apply_date,
            'status' => 'pending',
            'sale_head_approve' => "1",
            'created_by' => auth()->user()->id,
        ]);

        setNotification('team_leader',"New Optimize Approve Request",route("optimize_salehead.index"));

        DB::commit();
        return redirect()->route('optimize.index')->with('success', 'Data stored successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('failed', 'Failed to store data: ' . $e->getMessage());
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
       $page_title = "Reseller Optimize";
       $page_heading = "Reseller Optimize";
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
        $page_title = "Reseller Optimize";
        $page_heading = "Reseller Optimize";
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

        $optimize = ResellerOptimize::findOrFail($id);
        $optimize->delete();
        return back()->with('success', 'Data Destroy Successfully');
    }
}
