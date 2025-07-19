<?php

namespace App\Http\Controllers;

use App\Models\BandwidthCustomer;
use App\Models\BandwidthCustomerPackage;
use App\Models\ConnectedPath;
use App\Models\District;
use App\Models\Division;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\LeadGeneration;
use App\Models\LegalInfo;
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
                    'method_name' => 'confirmsale',
                    'class' => 'btn-success btn-sm',
                    'fontawesome' => 'fa fa-check',
                    'text' => '',
                    'title' => 'Confirm Sale',
                ],
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
    public function confirmsale(ResellerNIRequest $nireq)
    {
        $page_heading = "Confirm Sale";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.confirmsale.store',$nireq->id);
        $editinfo = $nireq;
        $items = Item::where('status', 'active')->get();
        $connection_paths = ConnectedPath::get();
        $categories = ItemCategory::get();

        return view($this->viewName . '.confirmsale', get_defined_vars());
    }

    public function confirmsalestore(Request $request,ResellerNIRequest $nireq)
    {
        try {
            DB::beginTransaction();
            // dd($request->all());
            $customer = array_merge((array) $request->all(),  $nireq->toArray());
            // $customer['installment'] = implode(',',$request->installment);
            // $customer['installment_date'] = implode(',',$request->installment_date);
            $customer['billing_email'] = implode(',',$request->billing_email);

            $customer_id = BandwidthCustomer::where('id', $nireq->customer_id)->first();

            for($j=0;$j < count($request->item_id); $j++){
                $installmentField = 'installment_' . $request->uniqueid[$j];
                $installmentDataField = 'installment_date_' . $request->uniqueid[$j];
                $package['bandwidht_customer_id'] = $customer_id->id;
//                $package['category_id'] = $request->category_id[$j];
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

            $nireq->update(['sale_head_approve'=>   "1"]);

            setNotification('team_leader',"New Client Sale Approve Request",route('admin_approv.index'));

            DB::commit();
            return redirect()->route($this->routeName.".index")->with('success', 'Data Updated Successfully');
        } catch (\Throwable $e) {
            DB::rollBack();

            dd('Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile());
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
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
                'sale_head_approve'=>   "0",
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
