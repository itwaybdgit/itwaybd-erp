<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\DataProcessingFile\TicketReportDataProcessing;
use App\Models\BandwidthCustomer;
use App\Models\Employee;
use App\Models\SupportCategory;
use App\Models\SupportStatus;
use App\Models\SupportTicket;

class TicketReportController extends Controller
{
    /**
     * String property
     */
    use TicketReportDataProcessing;
    protected $routeName =  'reports';
    protected $viewName =  'admin.pages.reports';

    protected function getModel()
    {
        return new SupportTicket();
    }

    protected function tableColumnNames()
    {
        return [
            [
                'label' => "Id",
                'data' => "complain_number",
                'searchable' => false,
            ],
            [
                'label' => "Customer",
                'data' => "company_name",
                'customesearch' => "client_id",
                'searchable' => false,
                'relation' => "customer",
            ],
            [
                'label' => "Date",
                'data' => "date",
                'searchable' => false,
            ],
            [
                'label' => "Complain Time",
                'data' => "complain_time",
                'searchable' => false,
            ],
            [
                'label' => "Source",
                'data' => "data_source",
                'searchable' => false,
            ],
            [
                'label' => "Complete Time",
                'data' => "complete_time",
                'searchable' => false,
            ],
            [
                'label' => "Complain Category",
                'data' => "name",
                'customesearch' => "problem_category",
                'searchable' => false,
                'relation' => "problem",
            ],
            [
                'label' => "Status",
                'data' => "name",
                'customesearch' => "status",
                'searchable' => false,
                'relation' => "supportstatus",
            ],
            [
                'label' => "Complain",
                'data' => "note",
                'searchable' => false,
            ],
            [
                'label' => "Remark",
                'data' => "remark",
                'searchable' => false,
            ],
            [
                'label' => "Open Ticket",
                'data' => "name",
                'searchable' => false,
                'relation' => "createBy",
            ],
            [
                'label' => "Assign Person",
                'data' => "name",
                'customesearch' => "assign_to",
                'searchable' => false,
                'relation' => "assignUser",
            ],
            [
                'label' => "Solve By",
                'data' => "name",
                'searchable' => false,
                'relation' => "solveby",
            ],
            [
                'label' => "Status",
                'data' => "status",
                'searchable' => false,
            ],
            [
                'label' => "Duration",
                'data' => "duration",
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
        $page_title = "Ticket Report";
        $page_heading = "Ticket Report";
        $ajax_url = route($this->routeName . '.dataProcessing.ticket');
        // $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );

        $customer  = BandwidthCustomer::get();
        $assign_persons = Employee::where(function($quert){
            $quert->orWhere("type", "LIKE" , "%level_1%");
            $quert->orWhere("type", "LIKE" , "%level_2%");
            $quert->orWhere("type", "LIKE" , "%level_3%");
            $quert->orWhere("type", "LIKE" , "%level_4%");
        })->get();
        $status = SupportStatus::get();
        $complaincategorys = SupportCategory::get();
        return view('admin.pages.reports.ticketing.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataProcessing(Request $request)
    {
        return $this->getDataResponse(
            //Model Instance
            $this->getModel(),
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName
        );
    }
}
