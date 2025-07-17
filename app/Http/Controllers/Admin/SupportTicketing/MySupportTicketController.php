<?php

namespace App\Http\Controllers\Admin\SupportTicketing;

use App\Helpers\DataProcessingFile\SupportTicketDataProcessing;
use App\Http\Controllers\Controller;
use App\Models\BandwidthCustomer;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Purchase;
use App\Models\SupportCategory;
use App\Models\SupportStatus;
use App\Models\SupportTicket;
use App\Models\TickerMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MySupportTicketController extends Controller
{
    /**
     * String property
     */

    use SupportTicketDataProcessing;

    protected $routeName =  'my_supportticket';
    protected $viewName =  'admin.pages.supportTicket.supportticket';

    protected function getModel()
    {
        return new SupportTicket();
    }

    protected function tableColumnNames()
    {
        return [
            [
                'label' => 'TT No.',
                'data' => 'complain_number',
                'searchable' => false,
            ],
            [
                'label' => 'Date',
                'data' => 'complain_time',
                'searchable' => false,
            ],
            [
                'label' => 'Company Name',
                'data' => 'company_name',
                'searchable' => true,
                'relation' => 'customer',
            ],
            // [
            //     'label' => 'Client Name',
            //     'data' => 'company_owner_name',
            //     'searchable' => true,
            //     'relation' => 'customer',
            // ],
            [
                'label' => 'Mobile ',
                'data' => 'company_owner_phone',
                'searchable' => true,
                'relation' => 'customer',
            ],
            [
                'label' => 'Complain Type',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'problem',
            ],
            [
                'label' => 'Details',
                'data' => 'note',
                'searchable' => false,
            ],
            // [
            //     'label' => 'Complete Time',
            //     'data' => 'complete_time',
            //     'searchable' => false,
            // ],
            [
                'label' => 'Assigned To',
                'data' => 'name',
                'searchable' => false,
                'relation' => "assignUser",
            ],
            [
                'label' => 'Create By',
                'data' => 'name',
                'searchable' => false,
                'relation' => "createBy",
            ],
            [
                'label' => 'Source',
                'data' => 'data_source',
                'searchable' => false,
            ],
            [
                'label' => 'Status',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'supportstatus',
            ],
            [
                'label' => 'Duration',
                'data' => 'duration',
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index($id = null)
    {
        $page_title = "My Ticket";
        $page_heading = "My Ticket List";
        $ajax_url = route($this->routeName . '.dataProcessing', $id);
        $is_show_checkbox = false;
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        $supportstatus = SupportStatus::whereIn("id", [1, 2])->get();
        return view($this->viewName . '.my_ticket', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataProcessing(Request $request, $id = null)
    {
        $model = $this->getModel()->where("assign_to", auth()->id());

        if ($id) {
            $model = $model->whereIn("status", [$id]);
        } else {
            $model = $model->whereIn("status", [1, 2]);
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
                    'method_name' => 'ticketstatus',
                    'class' => 'btn-info  btn-sm',
                    'fontawesome' => 'fa fa-check',
                    'text' => '',
                    'title' => 'View',
                ],
            ],

        );
    }


    public function ticketstatus(SupportTicket $supportticket)
    {
        $page_title = "Support Ticket Status";
        $page_heading = "Support Ticket Status";
        $back_url = route($this->routeName . '.index');
        $statusupdate = $supportticket;
        $status = SupportStatus::orderBy("order_id", "asc")->get();
        // $customer = Customer::find($supportticket->client_id);
        // $customer = Customer::where('id', $supportticket->client_id)->first();
        $customer = BandwidthCustomer::where('id', $supportticket->client_id)->first();
        $employees = Employee::get();
        return view($this->viewName . '.ticket_status', get_defined_vars());
    }

    public function statusup(Request $request, SupportTicket $supportticket)
    {
        $status["status"] = $request->status;

        if ($request->remark) {
            $message = new TickerMessage();
            $message->ticket_id = $supportticket->id;
            $message->remark = $request->remark;
            $message->user_id = auth()->id();
            $message->save();
        }

        $status["complete_time"] = in_array($request->status, [1, 2]) ? null : now();
        $status["solve_by"] = in_array($request->status, [1, 2]) ? null : auth()->id();
        if ($request->assign_to != 0) {
            $status["assign_to"] = $request->assign_to;
        }
        $supportticket->update($status);
        return redirect()->route($this->routeName . ".index");
    }
}
