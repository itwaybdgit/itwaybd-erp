<?php

namespace App\Http\Controllers;

use App\Models\DataSource;
use App\Models\District;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataSourceController extends Controller
{
    protected $routeName =  'data_source';
    protected $viewName =  'admin.pages.data_source';


    protected function getModel()
    {
        return new DataSource();
    }

    protected function tableColumnNames()
    {
        return [
            [
                'label' => 'SL',
                'data' => 'id',
                'searchable' => true,
            ],
            [
                'label' => 'Source',
                'data' => 'name',
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
    public function index()
    {
        $page_title = "Data Source";
        $page_heading = "Data Source List";
        $ajax_url = route($this->routeName . '.dataProcessing');
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
    public function dataProcessing()
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
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Data Source Create";
        $page_heading = "Data Source Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');

        return view($this->viewName . '.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $valideted = $this->validate($request, [
            'name' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $this->getModel()->create($valideted);
            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $this->getError($e));
        }
    }

    public function edit(DataSource $division)
    {
        $page_title = "Data Source Edit";
        $page_heading = "Data Source Edit";

        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $division->id);
        $editinfo = $division;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    public function update(Request $request, DataSource $division)
    {
        $valideted = $this->validate($request, [
            'name' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $division = $division->update($valideted);
            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    public function destroy(DataSource $division)
    {
        $division->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
