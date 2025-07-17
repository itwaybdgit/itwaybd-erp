<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BusinessController extends Controller {
    //
    protected $routeName =  'businesses';
    protected $viewName =  'admin.pages.businesses';

    protected function getModel()
    {
        return new Business();
    }

    protected function tableColumnNames() {
        return [
            // [
            //     'label' => 'Show in Table header',
            //     'data' => 'action',
            //     'class' => 'text-nowrap', class name
            //     'orderable' => false,
            //     'searchable' => false,
            // ],
            [
                'label' => 'Compnay Name',
                'data' => 'business_name',
                'searchable' => false,
            ],
            [
                'label' => 'Website',
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
            // [
            //     'label' => 'Message',
            //     'data' => 'message',
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
    public function index() {
        $page_title = "Business";
        $page_heading = "Business Setup";
        $ajax_url = route($this->routeName . '.dataProcessing');
        $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        return view('admin.pages.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function dataProcessing(Request $request) {
        return $this->getDataResponse(
            //Model Instance
            $this->getModel(),
            //Table Columns Name
            $this->tableColumnNames(),
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
     * @return \Illuminate\Http\Response
     */

    public function create() {
        $page_title = "Business Create";
        $page_heading = "Business Create";
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
    public function store(Request $request) {

        $valideted = $this->validate($request, [
            "logo" => ['image'],
            "invoice_logo" => ['image'],
            "business_name" => ['string'],
            "website" => ['string'],
            "phone" => ['string'],
            "email" => ['email'],
            "address" => ['string'],
            "message" => ['string','nullable'],
            "mail_mailer" => ['nullable'],
            "mail_host" => ['nullable'],
            "mail_port" => ['nullable'],
            "mail_username" => ['nullable'],
            "mail_password" => ['nullable'],
            "mail_encryption" => ['nullable'],
            "mail_from_address" => ['nullable'],
            "mail_from_name" => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            if ($request->hasFile('logo')) {
                $path =  $request->file('logo')->store('business', 'public');
                $valideted['logo'] = $path;
            }

            if ($request->hasFile('invoice_logo')) {
                $path =  $request->file('invoice_logo')->store('business', 'public');
                $valideted['invoice_logo'] = $path;
            }

            $valideted['create_by'] = auth()->id();
            $this->getModel()->create($valideted);

            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Something was wrong' . $e->getMessage() . 'Line' . $e->getLine() . 'File' . $e->getFile());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Business $business
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Business $business) {
        $modal_title = 'Business Details';
        $modal_data = $business;
        $html = view($this->viewName . '.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Business $business
     * @return \Illuminate\Http\Response
     */
    public function edit(Business $business) {
        $page_title = "Business Edit";
        $page_heading = "Business Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $business->id);
        $editinfo = $business;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Business $business
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Business $businesses)
    {
        $valideted = $this->validate($request, [
            "logo" => ['image'],
            "invoice_logo" => ['image'],
            "business_name" => ['string'],
            "website" => ['string'],
            "phone" => ['string'],
            "email" => ['email'],
            "address" => ['string'],
            "message" => ['string','nullable'],
            "mail_mailer" => ['nullable'],
            "mail_host" => ['nullable'],
            "mail_port" => ['nullable'],
            "mail_username" => ['nullable'],
            "mail_password" => ['nullable'],
            "mail_encryption" => ['nullable'],
            "mail_from_address" => ['nullable'],
            "mail_from_name" => ['nullable'],
        ]);
        // dd($valideted);
        try {
            DB::beginTransaction();

            if ($request->hasFile('logo')) {
                if ($businesses->logo) {
                    Storage::disk('public')->delete($businesses->logo);
                }
                $path =  $request->file('logo')->store('business', 'public');
                $valideted['logo'] = $path;
            }
            if ($request->hasFile('invoice_logo')) {
                if ($businesses->invoice_logo) {
                    Storage::disk('public')->delete($businesses->invoice_logo);
                }
                $path =  $request->file('invoice_logo')->store('business', 'public');
                $valideted['invoice_logo'] = $path;
            }

            $valideted['update_by'] = auth()->id();
            $businesses->update($valideted);

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
     * @param  \App\Models\Bsiness $business
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $business) {
        $business->delete();
        return back()->with('success', 'Data deleted successfully.');
    }

    public function getBusinessInfo($id) {
        $selectedBusiness = Business::find($id);
        return response()->json(['businessName' => $selectedBusiness->business_name, 'businessPhone' => $selectedBusiness->phone, 'businessEmail' => $selectedBusiness->email, 'businessAddress' => $selectedBusiness->address, 'businessInvoiceLogo' => asset($selectedBusiness->invoice_logo)]);
    }
}
