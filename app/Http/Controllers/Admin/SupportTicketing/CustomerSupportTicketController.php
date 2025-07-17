<?php

namespace App\Http\Controllers\Admin\SupportTicketing;

use App\Helpers\DataProcessingFile\CustomerSupportTicketDataProcessing;
use App\Http\Controllers\Controller;
use App\Models\BandwidthCustomer;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Purchase;
use App\Models\SupportCategory;
use App\Models\SupportStatus;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerSupportTicketController extends Controller
{
    /**
     * String property
     */

    use CustomerSupportTicketDataProcessing;

    protected $routeName =  'bandwidthcustomer.supportticket';
    protected $viewName =  'customer.pages.supportTicket.supportticket';

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
            // [
            //     'label' => 'Client Name',
            //     'data' => 'company_name',
            //     'searchable' => false,
            //     'relation' => 'customer',
            // ],
            // [
            //     'label' => 'Mobile ',
            //     'data' => 'contact_person_phone',
            //     'searchable' => false,
            //     'relation' => 'customer',
            // ],
            [
                'label' => 'Complain Type',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'problem',
            ],
            [
                'label' => 'Details',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'problem',
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
            // [
            //     'label' => 'Action',
            //     'data' => 'action',
            //     'class' => 'text-nowrap',
            //     'orderable' => false,
            //     'searchable' => false,
            // ],
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        $page_title = "Support Ticket";
        $page_heading = "Support Ticket List";
        $ajax_url = route($this->routeName . '.dataProcessing',$id);
        $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        $supportstatus = SupportStatus::get();
        return view($this->viewName . '.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataProcessing(Request $request,$id = null)
    {
        $model = $this->getModel()->where("client_id",auth()->guard("bandwidthcustomer")->id());

        if($id){
            $model = $model->whereIn("status", [$id]);
        }
        return $this->getDataResponse(
            //Model Instance
            $model,
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName,

        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Create New Support Ticket ";
        $page_heading = "Create New Support Ticket ";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $customers = BandwidthCustomer::get();
        $supportCategorys = SupportCategory::get();
        $users = User::get();
        $employees = Employee::where(function($quert){
            $quert->orWhere("type", "LIKE" , "%level_1%");
            $quert->orWhere("type", "LIKE" , "%level_2%");
            $quert->orWhere("type", "LIKE" , "%level_3%");
            $quert->orWhere("type", "LIKE" , "%level_4%");
        })->get();
        $ticketingLastData = SupportTicket::latest('id')->pluck('id')->first() ?? "0";
        $invoice_no = str_pad($ticketingLastData + 1, 5, "0", STR_PAD_LEFT);

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
            'client_id' => ['required'],
            'date' => ['required'],
            'assign_to' => ['nullable'],
            'data_source' => ['required'],
            'problem_category' => ['required'],
            'complain_number' => ['required'],
            'note' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['complain_time'] = now();
            $valideted['created_by'] = auth()->id();
            SupportTicket::create($valideted);
            DB::commit();
            return back()->with('success', 'Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Something was wrong' . $e->getMessage() . 'Line' . $e->getLine() . 'File' . $e->getFile());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function edit(SupportTicket $supportticket)
    {
        $page_title = "Support Ticket Edit";
        $page_heading = "Support Ticket Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $supportticket->id);
        $editinfo = $supportticket;
        $customers = BandwidthCustomer::get();
        $employees = Employee::where(function($quert){
            $quert->orWhere("type", "LIKE" , "%level_1%");
            $quert->orWhere("type", "LIKE" , "%level_2%");
            $quert->orWhere("type", "LIKE" , "%level_3%");
            $quert->orWhere("type", "LIKE" , "%level_4%");
        })->get();
        $supportCategorys = SupportCategory::get();
        $users = User::get();
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SupportTicket $supportticket)
    {
        $valideted = $this->validate($request, [
            'client_id' => ['required'],
            'date' => ['required'],
            'assign_to' => ['nullable'],
            'problem_category' => ['required'],
            'note' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            $valideted['updated_by'] = auth()->id();
            $supportticket->update($valideted);

            DB::commit();
            return back()->with('success', 'Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupportTicket $supportticket)
    {
        if($supportticket->status == 1){
            $supportticket->delete();
            return back()->with('success', 'Data deleted successfully.');
        } else{
            return back()->with('failed', "You can't delete " .($supportticket->supportstatus->name ?? '')." Ticket ");
        }
    }

    public function userDetails(Request $request)
    {
        $userDetail = Customer::find($request->userid);
        return response()->json($userDetail);
    }

    public function status(SupportTicket $supportticket)
    {
        $page_title = "Support Ticket Status";
        $page_heading = "Support Ticket Status";
        $back_url = route($this->routeName . '.index');
        $statusupdate = $supportticket;
        $customer = BandwidthCustomer::find($supportticket->client_id);
        return view($this->viewName . '.status', get_defined_vars());
    }

    public function assign(SupportTicket $supportticket)
    {
      $supportticket->update(["assign_to" => auth()->id()]);
      back()->with('success', 'Status Update successfully.');
      return redirect()->route('my_supportticket.ticketstatus',$supportticket->id);
    }

    public function statusupdate(SupportTicket $supportticket)
    {
        try {
            DB::beginTransaction();
            $valideted['status'] = 'Solved';
            $supportticket->update($valideted);

            DB::commit();
            back()->with('success', 'Status Update successfully.');
            return redirect()->route('supportticket.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }
}
