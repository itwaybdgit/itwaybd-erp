<?php

namespace App\Http\Controllers\Admin\LicenseType;

use App\Http\Controllers\Controller;
use App\Models\LicenseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LicenseTypeController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'licensetype';
    protected $viewName =  'admin.pages.licensetype';

    protected function getModel()
    {
        return new LicenseType();
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
            //     'relation' => 'employelist',


            // ],
            [
                'label' => 'ID',
                'data' => 'id',
                'searchable' => false,
            ],

            [
                'label' => 'Name',
                'data' => 'name',
                'searchable' => false,

            ],

            // [
            //     'label' => 'Details',
            //     'data' => 'details',
            //     'searchable' => false,

            // ],

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
        $page_title = "Business type List";
        $page_heading = "Business type List";
        $ajax_url = route($this->routeName . '.dataProcessing');
        $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $columns = $this->reformatForRelationalColumnName($this->tableColumnNames());
        return view('admin.pages.index', get_defined_vars());
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Business Type Create";
        $page_heading = "Business Type Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
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
            'name' => ['required'],
            'details' => ['nullable'],
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, licensetype $licensetype)
    {

        $modal_title = 'Business Details';
        $modal_data = $licensetype;

        $html = view('admin.pages.Salary.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function edit(licensetype $licensetype)
    {
        $page_title = "Business Edit";
        $page_heading = "Business Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $licensetype->id);
        $editinfo = $licensetype;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, licensetype $licensetype)
    {
        $valideted = $this->validate($request, [
            'name' => ['required'],
            'details' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $licensetype->update($valideted);
            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
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
    public function destroy(licensetype $licensetype)
    {
        $licensetype->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
