<?php

namespace App\Http\Controllers\Admin\BandwidthSale;

use App\Http\Controllers\Controller;
use App\Models\BandwidthCustomer;
use App\Models\BandwidthCustomerPackage;
use App\Models\ConnectedPath;
use App\Models\District;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Item;
use App\Models\LeadGeneration;
use App\Models\LegalInfo;
use App\Models\Revert;
use App\Models\Upozilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PendingBandwidthCustomerController extends Controller
{

    /**
     * String property
     */

    protected $routeName =  'pending_customer';
    protected $viewName =  'admin.pages.bandwidthsale.pendingbandwidthCustomers';

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
                // 'relation' => 'getMProfile',
            ],
            [
                'label' => 'Owner phone',
                'data' => 'company_owner_phone',
                'searchable' => true,
                // 'relation' => 'getMProfile',
            ],
            [
                'label' => 'Customer Priority',
                'data' => 'customer_priority',
                'searchable' => true,
                // 'relation' => 'getMProfile',
            ],
            [
                'label' => 'Kam',
                'data' => 'name',
                'searchable' => true,
                'relation' => 'kam',
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
        return view('admin.pages.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataProcessing(Request $request)
    {

        $employeecheck = auth()->user()->employee;
        if($employeecheck){
            if (check_access("team_leader")) {
                $model = $this->getModel()->whereIn('created_by',under_team_leader())
                ->where(function ($query)  {
                foreach (['sales_approve','legal_approve','transmission_approve','noc_approve','noc2_approve','billing_approve',"level_confirm"] as $column) {
                    if("level_confirm" == $column){
                        $query->orWhere($column, Null)->orWhere('level_confirm', 1);
                    }else{
                        $query->orWhere($column, '0');
                    }
                 }
                });
            }
            if (check_access("Sales")) {
                $model = $this->getModel()->where('created_by', auth()->user()->id)
                ->where(function ($query)  {
                foreach (['sales_approve','legal_approve','transmission_approve','noc_approve','noc2_approve','billing_approve',"level_confirm"] as $column) {
                    if("level_confirm" == $column){
                        $query->orWhere($column, Null)->orWhere('level_confirm', 1);
                    }else{
                        $query->orWhere($column, '0');
                    }
                 }
                });
            }

            if (!check_access("team_leader") && !check_access("Sales")) {
                $model = $this->getModel()
                ->where(function ($query)  {
                foreach (['sales_approve','legal_approve','transmission_approve','noc_approve','noc2_approve','billing_approve',"level_confirm"] as $column) {
                    if("level_confirm" == $column){
                        $query->orWhere($column, Null)->orWhere('level_confirm', 1);
                    }else{
                        $query->orWhere($column, '0');
                    }
                 }
                });
            }



        }else{
            $model = $this->getModel()
            ->orWhere('sales_approve', '0')
            ->orWhere('legal_approve', '0')
            ->orWhere('transmission_approve', '0')
            ->orWhere('noc_approve', '0')
            ->orWhere('noc2_approve', '0')
            ->orWhere('billing_approve', '0')
            ->orWhere('level_confirm', Null)
            ->orWhere('level_confirm', 1);
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
                [
                    'method_name' => 'destroy',
                    'class' => 'btn-danger btn-sm',
                    'fontawesome' => 'fa fa-trash',
                    'text' => '',
                    'title' => 'Delete',
                    'code' => 'onclick="return confirm(`Are You Sure , you want to Confirm`)"',
                ],
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
        $page_title = "Bandwidth Customer";
        $page_heading = "Bandwidth Customer ";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $items = Item::where('status', 'active')->get();
        $divisions = Division::get();
        $districts = District::get();
        $upazilas = Upozilla::get();

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

            for ($i = 0; $i < count($request->item_id); $i++) {
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
        $legalInfo = $bandwidthCustomer->legalDocument ?? [] ;

        return view($this->viewName . '.show', get_defined_vars());
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

        $legalInfo = $bandwidthCustomer->legalDocument;

        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
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
            BandwidthCustomerPackage::where('bandwidht_customer_id',$bandwidthCustomer->id)->delete();
            for($j=0;$j < count($request->item_id); $j++){
                $package['bandwidht_customer_id'] = $bandwidthCustomer->id;
                $package['item_id'] = $request->item_id[$j];
                $package['qty'] = $request->quantity[$j];
                $package['rate'] = $request->asking_price[$j];

                if($request->vat_check == "yes"){
                    $package['vat'] = $request->vat[$j];
                }else{
                    $package['vat'] = 0;
                }
                BandwidthCustomerPackage::create($package);
            }

            $legalinfo = [];
            $request->file('agreement') ? $legalinfo['agreement'] = upload_file($request, 'agreement') : "";
            $request->file('cheque') ? $legalinfo['cheque'] = upload_file($request, 'cheque') : "";
            $request->file('cheque_authorization') ? $legalinfo['cheque_authorization'] = upload_file($request, 'cheque_authorization') : "";
            $request->file('cash') ? $legalinfo['cash'] = upload_file($request, 'cash') : "";
            $request->file('noc_payment_clearance') ? $legalinfo['noc_payment_clearance'] = upload_file($request, 'noc_payment_clearance') : "";
            $request->file('isp_license') ? $legalinfo['isp_license'] = upload_file($request, 'isp_license') : "";
            $request->file('conversion') ? $legalinfo['conversion'] = upload_file($request, 'conversion') : "";
            $request->file('renewal') ? $legalinfo['renewal'] = upload_file($request, 'renewal') : "";
            $request->file('trade') ? $legalinfo['trade'] = upload_file($request, 'trade') : "";
            $request->file('nid') ? $legalinfo['nid'] = upload_file($request, 'nid') : "";
            $request->file('photo') ? $legalinfo['photo'] = upload_file($request, 'photo') : "";
            $request->file('tin') ? $legalinfo['tin'] = upload_file($request, 'tin') : "";
            $request->file('bin') ? $legalinfo['bin'] = upload_file($request, 'bin') : "";
            $request->file('authorization_letter') ? $legalinfo['authorization_letter'] = upload_file($request, 'authorization_letter') : "";
            $request->file('partnership_deed_org') ? $legalinfo['partnership_deed_org'] = upload_file($request, 'partnership_deed_org') : "";
            $request->file('partnership_deed') ? $legalinfo['partnership_deed'] = upload_file($request, 'partnership_deed') : "";
            $request->file('power_of_attorney') ? $legalinfo['power_of_attorney'] = upload_file($request, 'power_of_attorney') : "";
            $request->file('cert_of_incorporation') ? $legalinfo['cert_of_incorporation'] = upload_file($request, 'cert_of_incorporation') : "";
            $request->file('form_xii') ? $legalinfo['form_xii'] = upload_file($request, 'form_xii') : "";
            $request->file('moa_aoa') ? $legalinfo['moa_aoa'] = upload_file($request, 'moa_aoa') : "";
            $request->file('utility_bill') ? $legalinfo['utility_bill'] = upload_file($request, 'utility_bill') : "";
            $request->file('user_list') ? $legalinfo['user_list'] = upload_file($request, 'user_list') : "";
            $request->file('rent_agreement') ? $legalinfo['rent_agreement'] = upload_file($request, 'rent_agreement') : "";
            $request->file('equipment_agreement') ? $legalinfo['equipment_agreement'] = upload_file($request, 'equipment_agreement') : "";
            $request->file('iP_lease_agreement') ? $legalinfo['iP_lease_agreement'] = upload_file($request, 'iP_lease_agreement') : "";
            $request->file('work_order') ? $legalinfo['work_order'] = upload_file($request, 'work_order') : "";

            LegalInfo::updateOrCreate(['bandwidth_customer_id' => $bandwidthCustomer->id], $legalinfo);

            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }
    public function confirmsale(LeadGeneration $lead)
    {
        $page_heading = "Confirm Sale";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.confirmsale.store', $lead->id);
        $editinfo = $lead;
        $items = Item::where('status', 'active')->get();
        $connection_paths = ConnectedPath::get();
        return view($this->viewName . '.create', get_defined_vars());
    }

    public function confirmsalestore(Request $request, LeadGeneration $lead)
    {
        try {
            DB::beginTransaction();

            $customer = array_merge((array) $request->all(),  $lead->toArray());
            $customer['installment'] = implode(',', $request->installment);
            $customer['installment_date'] = implode(',', $request->installment_date);

            $customer_id = BandwidthCustomer::create($customer);

            for ($j = 0; $j < count($request->item_id); $j++) {
                $package['bandwidht_customer_id'] = $customer_id->id;
                $package['item_id'] = $request->item_id[$j];
                $package['qty'] = $request->quantity[$j];
                $package['rate'] = $request->asking_price[$j];

                if ($request->vat_check == "yes") {
                    $package['vat'] = $request->vat[$j];
                } else {
                    $package['vat'] = 0;
                }
                BandwidthCustomerPackage::create($package);
            }


            $legalinfo['bandwidth_customer_id'] = $customer_id->id;
            $legalinfo['agreement'] = upload_file($request, 'agreement');
            $legalinfo['cheque'] = upload_file($request, 'cheque');
            $legalinfo['cheque_authorization'] = upload_file($request, 'cheque_authorization');
            $legalinfo['cash'] = upload_file($request, 'cash');
            $legalinfo['noc_payment_clearance'] = upload_file($request, 'noc_payment_clearance');
            $legalinfo['isp_license'] = upload_file($request, 'isp_license');
            $legalinfo['conversion'] = upload_file($request, 'conversion');
            $legalinfo['renewal'] = upload_file($request, 'renewal');
            $legalinfo['trade'] = upload_file($request, 'trade');
            $legalinfo['nid'] = upload_file($request, 'nid');
            $legalinfo['photo'] = upload_file($request, 'photo');
            $legalinfo['tin'] = upload_file($request, 'tin');
            $legalinfo['bin'] = upload_file($request, 'bin');
            $legalinfo['authorization_letter'] = upload_file($request, 'authorization_letter');
            $legalinfo['partnership_deed_org'] = upload_file($request, 'partnership_deed_org');
            $legalinfo['partnership_deed'] = upload_file($request, 'partnership_deed');
            $legalinfo['power_of_attorney'] = upload_file($request, 'power_of_attorney');
            $legalinfo['cert_of_incorporation'] = upload_file($request, 'cert_of_incorporation');
            $legalinfo['form_xii'] = upload_file($request, 'form_xii');
            $legalinfo['moa_aoa'] = upload_file($request, 'moa_aoa');
            $legalinfo['utility_bill'] = upload_file($request, 'utility_bill');
            $legalinfo['user_list'] = upload_file($request, 'user_list');
            $legalinfo['rent_agreement'] = upload_file($request, 'rent_agreement');
            $legalinfo['equipment_agreement'] = upload_file($request, 'equipment_agreement');
            $legalinfo['work_order'] = upload_file($request, 'work_order');
            $legalinfo['iP_lease_agreement'] = upload_file($request, 'iP_lease_agreement');

            LegalInfo::create($legalinfo);

            $lead->update(['status' => "1"]);

            DB::commit();
            return redirect()->route($this->routeName . ".index")->with('success', 'Data Updated Successfully');
        } catch (\Throwable $e) {
            DB::rollBack();

            dd('Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
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
        BandwidthCustomerPackage::where('bandwidht_customer_id', $bandwidthCustomer->id)->delete();

        $bandwidthCustomer->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
