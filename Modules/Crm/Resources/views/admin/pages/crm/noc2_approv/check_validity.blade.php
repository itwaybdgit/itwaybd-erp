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
                                        <span>{{ $customer->company_owner_name ?? 'N/A' }} : {{ $customer->company_owner_phone ?? 'N/A' }}</span>
                                        {{-- <span>|</span>
                                        <span></span> --}}
                                      </td>
                                    </tr>
                                    <tr>
                                      <th class="col-4 px-1">{{ __('Contact Info') }}</th>
                                      <td class="col-8 px-1">
                                        @php
                                          $contactname = explode(',',$customer->contact_person_name);
                                          $contactnumber = explode(',',$customer->contact_person_phone);
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
                                        <span>House: {{ $customer->house }}, Road: {{ $customer->road }}, {{ $customer->customer_address }}</span>
                                        <br>
                                        <span>Upazilla: {{ $customer->upazilla->upozilla_name ?? "" }}, District: {{ $customer->district->district_name ?? "" }}, Division: {{ $customer->division->name ?? "" }}</span>
                                      </td>
                                    </tr>

                                    <tr>
                                      <th class="col-4 px-1">{{ __('License Type') }}</th>
                                      <td class="col-8 px-1">{{ $customer->licensetype->name ?? 'N/A' }}</td>
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
                                        <th class="col-4 px-1">{{ __('Provider') }}</th>
                                        <td class="col-8 px-1">{{ $customer->provider ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-4 px-1">{{ __('Bandwidth') }}</th>
                                        <td class="col-8 px-1">{{ $customer->package->sum('qty') ?? 'N/A' }} </td>
                                      </tr>
                                  </table>
                              <hr>
                              <div class="container">
                                <h3 class="card-title">{{ __('Revert Form') }}</h3>
                                <form action="{{ route('reverts.store', $customer->id) }}" method="POST">
                                    @csrf
                                    <div class="col md-6">
                                       <input type="text" name="type" value="billing_approved" hidden>
                                       <input type="number" name="table_id" value="{{$customer->id}}" hidden>
                                       <input type="number" name="revert_by" value="{{ auth()->user()->id }}" hidden>
                                     <textarea name="reason" class="form-control" id="" cols="55" rows="6"></textarea>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <button type="submit"
                                        class="btn btn-danger ">{{ __('Revert') }}</button>

                                        <button type="button" class="btn btn-primary confirm" approve-route="{{ route('noc2_approv.approve', $customer->id) }}" >{{ __('Confirm') }}</button>
                                    </div>
                                </form>
                            </div>
                            </div>
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
                                      @if(isset($customer->getewaynoc->vlan))
                                      @php
                                          $item = explode(',',$customer->getewaynoc->item_for_vlan ?? '');
                                          $vlan = explode(',',$customer->getewaynoc->vlan ?? '');
                                          $ip = explode(',',$customer->getewaynoc->ip ?? '');
                                      @endphp
                                        @foreach ($vlan as $key => $val)
                                    <tr>
                                          <td>
                                              <select disabled class="form-control" name="item_id[]"  id="item_id">
                                                @foreach ($customer->package as $value)
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
                                    @if(isset($customer->getewaynoc->item_id))
                                    @php
                                        $item_other = explode(',',$customer->getewaynoc->item_id ?? []);
                                        $remote_asn = explode(',',$customer->getewaynoc->remote_asn ?? []);
                                        $client_asn = explode(',',$customer->getewaynoc->client_asn ?? []);
                                        $ip_lease = explode(',',$customer->getewaynoc->ip_lease ?? []);
                                        $router_id = explode(',',$customer->getewaynoc->router_id ?? []);
                                    @endphp
                                      @foreach ($item_other as $key => $item)
                                  <tr>
                                        <td>
                                            <select disabled name="item_id_ext[]"  class="form-control">
                                                @foreach ($customer->package as $value)
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
                                    @if($customer->popconnection)
                                  @php
                                      $pop_id = explode(',',$customer->popconnection->pop_id ?? []);
                                      $port = explode(',',$customer->popconnection->port ?? []);
                                      $port_type = explode(',',$customer->popconnection->port_type ?? []);
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
                                        @if($customer->popconnection)
                                        @php
                                            $pop_id = explode(',',$customer->popconnection->pop_id ?? []);
                                            $port = explode(',',$customer->popconnection->port ?? []);
                                            $deviceid = explode(',',$customer->popconnection->device_id ?? []);
                                            $devicename = explode(',',$customer->popconnection->device_name ?? []);
                                            $port_type = explode(',',$customer->popconnection->port_type ?? []);

                                            if($customer->popconnection->fiber){
                                                $rj45 = explode(',',($customer->popconnection->rj45 ?? []));
                                                $fiber = explode(',',($customer->popconnection->fiber ?? []));
                                                $patched = explode(',',($customer->popconnection->patched ?? []));
                                                $sfp = explode(',', ($customer->popconnection->sfp ?? []));
                                                $customer_sfp = explode(',', ($customer->popconnection->customer_sfp ?? []));
                                            }
                                        @endphp
                                          @foreach ($pop_id as $itemkey => $item)
                                          @php
                                            $popname = App\Models\Pop::find($item);
                                            $device = App\Models\Device::find($deviceid[$itemkey]);
                                          @endphp
                                        <tr>
                                            <td>{{$popname->name ?? ""}}</td>
                                            <td>{{$device->name ?? ""}}</td>
                                            <td>{{$devicename[$itemkey] ?? ""}}</td>
                                            <td>{{$port_type[$itemkey] ?? ""}}</td>
                                            <td>{{$port[$itemkey] ?? ""}}</td>
                                            <td>{{$rj45[$itemkey] ?? ""}}</td>
                                            <td>{{$fiber[$itemkey] ?? ""}}</td>
                                            <td>{{$patched[$itemkey] ?? ""}}</td>
                                            <td>{{$customer_sfp[$itemkey] ?? ""}}</td>
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

                    <div class="col-md-12">
                        <div class="card">
                          <div class="card-body">
                            <div class="card-body">
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

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total = 0;
                                        @endphp
                                        @foreach ($customer->package as $value)
                                        @php
                                            $total += $value->qty;
                                        @endphp
                                            <tr>
                                                <td>{{ $value->item->name ?? '' }}</td>
                                                <td>{{ $value->qty ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>Total</td>
                                            <td>{{$total}}</td>
                                        </tr>
                                    </tfoot>
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
