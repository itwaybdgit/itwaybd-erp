<?php

namespace App\Http\Controllers;

use App\Models\Router;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RouterController extends Controller {
    //
    protected $routeName = 'routers';
    protected $viewName = 'admin.pages.routers';

    protected function getModel() {
        return new Router();
    }

    protected function tableColumnNames() {
        return [
            [
                'label' => 'SL',
                'data' => 'id',
                'searchable' => true,
            ],
            [
                'label' => 'Router Name',
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
        $page_title = "Router";
        $page_heading = "Router List";
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
        $page_title = "Router Create";
        $page_heading = "Router Create";
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

    public function edit(Router $router) {
        $page_title = "Router Edit";
        $page_heading = "Router Edit";

        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $router->id);
        $editinfo = $router;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    public function update(Request $request, Router $router) {
        $valideted = $this->validate($request, [
            'name' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $router = $router->update($valideted);
            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    public function destroy(Router $router) {
        $router->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
