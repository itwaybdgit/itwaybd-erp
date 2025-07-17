<?php

namespace App\Http\Controllers\Admin\Crm;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Division;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\LeadGeneration;
use App\Models\MeetingTime;
use App\Models\Upozilla;
use Illuminate\Support\Facades\DB;

class FollowUpListController extends Controller
{

    /**
     * String property
     */
    protected $routeName =  'followup';
    protected $viewName =  'admin.pages.crm.followup';

    protected function getModel()
    {
        return new MeetingTime();
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
                'relation' => 'lead',
            ],
            [
                'label' => 'Owner name',
                'data' => 'company_owner_name',
                'searchable' => false,
                'relation' => 'lead',
            ],
            [
                'label' => 'Owner phone',
                'data' => 'company_owner_phone',
                'searchable' => false,
                'relation' => 'lead',
            ],
            [
                'label' => 'Customer Priority',
                'data' => 'customer_priority',
                'searchable' => false,
                'relation' => 'lead',
            ],
            [
                'label' => 'Date/Time',
                'data' => 'meeting_date',
                'searchable' => false,
            ],
            [
                'label' => 'Note',
                'data' => 'meeting_remarks',
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
        $page_title = "Today Follow Up";
        $page_heading = "Today Follow Up List";
        $ajax_url = route($this->routeName . '.dataProcessing');
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
    public function dataProcessing()
    {
        return $this->getDataResponse(
            //Model Instance
            $this->getModel()->whereDate('meeting_date', date('Y-m-d'))->where('type','meeting'),
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName,

        );
    }
}
