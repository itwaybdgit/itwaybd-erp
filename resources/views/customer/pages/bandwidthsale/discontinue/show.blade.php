@extends('admin.master')

@section('content')
<div class="row ">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header border-bottom">
                <h4 class="card-title">{{ $page_heading ?? 'List' }}</h4>
                <a href="{{ $back_url ?? 'javascript:;' }}" class="btn btn-dark">Back</a>

            </div>
            <div class="card-body">
                <x-alert></x-alert>
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
            </div>
        </div>
    </div>

    <form action="{{route('discontinue.update',$editOption->id)}}">
       <div class="col-md-12">
          <div class="card">
             <div class="card-body">
               <label for="">Apply Date</label>
               <input type="date" name="date" class="form-control" value="{{$editOption->apply_date}}"">
             </div>
             <button class="mt-2 btn btn-success">Approve</button>
          </div>
       </div>
    </form>
</div>

@endsection
