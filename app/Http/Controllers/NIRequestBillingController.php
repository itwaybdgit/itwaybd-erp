<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ApprovalRemarks;
use App\Models\BandwidthCustomer;
use App\Models\Business;
use App\Models\ResellerNIRequest;
use App\Models\ResellerOptimize;
use App\Models\ResellerUpgradation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NIRequestBillingController extends Controller
{

    /**
     * String property
     */
    protected $routeName =  'nirequest_billing';
    protected $viewName =  'admin.pages.crm.nirequest_billing_approv';

    protected function getModel()
    {
        return new ResellerNIRequest();
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
                'searchable' => false,
                'relation' => 'customer',
            ],
            [
                'label' => 'Owner name',
                'data' => 'company_owner_name',
                'searchable' => false,
                'relation' => 'customer',
            ],
            [
                'label' => 'Owner phone',
                'data' => 'company_owner_phone',
                'searchable' => false,
                'relation' => 'customer',
            ],

            [
                'label' => 'Kam',
                'data' => 'name',
                'searchable' => false,
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
        $page_title = "Customer";
        $page_heading = "Customer List";
        $ajax_url = route($this->routeName . '.dataProcessing');
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
    public function dataProcessing()
    {
        return $this->getDataResponse(
            //Model Instance
            $this->getModel()->where('bill_head_approve' , 1),
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName,
            true,
            [
                [
                    'method_name' => 'check_validity',
                    'class' => 'btn-success btn-sm',
                    'fontawesome' => 'fa fa-check',
                    'text' => '',
                    'title' => 'Check Validity',
                ],
            ]
        );
    }

    function check_validity(ResellerNIRequest $optimize) {
        $page_heading = "Billing Approve";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.index');
        $businesses = Business::all();
        $customer  = $optimize->customer;
        $package = json_decode($optimize->package);
        return view($this->viewName.'.check_validity',get_defined_vars());
    }

    public function approve($id) {
        $billingApprove = ResellerNIRequest::findOrFail($id);
        $customer = BandwidthCustomer::find($billingApprove->customer_id);
        $billingApprove->bill_head_approve = '2';
        $billingApprove->confirm_bill_approve = '1';
//        if(($customer->connectionport->type ?? "lb") == 'nb'){
//            $billingApprove->tx_pluning_head_approve = '1';
//        }else{
//            $billingApprove->transmission_head_approve = '1';
//        }
        $billingApprove->bill_head_by = auth()->id();
        $billingApprove->save();

        return response()->json(['code' => 200, 'message' => 'Billing approved successfully', 'redirect_url' => route('nirequest_billing.index')]);
    }
}
