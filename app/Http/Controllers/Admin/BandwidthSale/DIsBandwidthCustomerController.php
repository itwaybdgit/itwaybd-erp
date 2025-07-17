<?php

namespace App\Http\Controllers\Admin\BandwidthSale;

use App\Helpers\ResellerDataProcessing;
use App\Http\Controllers\Controller;
use App\Models\BandwidthCustomer;
use App\Models\BandwidthCustomerPackage;
use App\Models\ConnectedPath;
use App\Models\District;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Item;
use App\Models\ResellerDiscontinue;
use App\Models\Upozilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DIsBandwidthCustomerController extends Controller
{
    /**
     * String property
     */
     use ResellerDataProcessing;

    protected $routeName =  'disbandwidthCustomers';
    protected $viewName =  'admin.pages.bandwidthsale.bandwidthCustomers';

    protected function getModel()
    {
        return new BandwidthCustomer();
    }

    protected function tableColumnNames()
    {
        return [
            [
                'label' => 'Sl',
                'data' => 'id',
                'searchable' => false,
            ],
            [
                'label' => 'Company name',
                'data' => 'company_name',
                'searchable' => true,
                // 'relation' => 'getMProfile',
            ],
            [
                'label' => 'Owner name',
                'data' => 'company_owner_name',
                'searchable' => true,
            ],
            [
                'label' => 'Owner phone',
                'data' => 'company_owner_phone',
                'searchable' => true,
            ],
            [
                'label' => 'Kam',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'kam',
            ],
            [
                'label' => 'Team',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'team',
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Bandwidth Sale";
        $page_heading = "Bandwidth Sale List";
        $ajax_url = route($this->routeName . '.dataProcessing');
        $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        return view($this->viewName . '.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataProcessing(Request $request)
    {
        $disconnect = ResellerDiscontinue::where('confirm_bill_approve',2)->pluck('customer_id');
        $employeecheck = auth()->user()->employee;
        if($employeecheck){
            if(auth()->user()->employee->team){
                $model = $this->getModel()->whereIn('id',$disconnect)->where('created_by', auth()->user()->id);
            }else{
                $model = $this->getModel()->whereIn('level_confirm',["2",'3','4'])->whereIn('id',$disconnect);
            }
        }else{
            $model = $this->getModel()->whereIn('id',$disconnect);
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
                // [
                //     'method_name' => 'connection.status',
                //     'class' => 'btn-info ',
                //     'fontawesome' => 'fas fa-toggle-off',
                //     'text' => '',
                //     'title' => 'Connection Status',
                // ],
                [
                    'method_name' => 'show',
                    'class' => 'btn-success btn-sm',
                    'fontawesome' => 'fa fa-eye',
                    'text' => '',
                    'title' => 'SHow Sale',
                ],
                [
                    'method_name' => 'edit',
                    'class' => 'btn-warning btn-sm',
                    'fontawesome' => 'fa fa-edit',
                    'text' => '',
                    'title' => 'Edit',
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $page_title = "Bandwidth Sale Create";
        $page_heading = "Bandwidth Sale Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $items = Item::where('status', 'active')->get();

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
        // dd($request->all());
        $valideted = $this->validate($request, [
            "name" => ["required"],
            "code" => ["nullable"],
            "contact_person" => ["nullable",],
            "email" => ["nullable"],
            "mobile" => ["nullable",],
            "phone" => ["required"],
            "reference_by" => ["nullable"],
            "address" => ["nullable"],
            "remarks" => ["nullable"],
            "facebook" => ["nullable"],
            "skypeid" => ["nullable"],
            "website" => ["nullable"],
            "nttn_info" => ["nullable"],
            "vlan_info" => ["nullable"],
            "vlan_id" => ["nullable"],
            "scr_or_link_id" => ["nullable"],
            "activition_date" => ["nullable",],
            "ipaddress" => ["nullable"],
            "pop_name" => ["nullable"],
            "image" => ["nullable",],
        ]);

        try {
            DB::beginTransaction();
            $valideted['created_by'] = auth()->id();

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('bandwidth_client', 'public');
                $valideted['image'] = $path;
            }

            $bandwithcustomer =  $this->getModel()->create($valideted);

            for($i = 0;$i < count($request->item_id);$i++){
                $bandwidth = new BandwidthCustomerPackage();
                $bandwidth->bandwidht_customer_id = $bandwithcustomer->id;
                $bandwidth->item_id = $request->item_id[$i];
                $bandwidth->description = $request->description[$i];
                $bandwidth->unit = $request->unit[$i];
                $bandwidth->qty = $request->qty[$i];
                $bandwidth->rate = $request->rate[$i];
                $bandwidth->vat = $request->vat[$i];
                $bandwidth->save();
            }
            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Something was wrong' . 'Message' . $e->getMessage() . 'File' . $e->getFile());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemCategory  $ItemCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, BandwidthCustomer $bandwidthCustomer)
    {
        $modal_title = 'Bandwidth Sale Details';
        $customer = $bandwidthCustomer;

        $html = view('admin.pages.bandwidthsale.bandwidthCustomers.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemCategory  $ItemCategory
     * @return \Illuminate\Http\Response
     */

    public function status(BandwidthCustomer $bandwidthCustomer)
    {
        $modal_title = 'Bandwidth Sale Details';
        $customer = $bandwidthCustomer;

        $html = view('admin.pages.bandwidthsale.bandwidthCustomers.status', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemCategory  $ItemCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(BandwidthCustomer $bandwidthCustomer)
    {
        $page_title = "Bandwidth Customer Edit";
        $page_heading = "Bandwidth Customer Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $bandwidthCustomer->id);
        $editinfo = $bandwidthCustomer;

        $items = Item::where('status', 'active')->get();
        $divisions = Division::get();
        $districts = District::get();
        $upazilas = Upozilla::get();
        $connection_paths = ConnectedPath::get();

        $legalInfo = $bandwidthCustomer->legalDocument ?? [] ;

        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemCategory  $ItemCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BandwidthCustomer $bandwidthCustomer)
    {
        $this->validate($request, [
            'company_name' => ['required'],
            'license_type' => ['required'],
            'company_owner_name' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $update = $request->all();
            $update['contact_person_name'] = implode(',', $request->contact_person_name);
            $update['contact_person_phone'] = implode(',', $request->contact_person_phone);

            $update['updated_by'] = auth()->id();
            $bandwidthCustomer->update($update);

            // for($i = 0;$i < count($request->item_id);$i++){
            //     $bandwidth = new BandwidthCustomerPackage();
            //     $bandwidth->bandwidht_customer_id = $bandwidthCustomer->id;
            //     $bandwidth->item_id = $request->item_id[$i];
            //     $bandwidth->description = $request->description[$i];
            //     $bandwidth->unit = $request->unit[$i];
            //     $bandwidth->qty = $request->qty[$i];
            //     $bandwidth->rate = $request->rate[$i];
            //     $bandwidth->vat = $request->vat[$i];
            //     $bandwidth->save();
            // }

            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemCategory  $ItemCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(BandwidthCustomer $bandwidthCustomer)
    {
        BandwidthCustomerPackage::where('bandwidht_customer_id',$bandwidthCustomer->id)->delete();

        $bandwidthCustomer->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
