<?php

namespace Modules\Crm\Http\Controllers;

use App\Models\Branch;
use App\Models\Company;
use App\Models\District;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Upozilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Modules\Crm\Entities\CompanyLocation;

class CompanyLocationController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'company_location';
    protected $viewName =  'crm::admin.pages.companies';

    protected function getModel()
    {
        return new Company();
    }
    protected function getLocModel()
    {
        return new CompanyLocation();
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
                'label' => 'Logo',
                'data' => 'logo',
                'searchable' => false,
            ],
            [
                'label' => 'Compnay Name',
                'data' => 'company_name',
                'searchable' => false,
            ],
            [
                'label' => 'Title',
                'data' => 'website',
                'searchable' => false,
            ],
            [
                'label' => 'Phone',
                'data' => 'phone',
                'searchable' => false,
            ],
            [
                'label' => 'Email',
                'data' => 'email',
                'searchable' => false,
            ],
            [
                'label' => 'Address',
                'data' => 'address',
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
    protected function LocationtableColumnNames()
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
                'label' => 'ID',
                'data' => 'id',
                'searchable' => false,
            ],
            [
                'label' => 'Company Name',
                'data' => 'company_name',
                'searchable' => false,
                'relation' => 'company',
            ],
            [
                'label' => 'Branch Name',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'branch',
            ],
            [
                'label' => 'Division Name',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'division',
            ],
            [
                'label' => 'District Name',
                'data' => 'district_name',
                'searchable' => false,
                'relation' => 'district',
            ],
            [
                'label' => 'Upazila Name',
                'data' => 'upozilla_name',
                'searchable' => false,
                'relation' => 'upazilla',
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
        $page_title = "Company";
        $page_heading = "Company Setup";
        $ajax_url = route($this->routeName . '.dataProcessing');
        // $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        return view('crm::admin.pages.index', get_defined_vars());
    }
    public function locationList(Company $company)
    {
        $page_title = "Company";
        $page_heading = "Company Setup";
        $ajax_url = route($this->routeName . '.location.dataProcessing',[$company->id]);
         $create_url = route($this->routeName . '.create', [$company->id]);
        $is_show_checkbox = false;
        $columns = $this->reformatForRelationalColumnName(
            $this->LocationtableColumnNames()
        );
        return view('crm::admin.pages.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataProcessing(Request $request)
    {
        $employeecheck = auth()->user()->employee;
        if($employeecheck){
            $query=$this->getModel()->where('id', auth()->user()->company_id);
        }else{
            $query=$this->getModel();
        }
        return $this->getDataResponse(
        //Model Instance
            $query,
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName,
            true,
            [
                [
                    'method_name' => 'locationList',
                    'class' => 'btn-warning btn-sm',
                    'fontawesome' => 'fa fa-map-marker',
                    'text' => '',
                    'title' => 'View Locations',
                ]
            ]
        );
    }
    public function locationDataProcessing($company_id)
    {
        $query = CompanyLocation::where('company_id', $company_id);

        if (!$query->exists()) {
            CompanyLocation::create([
                'company_id' => $company_id,
            ]);
        }
        $query = CompanyLocation::where('company_id', $company_id);
        return $this->getDataResponse(
        //Model Instance
            $query,
            //Table Columns Name
            $this->LocationtableColumnNames(),
            //Route name
            $this->routeName,
            true,
            [
                'edit'
            ]

        );
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Company $company)
    {
        $page_title = "Company Location Create";
        $page_heading = "Company Location Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store',[$company->id]);
        $divisions = Division::all();
        $branches = Branch::all();
        return view($this->viewName . '.location.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {

        $validated = $request->validate([
            'branch_id' => ['required', 'unique:company_locations,branch_id'],
            'fields' => ['nullable', 'array'],
            'fields.*' => ['string']
        ]);

        try {
            DB::beginTransaction();

            $this->getLocModel()->create([
                'fields' => $validated['fields'] ?? [],
                'branch_id' => $request->branch_id,
                'division_id' => $request->division_id,
                'district_id' => $request->district_id,
                'upazila_id' => $request->upazila_id,
                'company_id' => $company->id,
            ]);

            DB::commit();
            return back()->with('success', 'Data Created Successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with(
                'failed',
                'Oops! Something was wrong. Message: '.$e->getMessage().
                ' Line: '.$e->getLine().
                ' File: '.$e->getFile()
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Company $company)
    {
        $modal_title = 'Company Details';
        $modal_data = $company;
        $html = view($this->viewName . '.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanyLocation $companylocation)
    {
        $page_title = "Company Location Edit";
        $page_heading = "Company Location Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $companylocation->id);
        $editinfo = $companylocation;
        $divisions = Division::all();
        $districts = District::all();
        $upazilas = Upozilla::all();
        $branches = Branch::all();
        return view($this->viewName . '.location.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompanyLocation $companylocation)
    {
        $validated = $request->validate([
            'branch_id' => [
                'required',
                Rule::unique('company_locations', 'branch_id')->ignore($companylocation->id)
            ],
            'fields' => ['nullable', 'array'],
            'fields.*' => ['string']
        ]);

        try {
            DB::beginTransaction();

            $companylocation->update([
                'fields' => $validated['fields'] ?? [],
                'branch_id' => $request->branch_id,
                'division_id' => $request->division_id,
                'district_id' => $request->district_id,
                'upazila_id' => $request->upazila_id,
            ]);

            DB::commit();
            return back()->with('success', 'Data Updated Successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with(
                'failed',
                'Oops! Something was wrong. Message: '.$e->getMessage().
                ' Line: '.$e->getLine().
                ' File: '.$e->getFile()
            );
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
