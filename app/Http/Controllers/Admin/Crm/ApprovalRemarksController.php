<?php

namespace App\Http\Controllers\Admin\Crm;

use App\Http\Controllers\Controller;
use App\Models\ApprovalRemarks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApprovalRemarksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
        $validate = Validator::make($request->all(), [
            'remarks' => 'required',
        ]);

        if ($validate->fails()) {
            return back()->with('error', 'Validation error!');
        }

        $remark = new ApprovalRemarks();
        $remark->type = $request->type;
        $remark->remarks = $request->remarks;
        $remark->created_by = Auth::user()->id;
        $remark->save();

        return redirect()->route('admin_approv.index')->with('success', 'Remarks added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ApprovalRemarks  $approvalRemarks
     * @return \Illuminate\Http\Response
     */
    public function show(ApprovalRemarks $approvalRemarks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApprovalRemarks  $approvalRemarks
     * @return \Illuminate\Http\Response
     */
    public function edit(ApprovalRemarks $approvalRemarks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ApprovalRemarks  $approvalRemarks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApprovalRemarks $approvalRemarks)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApprovalRemarks  $approvalRemarks
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApprovalRemarks $approvalRemarks)
    {
        //
    }
}
