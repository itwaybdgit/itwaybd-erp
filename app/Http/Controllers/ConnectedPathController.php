<?php

namespace App\Http\Controllers;

use App\Models\ConnectedPath;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConnectedPathController extends Controller
{

    protected $routeName =  'connected_path';
    protected $viewName =  'admin.pages.connected_path';


    protected function getModel()
    {
        return new ConnectedPath();
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
                'label' => 'Name',
                'data' => 'name',
                'searchable' => false,
            ],
            [
                'label' => 'Type',
                'data' => 'type',
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
        $page_title = "Connected Path";
        $page_heading = "Connected Path List";
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
        $page_title = "Connected Path Create";
        $page_heading = "Connected Path Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        return view($this->viewName . '.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $valideted = $this->validate($request, [
            'name' => ['required'],
            'details' => ['nullable'],
        ]);
        try {
            DB::beginTransaction();
            $valideted['provider'] = json_encode($request->provider);

            $this->getModel()->create($valideted);
            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $this->getError($e));
        }
    }

    public function edit(ConnectedPath $connectedpath)
    {
        $page_title = "Connected Path Edit";
        $page_heading = "Connected Path Edit";

        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $connectedpath->id);
        $editinfo = $connectedpath;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    public function update(Request $request, ConnectedPath $connectedpath)
    {
        $valideted = $this->validate($request, [
            'name' => ['required'],
            'type' => ['nullable'],
        ]);
        try {
            DB::beginTransaction();

            $valideted['provider'] = json_encode($request->provider);
            $connectedpath = $connectedpath->update($valideted);
            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    public function destroy(ConnectedPath $connectedpath)
    {
        $connectedpath->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
