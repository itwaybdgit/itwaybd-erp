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
use App\Models\ItemCategory;
use App\Models\LegalInfo;
use App\Models\ResellerDiscontinue;
use App\Models\Upozilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BandwidthCustomerController extends Controller
{
    /**
     * String property
     */
    use ResellerDataProcessing;

    protected $routeName =  'bandwidthCustomers';
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
        $disconnect = ResellerDiscontinue::where('confirm_bill_approve', 2)->pluck('customer_id');
        $employeecheck = auth()->user()->employee;
        if ($employeecheck) {
            if (check_access("team_leader")) {
                $model = $this->getModel()->whereIn('level_confirm', ["2", '3', '4'])->whereNotIn('id', $disconnect)->whereIn('created_by', under_team_leader());
            }

            if (check_access("Sales")) {
                $model = $this->getModel()->whereIn('level_confirm', ["2", '3', '4'])->whereNotIn('id', $disconnect)->where('created_by', auth()->user()->id);
            }

            if (!check_access("team_leader") && !check_access("Sales")) {
                $model = $this->getModel()->whereIn('level_confirm', ["2", '3', '4'])->whereNotIn('id', $disconnect);
            }
        } else {
            $model = $this->getModel()->whereIn('level_confirm', ["2", '3', '4'])->whereNotIn('id', $disconnect);
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
        $page_title = "Bandwidth Sale Create";
        $page_heading = "Bandwidth Sale Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $items = Item::where('status', 'active')->get();
        $divisions = Division::get();
        $districts = District::get();
        $upazilas = Upozilla::get();
        $connection_paths = ConnectedPath::get();
        $categories = ItemCategory::get();

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
            'company_name' => ['required'],
            'license_type' => ['nullable'],
            'company_owner_name' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $input = $request->all();
            $input['contact_person_name'] = implode(',', $request->contact_person_name);
            $input['contact_person_phone'] = implode(',', $request->contact_person_phone);
            $input['updated_by'] = auth()->id();
            $input['sales_approve'] = 1;
            $input['legal_approve'] = 1;
            $input['transmission_approve'] = 1;
            $input['noc_approve'] = 1;
            $input['noc2_approve'] = 1;
            $input['billing_approve'] = 1;
            $input['level_confirm'] = 2;

            if ($request->hasFile('invoice_logo')) {
                $image = $request->file('invoice_logo');
                $imageName = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/invoice_logo'), $imageName);
                $input['invoice_logo'] = "/uploads/invoice_logo/" . $imageName;
            }


            $bandwithcustomer =  $this->getModel()->create($input);

            for ($i = 0; $i < count($request->item_id); $i++) {
                $bandwidth = new BandwidthCustomerPackage();
                $bandwidth->bandwidht_customer_id = $bandwithcustomer->id;
                $bandwidth->item_id = $request->item_id[$i];
                $bandwidth->qty = $request->quantity[$i];
                $bandwidth->rate = $request->asking_price[$i];
                $bandwidth->vat = $request->vat[$i] ?? 0;

                $installmentField = 'installment_' . $request->uniqueid[$i];
                $installmentDataField = 'installment_date_' . $request->uniqueid[$i];

                $bandwidth->title_onetime = $request->title_onetime_1[$i];
                $bandwidth->title_monthly = $request->title_monthly[$i];
                $bandwidth->title_yearly = $request->title_yearly[$i];
                $bandwidth->billing_frequency = $request->billing_frequency[$i];
                $bandwidth->payment_date_monthly = $request->payment_date_monthly[$i];
                $bandwidth->payment_date_yearly = $request->payment_date_yearly[$i];
                $bandwidth->installment = implode(',', $request->$installmentField);
                $bandwidth->installment_date = implode(',', $request->$installmentDataField);
                $bandwidth->category_id = $request->category_id[$i];

                $bandwidth->save();
            }


            $legalinfo['bandwidth_customer_id'] = $bandwithcustomer->id;
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

            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Something was wrong' . 'Message' . $e->getMessage() . 'File' . $e->getFile() . "Line" . $e->getLine());
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
        $legalInfo = $bandwidthCustomer->legalDocument ?? [];
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
        $categories = ItemCategory::get();
        $connection_paths = ConnectedPath::get();

        $legalInfo = $bandwidthCustomer->legalDocument ?? [];

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
        // Validate the request
        $this->validate($request, [
            'company_name' => ['required'],
            'license_type' => ['nullable'],
            'company_owner_name' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            // Update the BandwidthCustomer
            $update = $request->all();
            $update['contact_person_name'] = implode(',', $request->contact_person_name);
            $update['contact_person_phone'] = implode(',', $request->contact_person_phone);
            $update['updated_by'] = auth()->id();

            if ($request->hasFile('invoice_logo')) {

                if($bandwidthCustomer->invoice_logo && file_exists(public_path($bandwidthCustomer->invoice_logo))) {
                        unlink(public_path($bandwidthCustomer->invoice_logo));
                }


                $image = $request->file('invoice_logo');
                $imageName = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/invoice_logo'), $imageName);
                $update['invoice_logo'] = "/uploads/invoice_logo/" . $imageName;
            }




            $bandwidthCustomer->update($update);
            BandwidthCustomerPackage::where("bandwidht_customer_id", $bandwidthCustomer->id)->delete();
            for ($j = 0; $j < count($request->item_id); $j++) {
                $installmentField = 'installment_' . $request->uniqueid[$j];
                $installmentDataField = 'installment_date_' . $request->uniqueid[$j];

                $package['bandwidht_customer_id'] = $bandwidthCustomer->id;
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
                $package['installment_date'] = implode(',', $request->$installmentDataField);

                BandwidthCustomerPackage::create($package);
            }

            $legalinfo = [];
            if ($request->file('agreement')) {
                $legalinfo['agreement'] = upload_file($request, 'agreement');
            }

            if ($request->file('cheque')) {
                $legalinfo['cheque'] = upload_file($request, 'cheque');
            }

            if ($request->file('cheque_authorization')) {
                $legalinfo['cheque_authorization'] = upload_file($request, 'cheque_authorization');
            }

            if ($request->file('cash')) {
                $legalinfo['cash'] = upload_file($request, 'cash');
            }

            if ($request->file('noc_payment_clearance')) {
                $legalinfo['noc_payment_clearance'] = upload_file($request, 'noc_payment_clearance');
            }

            if ($request->file('isp_license')) {
                $legalinfo['isp_license'] = upload_file($request, 'isp_license');
            }

            if ($request->file('conversion')) {
                $legalinfo['conversion'] = upload_file($request, 'conversion');
            }

            if ($request->file('renewal')) {
                $legalinfo['renewal'] = upload_file($request, 'renewal');
            }

            if ($request->file('trade')) {
                $legalinfo['trade'] = upload_file($request, 'trade');
            }

            if ($request->file('nid')) {
                $legalinfo['nid'] = upload_file($request, 'nid');
            }

            if ($request->file('photo')) {
                $legalinfo['photo'] = upload_file($request, 'photo');
            }

            if ($request->file('tin')) {
                $legalinfo['tin'] = upload_file($request, 'tin');
            }

            if ($request->file('bin')) {
                $legalinfo['bin'] = upload_file($request, 'bin');
            }

            if ($request->file('authorization_letter')) {
                $legalinfo['authorization_letter'] = upload_file($request, 'authorization_letter');
            }

            if ($request->file('partnership_deed_org')) {
                $legalinfo['partnership_deed_org'] = upload_file($request, 'partnership_deed_org');
            }

            if ($request->file('partnership_deed')) {
                $legalinfo['partnership_deed'] = upload_file($request, 'partnership_deed');
            }

            if ($request->file('power_of_attorney')) {
                $legalinfo['power_of_attorney'] = upload_file($request, 'power_of_attorney');
            }

            if ($request->file('cert_of_incorporation')) {
                $legalinfo['cert_of_incorporation'] = upload_file($request, 'cert_of_incorporation');
            }
            if ($request->file('form_xii')) {
                $legalinfo['form_xii'] = upload_file($request, 'form_xii');
            }
            if ($request->file('moa_aoa')) {
                $legalinfo['moa_aoa'] = upload_file($request, 'moa_aoa');
            }
            if ($request->file('utility_bill')) {
                $legalinfo['utility_bill'] = upload_file($request, 'utility_bill');
            }
            if ($request->file('user_list')) {
                $legalinfo['user_list'] = upload_file($request, 'user_list');
            }
            if ($request->file('rent_agreement')) {
                $legalinfo['rent_agreement'] = upload_file($request, 'rent_agreement');
            }
            if ($request->file('equipment_agreement')) {
                $legalinfo['equipment_agreement'] = upload_file($request, 'equipment_agreement');
            }
            if ($request->file('iP_lease_agreement')) {
                $legalinfo['iP_lease_agreement'] = upload_file($request, 'iP_lease_agreement');
            }
            if ($request->file('work_order')) {
                $legalinfo['work_order'] = upload_file($request, 'work_order');
            }
            if ($bandwidthCustomer->legalDocument) {
                // Update the existing legalInfo
                $bandwidthCustomer->legalDocument->update($legalinfo);
            } else {
                // Create new legalInfo
                $bandwidthCustomer->legalDocument()->create($legalinfo);
            }
            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something went wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile());
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
