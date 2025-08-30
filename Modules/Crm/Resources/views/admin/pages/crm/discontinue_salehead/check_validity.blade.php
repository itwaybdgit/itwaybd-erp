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
                    <div class="col-md-12">
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
                                    <tr>
                                        <th class="col-4 px-1">{{ __('Reason') }}</th>
                                        <td class="col-8 px-1">{{ $discontinue->reason ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                                <hr>
                            </div>

                            <div class="container">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary confirm"
                                        approve-route="{{ route('discontinue_salehead.approve', $discontinue->id) }}">{{ __('Confirm') }}</button>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-1">
                        <h4>Package</h4>
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
                                        <small class="text-secondary">Total</small>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
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
                                        @endphp
                                        <td>{{ $subtotal ?? '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    @if ($customer->vat_check == 'yes')
                                        <td></td>
                                    @endif
                                    <td>{{ $total }}</td>
                                </tr>
                            </tfoot>
                        </table>
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
