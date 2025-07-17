@extends('admin.master')

@section('content')
<section style="background-color: #eee;">
    <div class="container py-5">
      <div class="row">

      </div>

      <div class="row">
        <div class="col-lg-3">
          <div class="card mb-4">
            <div class="card-body text-center">
                <span class="avatar"><img class="round" src="{{ asset('dummy-image.jpg') }}"
                    alt="avatar" height="40" width="40"><span
                    class="avatar-status-online"></span></span>
              <h5 class="my-3">Bandwith Customer Reject List</h5>


            </div>
          </div>
          <div class="card mb-4 mb-lg-0">

          </div>
        </div>
        <div class="col-lg-9">
            <div class="card mb-4">
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Customer Id</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->id}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Company Name</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->company_name}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Contact Owner Name</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->company_owner_name}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Contact Owner Phone</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->company_owner_phone}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Contact Person Name</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->contact_person_name}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Contact Person Phone</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->contact_person_phone}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Customer Address</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->customer_address}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">License Type</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $customer->licensetype->name }}</p>

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Division ID</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->division_id}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">District ID</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->district_id}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Upazila ID</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->upazila_id}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Road</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->road}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">House</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->house}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">VAT Check</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->vat_check}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">License No</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->license_no}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">License Date</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->license_date}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Latitude</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->latitude}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Longitude</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->longitude}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Admin Name</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->admin_name}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Admin Designation</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->admin_designation}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Admin Cell</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->admin_cell}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Admin Email</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->admin_email}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Billing Name:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->billing_name}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Billing Designation:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->billing_designation}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Billing Cell:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->billing_cell}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Billing Email:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->billing_email}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Technical Name:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->technical_name}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Technical Designation:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->technical_designation}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Technical Cell:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->technical_cell}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Technical Email:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->technical_email}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Installment:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->installment}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Installment Date:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->installment_date}}</p>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">OTC:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->otc}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Customer Priority:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->customer_priority}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Data Source:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->data_source}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Connection Path ID:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->connection_path_id}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Commission:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->commission}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Remark:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->remark}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Provider:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->provider}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Status:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->status}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Business ID:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->business_id}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Sales Approve:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->sales_approve}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Legal Approve:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->legal_approve}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Transmission Approve:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->transmission_approve}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">NOC Approve:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->noc_approve}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">NOC2 Approve:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->noc2_approve}}</p>
                        </div>
                          </div>
                          <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Billing Approve:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->billing_approve}}</p>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Reject Sales Approve:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->reject_sales_approve}}</p>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Reject Legal Approve:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->reject_legal_approve}}</p>
                        </div>
                    </div>
                    <hr>
                    {{-- <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Reject Sales Approve:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->reject_sales_approve}}</p>
                        </div>
                     <hr>
                     <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Reject Legal Approve:</p>
                        </div>
                        <div class="col-md-12">
                            <p class="text-muted mb-0">{{$customer->reject_legal_approve}}</p>
                        </div>
                    </div>
                    <hr> --}}

                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Reject Transmission Approve:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->reject_transmission_approve}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Reject NOC Approve:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->reject_noc_approve}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Reject NOC2 Approve:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->reject_noc2_approve}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Reject Billing Approve:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->reject_billing_approve}}</p>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Level Confirm:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->level_confirm}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Level Confirm By:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->level_confirm_by}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Sales Approve By:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->sales_approve_by}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Legal Approve By:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->legal_approve_by}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Transmission Approve By:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->transmission_approve_by}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">NOC Approve By:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->noc_approve_by}}</p>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">NOC2 Approve By:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->noc2_approve_by}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Billing Approve By:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->billing_approve_by}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Created By:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->created_by}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Updated By:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->updated_by}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Approved By:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->approved_by}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Created At:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->created_at}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Updated At:</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->updated_at}}</p>
                        </div>
                    </div>
                    <hr>
                    {{-- <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Bandwith Customer </p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{$customer->package->bandwith_customers_id}}</p>
                        </div>
                    </div> --}}
                    <hr>




                </div>
            </div>
        </div>

      </div>
    </div>
  </section>

@endsection
