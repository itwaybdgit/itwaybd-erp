@extends('admin.master')

<style>
    /* .custom-style {
        margin-left: 260px;
    } */
    @media screen and (min-width: 1200px) {
        .custom-style {
            margin-left: -260px;
        }
    }

    .main-body {
        padding: 15px;
    }

    .card {
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 0 solid rgba(0, 0, 0, .125);
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

    .gutters-sm>.col,
    .gutters-sm>[class*=col-] {
        padding-right: 8px;
        padding-left: 8px;
    }

    .mb-3,
    .my-3 {
        margin-bottom: 1rem !important;
    }

    .bg-gray-300 {
        background-color: #e2e8f0;
    }

    .h-100 {
        height: 100% !important;
    }

    .shadow-none {
        box-shadow: none !important;
    }
</style>

@section('content')
    <div class="row">
        {{-- <div class="col-xl-12 col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{ $page_heading ?? 'Show' }}</h4>
          <a href="{{ $back_url ?? 'javascript:;' }}" class="btn btn-dark">Back</a>
        </div>
        <form action="{{$store_url}}" method="post" enctype=multipart/form-data>
          @csrf
          <div class="card-body"></div>
        </form>
      </div>
    </div> --}}
        <div class="container">
            <div class="main-body">
                <div class="row gutters-sm">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('General Information') }}</h3>
                            </div>
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

                            <div class="container">
                                <h3 class="card-title">{{ __('Revert Form') }}</h3>
                                <form action="{{ route('reverts.store') }}" method="POST">
                                    @csrf
                                    <div class="col md-6">
                                       <input type="text" name="type" value="admin_approved" hidden>
                                       <input type="number" name="table_id" value="{{$customer->id}}" hidden>
                                       <input type="number" name="revert_by" value="{{ auth()->user()->id }}" hidden>
                                     <textarea name="reason" class="form-control" id="" cols="55" rows="6"></textarea>
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <button type="submit"
                                        class="btn btn-danger ">{{ __('Revert') }}</button>

                                        <button type="button" class="btn btn-primary  confirm"
                                        approve-route="{{ route('admin_approv.approve', $customer->id) }}">{{ __('Confirm') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>


                    </div>


                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-borderless table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="col-5 px-1">{{ __('Approval Status') }}</th>
                                            <th class="px-1">{{ __('Approver Name') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 0.8rem;">
                                        <tr>
                                            <td class="px-1">
                                                <strong>{{ __('Sales') }}</strong>
                                                <span style="padding: 0 0.25rem;">:</span>
                                                <span>{{ $customer->sales_approve == 1 ? 'Approved' : 'Pending' }}</span>
                                            </td>
                                            <td class="px-1">
                                                <strong>{{ __('Approved By') }}</strong>
                                                <span style="padding: 0 0.25rem;">:</span>
                                                <span>{{ $customer->approveSales->name ?? 'N/A' }}</span>
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                            <td class="px-1">
                                                <strong>{{ __('Legal') }}</strong>
                                                <span style="padding: 0 0.25rem;">:</span>
                                                <span>{{ $customer->legal_approve == 1 ? 'Approved' : 'Pending' }}</span>
                                            </td>
                                            <td class="px-1">
                                                <strong>{{ __('Approved By') }}</strong>
                                                <span style="padding: 0 0.25rem;">:</span>
                                                <span>{{ $customer->approveLegal->name ?? 'N/A' }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-1">
                                                <strong>{{ __('Transmission') }}</strong>
                                                <span style="padding: 0 0.25rem;">:</span>
                                                <span>{{ $customer->transmission_approve == 1 ? 'Approved' : 'Pending' }}</span>
                                            </td>
                                            <td class="px-1">
                                                <strong>{{ __('Approved By') }}</strong>
                                                <span style="padding: 0 0.25rem;">:</span>
                                                <span>{{ $customer->approveTranmission->name ?? 'N/A' }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-1">
                                                <strong>{{ __('Tx Planing') }}</strong>
                                                <span style="padding: 0 0.25rem;">:</span>
                                                <span>{{ $customer->noc_approve == 1 ? 'Approved' : 'Pending' }}</span>
                                            </td>
                                            <td class="px-1">
                                                <strong>{{ __('Approved By') }}</strong>
                                                <span style="padding: 0 0.25rem;">:</span>
                                                <span>{{ $customer->approveNoc->name ?? 'N/A' }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-1">
                                              <strong>{{ __('Level 3') }}</strong>
                                              <span style="padding: 0 0.25rem;">:</span>
                                              <span>{{ $customer->level_confirm == 1 ? 'Approved' : 'Pending' }}</span>
                                            </td>
                                            <td class="px-1" >
                                              <strong>{{ __('Approved By') }}</strong>
                                              <span style="padding: 0 0.25rem;">:</span>
                                              <span>{{ $customer->approveNoc2->name ?? 'N/A' }}</span>
                                            </td>
                                          </tr>
                                        <tr>
                                            <td class="px-1">
                                                <strong>{{ __('Billing') }}</strong>
                                                <span style="padding: 0 0.25rem;">:</span>
                                                <span>{{ $customer->billing_approve == 1 ? 'Approved' : 'Pending' }}</span>
                                            </td>
                                            <td class="px-1">
                                                <strong>{{ __('Approved By') }}</strong>
                                                <span style="padding: 0 0.25rem;">:</span>
                                                <span>{{ $customer->approveBilling->name ?? 'N/A' }}</span>
                                            </td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                                <br>
                                <br>
                                <h5>Package</h5>
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col" width="25%">
                                                <small class="text-secondary">Item</small>
                                            </th>
                                            <th scope="col" width="20%">
                                                <small class="text-secondary">Quantity</small>
                                            </th>
                                            <th scope="col" width="20%">
                                                <small class="text-secondary">Price</small>
                                            </th>
                                            @if ($customer->vat_check == 'yes')
                                                <th scope="col" width="15%" class="vatcolumn">
                                                    <small class="text-secondary">Vat(%)</small>
                                                </th>
                                            @endif
                                            <th scope="col" width="25%">
                                                <small class="text-secondary">Amount</small>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total = 0;
                                            $qty = 0;
                                        @endphp
                                        @foreach ($customer->package as $value)
                                            <tr>
                                                <td>{{ $value->item->name ?? '' }}</td>
                                                <td>{{ $value->qty ?? '' }}</td>
                                                <td>{{ $value->rate ?? '' }}</td>
                                                @if ($customer->vat_check == 'yes')
                                                    <td>{{ $value->vat ?? '' }}</td>
                                                    @php
                                                        $vat = $value->vat / 100;
                                                    @endphp
                                                @else
                                                @endif
                                                @php
                                                    $addvat = $value->qty * $value->rate * ($vat ?? 0);
                                                    $subtotal = $value->qty * $value->rate + $addvat;
                                                    $total += $subtotal;
                                                    $qty +=$value->qty;
                                                @endphp
                                                <td>{{ $subtotal ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>Total:</td>
                                            <td>{{$qty}}</td>
                                            <td></td>
                                            @if ($customer->vat_check == 'yes')
                                                <td></td>
                                            @endif
                                            <td>{{ $total }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-12"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    })
</script>
