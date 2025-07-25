<?php

namespace App\Http\Controllers\Admin\Crm;

use App\Http\Controllers\Controller;
use App\Models\BandwidthCustomer;
use App\Models\BandwidthCustomerPackage;
use App\Models\ConnectedPath;
use App\Models\DataSource;
use App\Models\District;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use App\Models\LeadGeneration;
use App\Models\LegalInfo;
use App\Models\MeetingTime;
use App\Models\Team;
use App\Models\Upozilla;
use Illuminate\Support\Facades\DB;

class LeadGenerationController extends Controller
{

    /**
     * String property
     */
    protected $routeName =  'lead';
    protected $viewName =  'admin.pages.crm.lead';

    protected function getModel()
    {
        return new LeadGeneration();
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
    public function index($ids = null)
    {
        $page_title = "Lead";
        $page_heading = "Lead List";
        $ajax_url = route($this->routeName . '.dataProcessing');
        if($ids){
            $ajax_url = route($this->routeName . '.dataProcessing', $ids);
        }
        $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );

        // dd(get_defined_vars());
        return view('admin.pages.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function dataProcessing($ids = null)
    {
        $employeecheck = auth()->user()->employee;
        if($employeecheck){
            $model = $this->getModel()->where('status','0')->where('created_by', auth()->user()->id);
        }else{
            $model = $this->getModel()->where('status','0');
        }

        if($ids){
            $model = $model->whereIn('id',json_decode($ids));
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
                    'method_name' => 'confirmsale',
                    'class' => 'btn-success btn-sm',
                    'fontawesome' => 'fa fa-check',
                    'text' => '',
                    'title' => 'Confirm Sale',
                ],
                [
                    'method_name' => 'schedule',
                    'class' => 'btn-dark btn-sm',
                    'fontawesome' => 'fa fa-calendar',
                    'text' => '',
                    'title' => 'Show',
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

    public function create() {
        $page_title = "Lead";
        $page_heading = "Lead Form";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $items = Item::where('status', 'active')->get();
        $divisions = Division::get();
        $districts = District::get();
        $upazilas = Upozilla::get();
        $categories = ItemCategory::get();
        $datasources = DataSource::get();
        return view($this->viewName . '.create', get_defined_vars());
    }

    public function store(Request $request) {
         $this->validate($request, [
            'company_name' => ['required'],
            'recurring_type' => ['required'],
            'item_id.*' => ['required'],
            'quantity.*' => ['required'],
            'asking_price.*' => ['required'],
            'company_owner_name' => ['nullable'],
            'license_type' => ['nullable'],
        ]);

        DB::beginTransaction();
        try {
        $store = $request->all();
        $store['contact_person_name'] = implode(',', array_filter($request->contact_person_name) ?? []);
        $store['contact_person_phone'] = implode(',',array_filter($request->contact_person_phone) ?? []);
        $store['contact_person_email'] = implode(',',array_filter($request->contact_person_email) ?? []);


        $store['category_id'] = implode(',',array_filter($request->category_id));
        $store['item_id'] = implode(',',array_filter($request->item_id));
        $store['quantity'] = implode(',',array_filter($request->quantity));
        $store['asking_price'] = implode(',',array_filter($request->asking_price));
        $store['created_by'] = auth()->id();
        $lead = $this->getModel()->create($store);

        $meeting['lead_id'] = $lead->id;
        $meeting['meeting_date'] = $request->meeting_date;
        $meeting['meeting_remarks'] = $request->meeting_remarks;
        $meeting['type'] = 'meeting';

        $followup['lead_id'] = $lead->id;
        $followup['meeting_date'] = $request->follow_up_date;
        $followup['meeting_remarks'] = $request->follow_up_remarks;
        $followup['type'] = 'followup';

        MeetingTime::create($meeting);
        MeetingTime::create($followup);

        DB::commit();
        return back()->with('success', 'Data Store Successfully');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    function schedule(LeadGeneration $lead) {
        $page_heading = "Meeting & Follow up Schedule";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.schedule.store',$lead->id);

        $meetings = MeetingTime::where('lead_id', $lead->id)->where('type','meeting')->orderBy('id',"DESC")->get();
        $followups = MeetingTime::where('lead_id', $lead->id)->where('type','followup')->orderBy('id',"DESC")->get();
        return view('admin.pages.crm.lead.schedule',get_defined_vars());
    }

    public function schedulestore(Request $request,$id) {
         $this->validate($request, [
            'meeting_date' => ['required'],
            'meeting_remarks' => ['required'],
        ]);

        DB::beginTransaction();
        try {
        $meeting['lead_id'] = $id;
        $meeting['meeting_date'] = $request->meeting_date;
        $meeting['meeting_remarks'] = $request->meeting_remarks;
        $meeting['type'] = $request->type;

        MeetingTime::create($meeting);

        DB::commit();
        return back()->with('success', 'Data Store Successfully');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    public function scheduleupdate(Request $request, MeetingTime $schedule) {
         $this->validate($request, [
            'meeting_date' => ['required'],
            'meeting_remarks' => ['required'],
        ]);

        DB::beginTransaction();
        try {

        $schedule->update($request->all());

        DB::commit();
        return back()->with('success', 'Data Store Successfully');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    public function edit(LeadGeneration $lead)
    {
        $page_title = "Lead Edit";
        $page_heading = "Lead Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $lead->id);
        $editinfo = $lead;
        $items = Item::where('status', 'active')->get();
        $divisions = Division::get();
        $districts = District::get();
        $upazilas = Upozilla::get();
        $categories = ItemCategory::get();
        $datasources = DataSource::get();
        return view($this->viewName . '.edit', get_defined_vars());
    }

    public function update(Request $request, LeadGeneration $lead)
    {
        $this->validate($request, [
            'company_name' => ['required'],
            'license_type' => ['nullable'],
            'recurring_type' => ['required'],
            'item_id.*' => ['required'],
            'quantity.*' => ['required'],
            'asking_price.*' => ['required'],
            'company_owner_name' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $update = $request->all();
            $update['contact_person_name'] = implode(',',array_filter($request->contact_person_name) ?? []);
            $update['contact_person_phone'] = implode(',',array_filter($request->contact_person_phone) ?? []);
            $update['contact_person_email'] = implode(',',array_filter($request->contact_person_email) ?? []);

            $update['category_id'] = implode(',',array_filter($request->category_id));
            $update['item_id'] = implode(',',array_filter($request->item_id));
            $update['quantity'] = implode(',',array_filter($request->quantity));
            $update['asking_price'] = implode(',',array_filter($request->asking_price));
            $update['updated_by'] = auth()->id();
            $lead->update($update);

            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

     public function destroy(LeadGeneration $lead)
    {

        $lead->meeting()->delete();
        $lead->delete();
        return back()->with('success', 'Data Destroy Successfully');
    }

     public function confirmsale(LeadGeneration $lead)
    {
        $page_heading = "Confirm Sale";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.confirmsale.store',$lead->id);
        $editinfo = $lead;
        $items = Item::where('status', 'active')->get();
        $connection_paths = ConnectedPath::get();
        $categories = ItemCategory::get();

        return view($this->viewName . '.confirmsale', get_defined_vars());
    }

     public function confirmsalestore(Request $request,LeadGeneration $lead)
    {
       try {
        DB::beginTransaction();
        // dd($request->all());
        $customer = array_merge((array) $request->all(),  $lead->toArray());
        // $customer['installment'] = implode(',',$request->installment);
        // $customer['installment_date'] = implode(',',$request->installment_date);
        $customer['billing_email'] = implode(',',$request->billing_email);

        $customer_id = BandwidthCustomer::create($customer);

        for($j=0;$j < count($request->item_id); $j++){
            $installmentField = 'installment_' . $request->uniqueid[$j];
            $installmentDataField = 'installment_date_' . $request->uniqueid[$j];
            $package['bandwidht_customer_id'] = $customer_id->id;
            $package['category_id'] = $request->category_id[$j];
            $package['item_id'] = $request->item_id[$j];
            $package['qty'] = $request->quantity[$j];

            $package['rate'] = $request->asking_price[$j];
            $package['title_onetime'] = $request->title_onetime_1[$j];
            $package['title_monthly'] = $request->title_monthly[$j];
            $package['title_yearly'] = $request->title_yearly[$j];
            $package['billing_frequency'] = $request->billing_frequency[$j];
            $package['payment_date_monthly'] = $request->payment_date_monthly[$j];
            $package['payment_date_yearly'] = $request->payment_date_yearly[$j];
            $package['installment'] = implode(',', $request->$installmentField);
            $package['installment_date'] = implode(',', $request->$installmentDataField) ;

            if($request->vat_check == "yes"){
                $package['vat'] = $request->vat[$j];
            }else{
                $package['vat'] = 0;
            }
            BandwidthCustomerPackage::create($package);
        }


        $legalinfo['bandwidth_customer_id'] = $customer_id->id;
        $legalinfo['agreement'] = upload_file($request,'agreement');
        $legalinfo['cheque'] = upload_file($request,'cheque');
        $legalinfo['cheque_authorization'] = upload_file($request,'cheque_authorization');
        $legalinfo['cash'] = upload_file($request,'cash');
        $legalinfo['noc_payment_clearance'] = upload_file($request,'noc_payment_clearance');
        $legalinfo['isp_license'] = upload_file($request,'isp_license');
        $legalinfo['conversion'] = upload_file($request,'conversion');
        $legalinfo['renewal'] = upload_file($request,'renewal');
        $legalinfo['trade'] = upload_file($request,'trade');
        $legalinfo['nid'] = upload_file($request,'nid');
        $legalinfo['photo'] = upload_file($request,'photo');
        $legalinfo['tin'] = upload_file($request,'tin');
        $legalinfo['bin'] = upload_file($request,'bin');
        $legalinfo['authorization_letter'] = upload_file($request,'authorization_letter');
        $legalinfo['partnership_deed_org'] = upload_file($request,'partnership_deed_org');
        $legalinfo['partnership_deed'] = upload_file($request,'partnership_deed');
        $legalinfo['power_of_attorney'] = upload_file($request,'power_of_attorney');
        $legalinfo['cert_of_incorporation'] = upload_file($request,'cert_of_incorporation');
        $legalinfo['form_xii'] = upload_file($request,'form_xii');
        $legalinfo['moa_aoa'] = upload_file($request,'moa_aoa');
        $legalinfo['utility_bill'] = upload_file($request,'utility_bill');
        $legalinfo['user_list'] = upload_file($request,'user_list');
        $legalinfo['rent_agreement'] = upload_file($request,'rent_agreement');
        $legalinfo['equipment_agreement'] = upload_file($request,'equipment_agreement');
        $legalinfo['work_order'] = upload_file($request,'work_order');
        $legalinfo['iP_lease_agreement'] = upload_file($request,'iP_lease_agreement');

        LegalInfo::create($legalinfo);

        $lead->update(['status' => "1"]);

        setNotification('team_leader',"New Client Sale Approve Request",route('admin_approv.index'));

        DB::commit();
        return redirect()->route($this->routeName.".index")->with('success', 'Data Updated Successfully');
       } catch (\Throwable $e) {
         DB::rollBack();

         dd('Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
         return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
       }
    }

    function division(Request $request) {
        $division =  District::where('division_id',$request->division_id)->get();
        $options = '<option value="0">Select Option</option>';
        if ($division->isNotEmpty()) {
            foreach ($division as $tj) {
                $options .= '<option value="' . $tj->id . '">' . $tj->district_name .'</option>';
            }
        }
        return $options;
    }

    function upazila(Request $request) {
        $upazilas =  Upozilla::where('district_id',$request->district_id)->get();
        $options = '<option value="0">Select Option</option>';
        if ($upazilas->isNotEmpty()) {
            foreach ($upazilas as $tj) {
                $options .= '<option value="' . $tj->id . '">' . $tj->upozilla_name .'</option>';
            }
        }

        return $options;
    }

    public function getItemsByCategory($id)
    {
        // Retrieve items based on the category ID
        $items = Item::where('category_id', $id)->get();

        // Return items as a JSON response
        return response()->json(['items' => $items]);
    }
}
