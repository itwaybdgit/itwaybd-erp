<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ApprovalRemarks;
use App\Models\BandwidthCustomer;
use App\Models\Business;
use App\Models\Item;
use App\Models\ResellerDiscontinue;
use App\Models\ResellerOptimize;
use App\Models\ResellerUpgradation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscontinueConfrimBillingController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'discontinue_confrim_billing';
    protected $viewName =  'admin.pages.crm.discontinue_confrim_billing';

    protected function getModel()
    {
        return new ResellerDiscontinue();
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
            $this->getModel()->where('confirm_bill_approve',1),
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

    function check_validity(ResellerDiscontinue $discontinue) {
        $page_heading = "Billing Approve";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.index');
        $billingRemarks = ApprovalRemarks::where('type', 'billing_approve')->where('customer_id', $discontinue->id)->where('created_by', Auth::user()->id)->get();
        $businesses = Business::all();
        $items = Item::all();
        $customer = $discontinue->customer;
        return view($this->viewName.'.check_validity',get_defined_vars());
    }

    public function confirm(Request $request, ResellerDiscontinue $discontinue) {

    $discontinue->update([
            'confirm_bill_approve' => 2,
            'pending_status' => 1,
            'confirm_bill_by' => auth()->id(),
            'apply_date' => $request->apply_date
    ]);

    return redirect()->route('discontinue_confrim_billing.index')->with('success', 'Bill Generate successfully!');
    }
}
