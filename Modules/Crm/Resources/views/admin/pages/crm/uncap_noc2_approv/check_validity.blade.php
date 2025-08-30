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
        {{-- <div class="col-xl-12 col-lg-12">
            <div class="card">

                <div class="card-header">
                    <h4 class="card-title">{{ $page_heading ?? 'Show' }}</h4>
                    <a href="{{ $back_url ?? 'javascript:;' }}" class="btn btn-dark">Back</a>
                </div>
                <form action="{{$store_url}}" method="post" enctype=multipart/form-data>
                    @csrf
                <div class="card-body">

                </div>
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
                                  <th class="col-4 px-1">{{ __('Type of Client') }}</th>
                                  <td class="col-8 px-1">{{ $customerDetails->license_type ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                  <th class="col-4 px-1">{{ __('Name Of Client') }}</th>
                                  <td class="col-8 px-1">
                                    <span>{{ $customerDetails->company_owner_name ?? 'N/A' }} : {{ $customerDetails->company_owner_phone ?? 'N/A' }}</span>
                                    {{-- <span>|</span>
                                    <span></span> --}}
                                  </td>
                                </tr>
                                <tr>
                                  <th class="col-4 px-1">{{ __('Contact Info') }}</th>
                                  <td class="col-8 px-1">
                                    @php
                                      $contactname = explode(',',$customerDetails->contact_person_name);
                                      $contactnumber = explode(',',$customerDetails->contact_person_phone);
                                    @endphp
                                    @foreach ($contactname as $key => $name)
                                      @if($name)
                                        <p class="py-0 my-0">{{$name}} : {{$contactnumber[$key]}}</p>
                                      @endif
                                    @endforeach
                                  </td>
                                </tr>
                                <tr>
                                  <th class="col-4 px-1 mt-0 pt-0">{{ __('Registered Address') }}</th>
                                  <td class="col-8 px-1">
                                    <span>House: {{ $customerDetails->house }}, Road: {{ $customerDetails->road }}, {{ $customerDetails->customer_address }}</span>
                                    <br>
                                    <span>Upazilla: {{ $customerDetails->upazilla->upozilla_name ?? "" }}, District: {{ $customerDetails->district->district_name ?? "" }}, Division: {{ $customerDetails->division->name ?? "" }}</span>
                                  </td>
                                </tr>
                                <tr>
                                  <th class="col-4 px-1">{{ __('Licence Type') }}</th>
                                  <td class="col-8 px-1">{{ $customerDetails->license_type ?? 'N/A' }}</td>
                                </tr>
                              </table>
                              <hr>
                                    <div class="col-md-12 mt-2">

                                        <button type="button" class="btn btn-primary confirm" approve-route="{{ route('uncap_level4_approv.approve', $customer->id) }}" >{{ __('Confirm') }}</button>
                                    </div>
                            </div>
                          </div>

                    </div>


                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-body">
                              <h6 class="d-flex align-items-center mb-3">Vlan/IP</h6>
                              <table class="table table-hover">
                                  <thead>
                                    <tr>
                                      <th scope="col">Item</th>
                                      <th scope="col">Vlan</th>
                                      <th scope="col">Ip</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                      @if(isset($customerDetails->getewaynoc->vlan))
                                      @php
                                          $item = explode(',',$customerDetails->getewaynoc->item_for_vlan ?? '');
                                          $vlan = explode(',',$customerDetails->getewaynoc->vlan ?? '');
                                          $ip = explode(',',$customerDetails->getewaynoc->ip ?? '');
                                      @endphp
                                        @foreach ($vlan as $key => $val)
                                    <tr>
                                          <td>
                                              <select disabled class="form-control" name="item_id[]"  id="item_id">
                                                @foreach ($customerDetails->package as $value)
                                                          <option {{($item[$key] ?? 0) == $value->item_id ? "selected":""}} value="{{$value->item_id}}">{{$value->item->name ?? ""}}</option>
                                                 @endforeach
                                               </select>
                                           </td>
                                      <td>{{($vlan[$key] ?? 0)}}</td>
                                      <td>{{($ip[$key] ?? 0)}}</td>
                                    </tr>
                                    @endforeach
                                    @endif

                                  </tbody>
                                </table>
                            </div>
                          </div>
                      </div>
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <h5>Package</h5> <p>Duration: {{$customer->apply_date}}</p>
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
                            <small class="text-secondary">New Quantity</small>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $oldtotal = 0;
                        $total = 0;
                    @endphp
                    @foreach ($package->item_id as $key => $value)
                        @php
                            $item = App\Models\Item::find($value);
                        @endphp
                    <tr>
                        <td>{{ $item->name ?? '' }}</td>
                        <td>{{ $package->old_quantity[$key] ?? '' }}</td>
                        <td>{{ $package->old_quantity[$key] + $package->quantity[$key] ?? '' }}</td>
                        @php
                         $total += $package->old_quantity[$key] + $package->quantity[$key] ?? 0;
                        @endphp

                    </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <td></td>
                        <td>Total:</td>
                        <td>{{ $total }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
                      <div class="col-sm-12 mb-3">
                        <div class="card h-100">
                          <div class="card-body">
                            <h6 class="d-flex align-items-center mb-3">Vlan/IP</h6>
                            <table class="table table-hover">
                                <thead>
                                  <tr>
                                    <th scope="col" width="20%">Item</th>
                                    <th scope="col" width="20%">Remote Asn</th>
                                    <th scope="col" width="20%">client Asn</th>
                                    <th scope="col" width="20%">Router </th>
                                    <th scope="col" width="20%">Ip lease </th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @if(isset($customerDetails->getewaynoc->item_id))
                                    @php
                                        $item_other = explode(',',$customerDetails->getewaynoc->item_id ?? []);
                                        $remote_asn = explode(',',$customerDetails->getewaynoc->remote_asn ?? []);
                                        $client_asn = explode(',',$customerDetails->getewaynoc->client_asn ?? []);
                                        $ip_lease = explode(',',$customerDetails->getewaynoc->ip_lease ?? []);
                                        $router_id = explode(',',$customerDetails->getewaynoc->router_id ?? []);
                                    @endphp
                                      @foreach ($item_other as $key => $item)
                                  <tr>
                                        <td>
                                            <select disabled name="item_id_ext[]"  class="form-control">
                                                @foreach ($customerDetails->package as $value)
                                                  <option {{$item ==  $value->item_id ? "selected":""}} value="{{$value->item_id}}">{{$value->item->name ?? ""}}</option>
                                                @endforeach
                                              </select>
                                         </td>
                                    <td>{{$remote_asn[$key]}}</td>
                                    <td>{{$client_asn[$key]}}</td>
                                    <td>
                                       <select disabled class="form-control" name="router_id[]" id="router">
                                        @foreach ($routes as $item)
                                        <option {{$router_id[$key] ==  $item->id ? "selected":""}}  value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                      </select></td>
                                      <td>{{$ip_lease[$key]}}</td>
                                  </tr>
                                  @endforeach
                                  @endif

                                </tbody>
                              </table>
                          </div>
                        </div>
                      </div>

                      <div class="col-sm-12 mb-3">
                        <div class="card h-100">
                          <div class="card-body">
                            <h6 class="d-flex align-items-center mb-3">Vlan/IP</h6>
                            <table class="table table-hover">
                                <thead>
                                  <tr>
                                    <th scope="col" width="30%">Pop</th>
                                    <th scope="col" width="20%">Port</th>
                                    <th scope="col" width="20%">Port Type</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @if($customerDetails->popconnection)
                                  @php
                                      $pop_id = explode(',',$customerDetails->popconnection->pop_id ?? []);
                                      $port = explode(',',$customerDetails->popconnection->port ?? []);
                                      $port_type = explode(',',$customerDetails->popconnection->port_type ?? []);
                                  @endphp
                                    @foreach ($pop_id as $itemkey => $item)
                                  <tr>
                                   <td>
                                    <select name="pop_id[]" class="form-control"  id="pop_id">
                                        @foreach ($ports as $itemd)
                                           <option {{$item == $itemd->id ? "selected":""}} value="{{$itemd->id}}">{{$itemd->name}}</option>
                                        @endforeach
                                      </select>
                                    </td>
                                    <td>{{ $port[$itemkey]}}</td>
                                    <td>
                                        <select disabled name="port_type_id[]" class="form-control fo qrm-control"  id="port_type">
                                            <option {{$port_type[$itemkey] == "1g" ? "selected":""}} value="1g">1g</option>
                                            <option {{$port_type[$itemkey] == "10g" ? "selected":""}} value="10g">10g</option>
                                            <option {{$port_type[$itemkey] == "40g" ? "selected":""}} value="40g">40g</option>
                                            <option {{$port_type[$itemkey] == "100g" ? "selected":""}} value="100g">100g</option>
                                            <option {{$port_type[$itemkey] == "etherp45" ? "selected":""}} value="etherp45">etherp45</option>
                                        </select>
                                    </td>

                                  </tr>
                                  @endforeach
                                  @endif

                                </tbody>
                              </table>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="card">
                          <div class="card-body">
                            <div class="card-body">
                                <h3>Pop List</h3>
                                <table class="table display responsive nowrap" style="font-size: 0.8rem;">
                                    <thead>
                                        <tr>
                                            <th>Pop Name</th>
                                            <th>Device</th>
                                            <th>Device Name</th>
                                            <th>Port</th>
                                            <th>Port Type</th>
                                            <th>Rj45</th>
                                            <th>Fiber Length</th>
                                            <th>Patched</th>
                                            <th>Customer Sfp</th>
                                            <th>Sfp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($customerDetails->popconnection)
                                        @php
                                            $pop_id = explode(',',$customerDetails->popconnection->pop_id ?? []);
                                            $port = explode(',',$customerDetails->popconnection->port ?? []);
                                            $deviceid = explode(',',$customerDetails->popconnection->device_id ?? []);
                                            $devicename = explode(',',$customerDetails->popconnection->device_name ?? []);
                                            $port_type = explode(',',$customerDetails->popconnection->port_type ?? []);

                                            if($customerDetails->popconnection->fiber){
                                                $rj45 = explode(',',($customerDetails->popconnection->rj45 ?? []));
                                                $fiber = explode(',',($customerDetails->popconnection->fiber ?? []));
                                                $patched = explode(',',($customerDetails->popconnection->patched ?? []));
                                                $sfp = explode(',', ($customerDetails->popconnection->sfp ?? []));
                                                $customerDetails_sfp = explode(',', ($customerDetails->popconnection->customer_sfp ?? []));
                                            }
                                        @endphp
                                          @foreach ($pop_id as $itemkey => $item)
                                          @php
                                            $popname = App\Models\Pop::find($item);
                                            $device = App\Models\Device::find($deviceid[$itemkey]);
                                          @endphp
                                        <tr>
                                            <td>{{$popname->name}}</td>
                                            <td>{{$device->name}}</td>
                                            <td>{{$devicename[$itemkey] ?? ""}}</td>
                                            <td>{{$port_type[$itemkey]}}</td>
                                            <td>{{$port[$itemkey]}}</td>
                                            <td>{{$rj45[$itemkey] ?? ""}}</td>
                                            <td>{{$fiber[$itemkey] ?? ""}}</td>
                                            <td>{{$patched[$itemkey] ?? ""}}</td>
                                            <td>{{$customerDetails_sfp[$itemkey] ?? ""}}</td>
                                            <td>{{$sfp[$itemkey] ?? ""}}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                          </div>
                        </div>
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
