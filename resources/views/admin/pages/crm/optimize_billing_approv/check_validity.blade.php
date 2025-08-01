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
                                </table>
                                <hr>
                            </div>

                            <div class="container">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary confirm"
                                        approve-route="{{ route('optimize_billing.approve', $optimize->id) }}">{{ __('Confirm') }}</button>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5>Package</h5>
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                <small class="text-secondary">Item</small>
                                            </th>
                                            <th scope="col">
                                                <small class="text-secondary">Old Quantity</small>
                                            </th>
                                            <th scope="col">
                                                <small class="text-secondary">Optimize Quantity</small>
                                            </th>
                                            <th scope="col">
                                                <small class="text-secondary">New Quantity</small>
                                            </th>
                                            <th scope="col">
                                                <small class="text-secondary">Price</small>
                                            </th>
                                            <th scope="col">
                                                <small class="text-secondary">Old Amount</small>
                                            </th>
                                            <th scope="col">
                                                <small class="text-secondary">New Amount</small>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $oldtotal = 0;
                                            $total = 0;
                                            $qty = 0;
                                            $oldqty = 0;
                                            $newqty = 0;
                                        @endphp
                                        @foreach ($package->item_id as $key => $value)
                                            @php
                                                $item = App\Models\Item::find($value);
                                                $old_quantity = $package->old_quantity[$key] ?? 0;
                                                $total_quantity = $package->total_quantity[$key] ?? 0;
                                                $optimize_quantity = abs($old_quantity - $total_quantity);
                                                $optimize_sign = ($total_quantity > $old_quantity) ? '+' : '-';
                                            @endphp
                                            <tr>
                                                <td>{{ $item->name ?? '' }}</td>
                                                <td>{{ $old_quantity }}</td>
                                                <td>{{ $optimize_quantity }} <strong class="">({{ $optimize_sign }})</strong></td>
                                                <td>{{ $total_quantity }}</td>
                                                <td>{{ $package->asking_price[$key] ?? '' }}</td>
                                                @php
                                                    $oldtotal += $oldsubtotal = $old_quantity * $package->asking_price[$key];
                                                    $total += $package->total[$key] ?? 0;
                                                    $oldqty += $old_quantity;
                                                    $newqty += $total_quantity;
                                                    $qty += $package->quantity[$key];
                                                @endphp
                                                <td>{{ $package->old_total[$key] ?? '' }}</td>
                                                <td>{{ $package->total[$key] ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <td>Total:</td>
                                            <td>{{$oldqty}}</td>
                                            <td></td>
                                            <td>{{$newqty}}</td>
                                            <td></td>
                                            <td>{{$oldtotal}}</td>
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
