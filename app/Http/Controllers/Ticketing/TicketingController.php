<?php

namespace App\Http\Controllers\Ticketing;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\SupportCategory;
use App\Models\SupportTicket;
use App\Models\Ticketing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TicketingController extends Controller
{
    protected $routeName =  'ticketing';
    protected $viewName =  'customer.pages.ticketing';

    protected function getModel()
    {
        return new SupportTicket();
    }

    protected function tableColumnNames()
    {
        return [
            // [
            //     'label' => 'Show in Table header',
            //     'data' => 'action',
            //     'class' => 'text-nowrap', class name
            //     'orderable' => false,
            //     'searchable' => false,
            // ],
            [
                'label' => 'Sl',
                'data' => 'id',
                'searchable' => false,
            ],
            [
                'label' => 'Complain Number',
                'data' => 'complain_number',
                'searchable' => false,
            ],
            [
                'label' => 'Complain Category',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'problem',
            ],
            [
                'label' => 'Note',
                'data' => 'note',
                'searchable' => false,
            ],

            [
                'label' => 'Complain Time',
                'data' => 'created_at',
                'searchable' => false,
            ],
            [
                'label' => 'Status',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'supportstatus',
            ],
            [
                'label' => 'Solved Time',
                'data' => 'complete_time',
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
    public function index()
    {
        $page_title = "Ticketing";
        $page_heading = "Ticketing List";
        $ajax_url = route($this->routeName . '.dataProcessing');
        $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $total_ticket = SupportTicket::whereMonth('created_at', Carbon::now()->month)->where('client_id', auth()->guard('customer')->id())
            ->count();
        $pending_ticket = SupportTicket::where('client_id', auth()->guard('customer')->id())->where('status', 1)->count();
        $processing_ticket = SupportTicket::where('client_id', auth()->guard('customer')->id())->where('status', 2)->count();
        $solved_ticket = SupportTicket::where('client_id', auth()->guard('customer')->id())->where('status', 3)->count();
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

        $model = $this->getModel();

        $model = $model->where('client_id', auth()->guard('customer')->id());

        return $this->getDataResponse(
            //Model Instance
            $model,
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName,

        );
    }

    public function create()
    {
        $page_title = "Ticketing Create";
        $page_heading = "Ticketing Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $supportcategories = SupportCategory::get();
        return view($this->viewName . '.create', get_defined_vars());
    }

    // public function store(Request $request)
    // {

    //     $valideted = $this->validate($request, [
    //         'complain_number' => ['nullable'],
    //         'problem_category' => ['nullable'],
    //         'attachment' => ['nullable'],
    //         'note' => ['nullable'],

    //     ]);

    //     try {
    //         DB::beginTransaction();
    //         if ($file = $request->file('attachment')) {
    //             $destinationPath = 'file/';
    //             $uploadfile = date('YmdHis') . "." . $file->getClientOriginalExtension();
    //             $file->move($destinationPath, $uploadfile);
    //             $valideted['client_id'] = auth()->guard('customer')->id();
    //             $valideted['attachments'] = $uploadfile;
    //             $valideted['complain_time'] = Carbon::now();
    //             $this->getModel()->create($valideted);
    //         } else {
    //             $valideted['client_id'] = auth()->guard('customer')->id();
    //             $valideted['complain_time'] = Carbon::now();
    //             $this->getModel()->create($valideted);
    //         }

    //         DB::commit();
    //         return back()->with('success', 'Data Store Successfully');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return back()->with('failed', $this->getError($e));
    //     }
    // }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'complain_number' => ['nullable'],
            'problem_category' => ['nullable'],
            'attachment' => ['nullable'],
            'note' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();


            $validated['client_id'] = auth()->guard('customer')->id();
            $validated['complain_time'] = Carbon::now();


            $validated['assign_to'] = 1;
            $validated['data_source'] = 'web';
            $validated['date'] = Carbon::now();


            if ($file = $request->file('attachment')) {
                $destinationPath = 'file/';
                $uploadfile = date('YmdHis') . "." . $file->getClientOriginalExtension();
                $file->move($destinationPath, $uploadfile);
                $validated['attachments'] = $uploadfile;
            }

            $this->getModel()->create($validated);

            DB::commit();
            return back()->with('success', 'Ticket created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $this->getError($e));
        }
    }
}
