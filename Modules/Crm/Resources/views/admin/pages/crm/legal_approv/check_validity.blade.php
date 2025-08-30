@extends('admin.master')

<style>
    /* .custom-style {
        margin-left: 260px;
    }*/
    @media screen and (min-width: 1200px) {
        .custom-style {
            margin-left: -260px;
        }
    }

    .main-body {
    padding: 15px;
    }

.card {
    box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;
}

.card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1rem;
}

.gutters-sm {
    margin-right: -8px;
    margin-left: -8px;
}

.gutters-sm>.col, .gutters-sm>[class*=col-] {
    padding-right: 8px;
    padding-left: 8px;
}
.mb-3, .my-3 {
    margin-bottom: 1rem!important;
}

.bg-gray-300 {
    background-color: #e2e8f0;
}
.h-100 {
    height: 100%!important;
}
.shadow-none {
    box-shadow: none!important;
}
</style>

@section('content')

    <div class="row">

        <div class="container">
            <div class="main-body">
                  <div class="row gutters-sm">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header">
                              <h3 class="card-title">{{ __('General Information') }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="card-body">
                                    <table class="table table-borderless table-striped" style="font-size: 0.8rem;">
                                        <tr>
                                            <th class="col-4 px-1">{{ __('Company') }}</th>
                                            <td class="col-8 px-1">
                                                <span>{{ $customer->company_name ?? 'N/A' }}</span>
                                                {{-- <span>|</span>
                                    <span></span> --}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="col-4 px-1">{{ __('Name Of Client') }}</th>
                                            <td class="col-8 px-1">
                                                <span>{{ $customer->company_owner_name ?? 'N/A' }} :
                                                    {{ $customer->company_owner_phone ?? 'N/A' }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="col-4 px-1">{{ __('Contact Info') }}</th>
                                            <td class="col-8 px-1">
                                                @php
                                                    $contactname = explode(',', $customer->contact_person_name);
                                                    $contactnumber = explode(',', $customer->contact_person_phone);
                                                @endphp
                                                @foreach ($contactname as $key => $name)
                                                    @if ($name)
                                                        <p class="py-0 my-0">{{ $name }} : {{ $contactnumber[$key] ?? ""}}
                                                        </p>
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="col-4 px-1">{{ __('Email Info') }}</th>
                                            <td class="col-8 px-1">
                                                @php
                                                    $contactname = explode(',', $customer->contact_person_name);
                                                    $contactemail = explode(',', $customer->contact_person_email);
                                                @endphp
                                                @foreach ($contactname as $key => $name)
                                                    @if ($name)
                                                        <p class="py-0 my-0">{{ $name }} : {{ $contactemail[$key] ?? "" }}
                                                        </p>
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="col-4 px-1 mt-0 pt-0">{{ __('Registered Address') }}</th>
                                            <td class="col-8 px-1">
                                                <span>House: {{ $customer->house }}, Road: {{ $customer->road }},
                                                    {{ $customer->customer_address }}</span>
                                                <br>
                                                <span>Upazilla: {{ $customer->upazilla->upozilla_name ?? '' }}, District:
                                                    {{ $customer->district->district_name ?? '' }}, Division:
                                                    {{ $customer->division->name ?? '' }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="col-4 px-1">{{ __('Licence Type') }}</th>
                                            <td class="col-8 px-1">{{ $customer->licensetype->name ?? null }}</td>
                                        </tr>
                                        <tr>
                                            <th class="col-4 px-1">{{ __('Provider') }}</th>
                                            <td class="col-8 px-1">{{ $customer->provider ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                    <hr>
                                </div>
                            </div>
                          </div>

                          <div class="container">
                            <h3 class="card-title">{{ __('Reject Form') }}</h3>
                            <form action="{{ route('reverts.store', $customer->id) }}" method="POST">
                                @csrf
                                <div class="col md-6">
                                   <input type="text" name="type" value="legal_approved" hidden>
                                   <input type="number" name="table_id" value="{{$customer->id}}" hidden>
                                   <input type="number" name="revert_by" value="{{ auth()->user()->id }}" hidden>
                                 <textarea name="reason" class="form-control" id="" cols="55" rows="6"></textarea>
                                </div>

                                <div class="col-md-12 mt-2">
                                    <button type="submit"
                                    class="btn btn-danger ">{{ __('Reject') }}</button>

                                    <button type="button" class="btn btn-primary confirm" approve-route="{{ route('legal_approv.approve', $customer->id) }}" >{{ __('Confirm') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                          <div class="card-body">
                            <table class="table table-borderless table-striped">
                                <thead class="thead-dark">
                                  <tr>
                                    <th class="col-5 px-1" >{{ __('Approval Status') }}</th>
                                    <th class="px-1" >{{ __('Approver Name') }}</th>
                                  </tr>
                                </thead>
                                <tbody style="font-size: 0.8rem;">
                                  <tr>
                                    <td class="px-1" >
                                      <strong>{{ __('Sales') }}</strong>
                                      <span style="padding: 0 0.25rem;">:</span>
                                      <span>{{ $customer->sales_approve == 1 ? 'Approved' : 'Pending' }}</span>
                                    </td>
                                    <td class="px-1" >
                                      <strong>{{ __('Approved By') }}</strong>
                                      <span style="padding: 0 0.25rem;">:</span>
                                      <span>{{ $customer->approveSales->name ?? 'N/A' }}</span>
                                    </td>
                                  </tr>
                                  {{-- <tr>
                                    <td class="px-1" >
                                      <strong>{{ __('Legal') }}</strong>
                                      <span style="padding: 0 0.25rem;">:</span>
                                      <span>{{ $customer->legal_approve == 1 ? 'Approved' : 'Pending' }}</span>
                                    </td>
                                    <td class="px-1" >
                                      <strong>{{ __('Approved By') }}</strong>
                                      <span style="padding: 0 0.25rem;">:</span>
                                      <span>{{ $customer->approveLegal->name ?? 'N/A' }}</span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="px-1" >
                                      <strong>{{ __('Transmission') }}</strong>
                                      <span style="padding: 0 0.25rem;">:</span>
                                      <span>{{ $customer->transmission_approve == 1 ? 'Approved' : 'Pending' }}</span>
                                    </td>
                                    <td class="px-1" >
                                      <strong>{{ __('Approved By') }}</strong>
                                      <span style="padding: 0 0.25rem;">:</span>
                                      <span>{{ $customer->approveTranmission->name ?? 'N/A' }}</span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="px-1" >
                                      <strong>{{ __('Tx Planing') }}</strong>
                                      <span style="padding: 0 0.25rem;">:</span>
                                      <span>{{ $customer->noc_approve == 1 ? 'Approved' : 'Pending' }}</span>
                                    </td>
                                    <td class="px-1" >
                                      <strong>{{ __('Approved By') }}</strong>
                                      <span style="padding: 0 0.25rem;">:</span>
                                      <span>{{ $customer->approveNoc->name ?? 'N/A' }}</span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="px-1" >
                                      <strong>{{ __('Level 3') }}</strong>
                                      <span style="padding: 0 0.25rem;">:</span>
                                      <span>{{ $customer->noc2_approve == 1 ? 'Approved' : 'Pending' }}</span>
                                    </td>
                                    <td class="px-1" >
                                      <strong>{{ __('Approved By') }}</strong>
                                      <span style="padding: 0 0.25rem;">:</span>
                                      <span>{{ $customer->approveNoc2->name ?? 'N/A' }}</span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="px-1" >
                                      <strong>{{ __('Billing') }}</strong>
                                      <span style="padding: 0 0.25rem;">:</span>
                                      <span>{{ $customer->billing_approve == 1 ? 'Approved' : 'Pending' }}</span>
                                    </td>
                                    <td class="px-1" >
                                      <strong>{{ __('Approved By') }}</strong>
                                      <span style="padding: 0 0.25rem;">:</span>
                                      <span>{{ $customer->approveBilling->name ?? 'N/A' }}</span>
                                    </td>
                                  </tr> --}}
                                </tbody>
                              </table>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header">
                            <h4 class="card-title">{{ __('Legal Documents') }}</h4>
                          </div>
                          <div class="card-body">
                            <div class="row bg-white">
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('Agreement') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension1 = File::extension($legalInfo->agreement);
                                    @endphp
                                    @if (in_array($extension1, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension1, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension1, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension1, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->agreement) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->agreement) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('Cheque') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension2 = File::extension($legalInfo->cheque);
                                    @endphp
                                    @if (in_array($extension2, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension2, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension2, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension2, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->cheque) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->cheque) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('Work Order') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension25 = File::extension($legalInfo->work_order ?? "");
                                    @endphp

                                    @if (in_array($extension25, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-50" alt="">
                                    @elseif (in_array($extension25, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-50" alt="">
                                    @elseif (in_array($extension25, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-50" alt="">
                                    @elseif (in_array($extension25, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->work_order ?? "") }}" class="w-50" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                      <input type="file" name="work_order" class="form-control">

                                    @if($legalInfo->work_order ?? "")
                                    <a href="{{ asset('storage' . $legalInfo->work_order ?? "") }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                    @endif

                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('Cheque Authorization') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension3 = File::extension($legalInfo->cheque_authorization);
                                    @endphp
                                    @if (in_array($extension3, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension3, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension3, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension3, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->cheque_authorization) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->cheque_authorization) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('Cash') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension4 = File::extension($legalInfo->cash);
                                    @endphp
                                    @if (in_array($extension4, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension4, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension4, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension4, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->cash) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->cash) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('NOC Payment Clearance') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension5 = File::extension($legalInfo->noc_payment_clearance);
                                    @endphp
                                    @if (in_array($extension5, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension5, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension5, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension5, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->noc_payment_clearance) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->noc_payment_clearance) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('ISP License') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension6 = File::extension($legalInfo->isp_license);
                                    @endphp
                                    @if (in_array($extension6, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension6, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension6, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension6, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->isp_license) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->isp_license) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('Conversion') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension7 = File::extension($legalInfo->conversion);
                                    @endphp
                                    @if (in_array($extension7, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension7, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension7, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension7, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->conversion) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->conversion) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('Renewal') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension8 = File::extension($legalInfo->renewal);
                                    @endphp
                                    @if (in_array($extension8, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension8, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension8, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension8, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->renewal) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->renewal) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('Trade') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension9 = File::extension($legalInfo->trade);
                                    @endphp
                                    @if (in_array($extension9, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension9, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension9, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension9, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->trade) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->trade) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('NID') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension10 = File::extension($legalInfo->nid);
                                    @endphp
                                    @if (in_array($extension10, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension10, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension10, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension10, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->nid) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->nid) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('Photo') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension11 = File::extension($legalInfo->photo);
                                    @endphp
                                    @if (in_array($extension11, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension11, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension11, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension11, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->photo) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->photo) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('TIN') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension12 = File::extension($legalInfo->tin);
                                    @endphp
                                    @if (in_array($extension12, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension12, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension12, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension12, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->tin) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->tin) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('BIN') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension13 = File::extension($legalInfo->bin);
                                    @endphp
                                    @if (in_array($extension13, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension13, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension13, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension13, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->bin) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->bin) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('Authorization Letter') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension14 = File::extension($legalInfo->authorization_letter);
                                    @endphp
                                    @if (in_array($extension14, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension14, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension14, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension14, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->authorization_letter) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->authorization_letter) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('Partnership Deed Org') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension15 = File::extension($legalInfo->partnership_deed_org);
                                    @endphp
                                    @if (in_array($extension15, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension15, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension15, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension15, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->partnership_deed_org) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->partnership_deed_org) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('Partnership Deed') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension16 = File::extension($legalInfo->partnership_deed);
                                    @endphp
                                    @if (in_array($extension16, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension16, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension16, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension16, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->partnership_deed) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->partnership_deed) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('Power of Attorney') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension17 = File::extension($legalInfo->power_of_attorney);
                                    @endphp
                                    @if (in_array($extension17, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension17, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension17, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension17, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->power_of_attorney) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->power_of_attorney) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('Cert. of Incorporation') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension18 = File::extension($legalInfo->cert_of_incorporation);
                                    @endphp
                                    @if (in_array($extension18, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension18, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension18, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension18, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->cert_of_incorporation) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->cert_of_incorporation) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('Form XII') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension19 = File::extension($legalInfo->form_xii);
                                    @endphp
                                    @if (in_array($extension19, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension19, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension19, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension19, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->form_xii) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->form_xii) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('MOA AOA') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension20 = File::extension($legalInfo->moa_aoa);
                                    @endphp
                                    @if (in_array($extension20, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension20, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension20, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension20, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->moa_aoa) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->moa_aoa) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('Utility Bill') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension21 = File::extension($legalInfo->utility_bill);
                                    @endphp
                                    @if (in_array($extension21, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension21, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension21, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension21, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->utility_bill) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->utility_bill) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('User List') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension22 = File::extension($legalInfo->user_list);
                                    @endphp
                                    @if (in_array($extension22, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension22, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension22, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension22, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->user_list) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->user_list) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('Rent Agreement') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension23 = File::extension($legalInfo->rent_agreement);
                                    @endphp
                                    @if (in_array($extension23, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension23, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension23, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension23, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->rent_agreement) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->rent_agreement) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('Equipment Agreement') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension24 = File::extension($legalInfo->equipment_agreement);
                                    @endphp
                                    @if (in_array($extension24, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension24, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension24, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension24, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->equipment_agreement) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->equipment_agreement) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="card">
                                  <div class="card-header p-0">
                                    <h6 class="text-center py-0 my-0">{{ __('IP Lease Agreement') }}</h6>
                                  </div>
                                  <div class="card-body p-0">
                                    @php
                                      $extension25 = File::extension($legalInfo->iP_lease_agreement);
                                    @endphp
                                    @if (in_array($extension25, ['pdf']))
                                      <img src="{{ asset('image/pdf.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension25, ['doc', 'docx', 'rtf']))
                                      <img src="{{ asset('image/doc.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension25, ['xls', 'xlsx', 'csv']))
                                      <img src="{{ asset('image/xls.png') }}" class="w-100" alt="">
                                    @elseif (in_array($extension25, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                      <img src="{{ asset('storage' . $legalInfo->iP_lease_agreement) }}" class="w-100" height="150px" alt="">
                                    @else
                                    @endif
                                  </div>
                                  <div class="card-footer p-0" style="margin-top: 5px;">
                                    <a href="{{ asset('storage' . $legalInfo->iP_lease_agreement) }}" class="btn btn-sm btn-secondary" target="_blank" download >{{ __('Download') }}</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                    <div class="col-md-12">

                    </div>
                  </div>

                </div>
            </div>
        </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    })
</script>
