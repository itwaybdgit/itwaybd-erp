<?php

namespace App\Http\Controllers\Admin\Crm;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\DataSource;
use App\Models\District;
use App\Models\Division;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\LeadGeneration;
use App\Models\MeetingTime;
use App\Models\Upozilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'branch';
    protected $viewName =  'admin.pages.crm.branch';

    protected function getModel()
    {
        return new Branch();
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
                'label' => 'Branch name',
                'data' => 'name',
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
    public function index($ids = null)
    {
        $page_title = "Branch";
        $page_heading = "Branch List";
        $ajax_url = route($this->routeName . '.dataProcessing');
        if($ids){
            $ajax_url = route($this->routeName . '.dataProcessing', $ids);
        }
        $create_url = route($this->routeName . '.create');
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

    public function dataProcessing($ids = null)
    {
        $model = $this->getModel();

        if($ids){
            $model = $model->whereIn('id',json_decode($ids));
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

    public function create() {
        $page_title = "Branch";
        $page_heading = "Branch Form";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        return view($this->viewName . '.create', get_defined_vars());
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => ['required']
        ]);
        $d['name']=$request->input('name');
        $this->getModel()->create($d);
        return back()->with('success', 'Data Created Successfully');
    }
    public function edit(Branch $branch)
    {
        $page_title = "Branch Edit";
        $page_heading = "Branch Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $branch->id);
        $editinfo = $branch;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    public function update(Request $request, Branch $branch)
    {
        $this->validate($request, [
            'name' => ['required'],
        ]);
        $update = $request->all();
        $branch->update($update);

        DB::commit();
        return back()->with('success', 'Data Updated Successfully');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return back()->with('success', 'Data Destroyed Successfully');
    }
}
