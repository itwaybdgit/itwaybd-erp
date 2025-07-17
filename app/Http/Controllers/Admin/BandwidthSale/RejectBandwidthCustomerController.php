<?php

namespace App\Http\Controllers\Admin\BandwidthSale;

use App\Http\Controllers\Controller;
use App\Models\BandwidthCustomer;
use App\Models\BandwidthCustomerPackage;
use App\Models\District;
use App\Models\Division;
use App\Models\Item;
use App\Models\LegalInfo;
use App\Models\Revert;
use App\Models\Upozilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RejectBandwidthCustomerController extends Controller
{

    /**
     * String property
     */

    protected $routeName =  'rejectbandwidthCustomers';
    protected $viewName =  'admin.pages.bandwidthsale.rejectbandwidthCustomers';

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
        $page_title = "Reject Bandwidth Customer";
        $page_heading = "Reject Bandwidth Customer List";
        $ajax_url = route($this->routeName . '.dataProcessing');
        // $create_url = route($this->routeName . '.create');
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
        $revert = Revert::where('status', 2)->pluck('table_id');

        return $this->getDataResponse(
            //Model Instance
            $this->getModel()->whereIn('id',$revert),
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
            ]
        );
    }

    public function show(Request $request, BandwidthCustomer $bandwidthCustomer)
    {
        $modal_title = 'Bandwidth Sale Details';
        $customer = $bandwidthCustomer;
        return view($this->viewName . '.show', get_defined_vars());

    }
}
