<?php

namespace App\Http\Controllers;

use App\Models\Pop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PopController extends Controller {
    //
    protected $routeName = 'pops';
    protected $viewName = 'admin.pages.pops';

    protected function getModel() {
        return new Pop();
    }

    protected function tableColumnNames() {
        return [
            [
                'label' => 'SL',
                'data' => 'id',
                'searchable' => true,
            ],
            [
                'label' => 'POP Name',
                'data' => 'name',
                'searchable' => false,
            ],
            [
                'label' => 'Action',
                'data' => 'action',
                'class' => 'text-wrap',
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
    public function index() {
        $page_title = "POP";
        $page_heading = "POP List";
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
    public function dataProcessing() {
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
    public function create() {
        $page_title = "POP Create";
        $page_heading = "POP Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');

        return view($this->viewName . '.create', get_defined_vars());
    }

    public function store(Request $request) {
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

    public function edit(Pop $pop) {
        $page_title = "POP Edit";
        $page_heading = "POP Edit";

        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $pop->id);
        $editinfo = $pop;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    public function update(Request $request, Pop $pop) {
        $valideted = $this->validate($request, [
            'name' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $pop = $pop->update($valideted);
            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    public function destroy(Pop $pop) {
        $pop->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
