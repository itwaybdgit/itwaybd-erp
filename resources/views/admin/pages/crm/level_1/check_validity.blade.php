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
                                        <th class="col-4 px-1">{{ __('Type of Client') }}</th>
                                        <td class="col-8 px-1">{{ $customer->connectionport->name ?? 'N/A' }}</td>
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
                              <div class="row">
                                <div class="col-md-12">
                                    <a href="{{route('level_3.confirm',$customer->id)}}" class="btn btn-info">Done</a>
                                </div>
                              </div>
                              <form action="{{ route('level_1.assing_by', $customer->id) }}" method="post">
                                @csrf
                                <div class="row">
                                 <div class="col-md-12">
                                   <label for="">Assign To</label>
                                   <select name="assign_to" id="" class="form-control select2">
                                      <option {{$customer->assign_to == "1" ? "selected":""}} value="1">Level 1</option>
                                      <option {{$customer->assign_to == "2" ? "selected":""}} value="2">Level 2</option>
                                      <option {{$customer->assign_to == "3" ? "selected":""}} value="3">Level 3</option>
                                   </select>
                                 </div>
                                </div>
                                <hr>
                                <button type="submit" class="btn btn-primary">Submit</button>
                              </form>
                            </div>
                          </div>

                    </div>
                    {{-- <div class="col-md-6">
                      <div class="row gutters-sm">
                        <div class="col-sm-6 mb-3">
                          <div class="card h-100">
                            <div class="card-body">
                              <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">assignment</i>Project Status</h6>
                              <small>Web Design</small>
                              <div class="progress mb-3" style="height: 5px">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                              <small>Website Markup</small>
                              <div class="progress mb-3" style="height: 5px">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                              <small>One Page</small>
                              <div class="progress mb-3" style="height: 5px">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                              <small>Mobile Template</small>
                              <div class="progress mb-3" style="height: 5px">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                              <small>Backend API</small>
                              <div class="progress mb-3" style="height: 5px">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                          <div class="card h-100">
                            <div class="card-body">
                              <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">assignment</i>Project Status</h6>
                              <small>Web Design</small>
                              <div class="progress mb-3" style="height: 5px">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                              <small>Website Markup</small>
                              <div class="progress mb-3" style="height: 5px">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                              <small>One Page</small>
                              <div class="progress mb-3" style="height: 5px">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                              <small>Mobile Template</small>
                              <div class="progress mb-3" style="height: 5px">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                              <small>Backend API</small>
                              <div class="progress mb-3" style="height: 5px">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div> --}}

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
                                                <tr>
                                                    <td>{{ $value->item->name ?? '' }}</td>
                                                    <td>{{ $value->qty ?? '' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>

                      <form action="{{ route('level_1.updatestore', $customer->id) }}" method="post">
                        @csrf
                        {{-- <input type="hidden" name="customer_id" value="{{$customer->id}}"> --}}
                        <div class="row">
                          <div class="col-12">
                            <h2>Vlan/Ip</h2>
                            <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col">Vlan</th>
                                    <th scope="col">Ip</th>
                                    <th scope="col">Action </th>
                                  </tr>
                                </thead>

                                <tbody class="multi_item">
                                    <tr>
                                        <td>
                                            <select  class="form-control"  id="item_id">
                                              @foreach ($customer->package as $value)
                                                <option value="{{$value->item_id}}">{{$value->item->name ?? ""}}</option>
                                              @endforeach
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" id="vlan_name" autocomplete="off"></td>
                                        <td><input type="text" class="form-control" id="ip_name" autocomplete="off"></td>
                                        <td><button type="button" class="itemadd btn btn-info btn-sm "><i class="fas fa-plus"></i></button></td>
                                      </tr>

                             @if(isset($customer->getewaynoc->vlan))
                             @php
                                 $item = explode(',',$customer->getewaynoc->item_for_vlan ?? '');
                                 $vlan = explode(',',$customer->getewaynoc->vlan ?? '');
                                 $ip = explode(',',$customer->getewaynoc->ip ?? '');
                             @endphp
                               @foreach ($vlan as $key => $val)
                               @if ($val)
                              <tr>
                                <td>
                                    <select class="form-control" name="item_id[]"  id="item_id">
                                      @foreach ($customer->package as $value)
                                            <option {{($item[$key] ?? 0) == $value->item_id ? "selected":""}} value="{{$value->item_id}}">{{$value->item->name ?? ""}}</option>
                                       @endforeach
                                     </select>
                                 </td>

                                   <td><input type="text" value="{{($vlan[$key] ?? 0)}}" name="vlan[]" class="form-control"  autocomplete="off"></td>
                                  <td><input type="text"  value="{{($ip[$key] ?? 0)}}" name="ip[]" class="form-control"  autocomplete="off"></td>
                                   <td><button type="button" class="itemremove btn btn-danger btn-sm "><i class="fas fa-minus"></i></button></td>
                                </tr>
                               @endif

                                  @endforeach
                                  @endif

                                </tbody>
                              </table>
                          </div>
                        </div>


                          <div class="col-12 mt-3">
                            <h2>Others</h2>
                            <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th scope="col" width="20%">Item</th>
                                    <th scope="col" width="20%">Remote Asn</th>
                                    <th scope="col" width="20%">client Asn</th>
                                    <th scope="col" width="20%">Router </th>
                                    <th scope="col" width="20%">Ip lease </th>
                                    <th scope="col" width="20%">Action </th>
                                  </tr>
                                </thead>

                                <tbody class="multi_item_ext">
                                  <tr>
                                    <td>
                                        <select  class="form-control"  id="item_id_ext">
                                          @foreach ($customer->package as $value)
                                            <option value="{{$value->item_id}}">{{$value->item->name ?? ""}}</option>
                                          @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text"  class="form-control" id="remote_asn" autocomplete="off"></td>
                                    <td><input type="text"  class="form-control" id="client_asn" autocomplete="off"></td>
                                    <td>
                                         <select  class="form-control"  id="router">
                                            @foreach ($routes as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                          </select>
                                        </td>
                                    <td><input type="text"  class="form-control" id="ip_lease" autocomplete="off"></td>
                                    <td><button type="button" class="itemadd_ext btn btn-info btn-sm "><i class="fas fa-plus"></i></button></td>
                                  </tr>

                                  @if(isset($customer->getewaynoc->item_id))
                                  @php
                                      $item_other = explode(',',$customer->getewaynoc->item_id ?? []);
                                      $remote_asn = explode(',',$customer->getewaynoc->remote_asn ?? []);
                                      $client_asn = explode(',',$customer->getewaynoc->client_asn ?? []);
                                      $ip_lease = explode(',',$customer->getewaynoc->ip_lease ?? []);
                                      $router_id = explode(',',$customer->getewaynoc->router_id ?? []);
                                  @endphp
                                    @foreach ($item_other as $key => $item)
                                    @if ($item)

                                   <tr>
                                    <td>
                                        <select name="item_id_ext[]"  class="form-control">
                                          @foreach ($customer->package as $value)
                                            <option {{$item ==  $value->item_id ? "selected":""}} value="{{$value->item_id}}">{{$value->item->name ?? ""}}</option>
                                          @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" value="{{$remote_asn[$key]}}" name="remote_asn[]"  class="form-control" autocomplete="off"></td>
                                    <td><input type="text" value="{{$client_asn[$key]}}" name="client_asn[]" class="form-control" autocomplete="off"></td>
                                    <td>
                                        <select  class="form-control" name="router_id[]" id="router">
                                            @foreach ($routes as $item)
                                            <option {{$router_id[$key] ==  $item->id ? "selected":""}}  value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                          </select>
                                    </td>
                                    <td><input type="text"  value="{{$ip_lease[$key]}}" name="ip_lease[]" class="form-control" autocomplete="off"></td>
                                    <td><button type="button" class="itemremove btn btn-danger btn-sm "><i class="fas fa-minus"></i></button></td>
                                </tr>
                                @endif

                                @endforeach
                                @endif
                                </tbody>
                              </table>

                          </div>


                          <div class="col-12 mt-3">
                            <h2>Pop Info</h2>
                            <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th scope="col" width="20%">Pop</th>
                                    <th scope="col" width="20%">Device</th>
                                    <th scope="col" width="20%">Device Name</th>
                                    <th scope="col" width="20%">Port Type</th>
                                    <th scope="col" width="25%">Port Number</th>
                                    <th scope="col" width="10%">Action </th>
                                  </tr>
                                </thead>

                                <tbody class="pop_body">
                                  <tr>
                                    <td>
                                        <select  class="form-control"  id="pop_id">
                                          @foreach ($ports as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                          @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select  class="form-control"  id="device_id">
                                          @foreach ($devices as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                          @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" id="device_name" class="form-control">
                                    </td>
                                    <td>
                                        <select  class="form-control"  id="port_type">
                                              <option value="1g">1g</option>
                                              <option value="10g">10g</option>
                                              <option value="40g">40g</option>
                                              <option value="100g">100g</option>
                                              <option value="etherp45">etherp45</option>
                                          </select>
                                    </td>
                                    <td><input type="text"  class="form-control" id="port" autocomplete="off"></td>
                                    <td><button type="button" class="pop_add btn btn-info btn-sm "><i class="fas fa-plus"></i></button></td>
                                  </tr>

                                  @if($customer->popconnection)
                                  @php
                                      $pop_id = explode(',',$customer->popconnection->pop_id ?? []);
                                      $port = explode(',',$customer->popconnection->port ?? []);
                                      $port_type = explode(',',$customer->popconnection->port_type ?? []);
                                      $device_id = explode(',',$customer->popconnection->device_id ?? []);
                                      $device_name = explode(',',$customer->popconnection->device_name ?? []);
                                  @endphp

                                    @foreach ($pop_id as $itemkey => $item)
                                  <tr>
                                     <td>
                                        <select  name="pop_id[]" class="form-control"  id="pop_id">
                                          @foreach ($ports as $itemd)
                                            <option {{$item == $itemd->id ? "selected":""}} value="{{$itemd->id}}">{{$itemd->name}}</option>
                                          @endforeach
                                        </select>
                                     </td>
                                     <td>
                                        <select  name="device_id[]" class="form-control"  id="device_id">
                                          @foreach ($devices as $itemd)
                                            <option {{$device_id[$itemkey] == $itemd->id ? "selected":""}} value="{{$itemd->id}}">{{$itemd->name}}</option>
                                          @endforeach
                                        </select>
                                     </td>

                                    <td><input type="text" class="form-control" value="{{ $device_name[$itemkey]}}" name="device_name[]" ></td>

                                    <td>
                                        <select name="port_type_id[]" class="form-control fo qrm-control"  id="port_type">
                                            <option {{$port_type[$itemkey] == "1g" ? "selected":""}} value="1g">1g</option>
                                            <option {{$port_type[$itemkey] == "10g" ? "selected":""}} value="10g">10g</option>
                                            <option {{$port_type[$itemkey] == "40g" ? "selected":""}} value="40g">40g</option>
                                            <option {{$port_type[$itemkey] == "100g" ? "selected":""}} value="100g">100g</option>
                                            <option {{$port_type[$itemkey] == "etherp45" ? "selected":""}} value="etherp45">etherp45</option>
                                        </select>
                                       </td>
                                    <td><input type="text" class="form-control" value="{{ $port[$itemkey]}}" name="port[]" ></td>

                                    <td><button type="button" class="itemremove btn btn-danger btn-sm "><i class="fas fa-minus"></i></button></td>
                                  </tr>
                                  @endforeach
                                  @endif
                                </tbody>
                              </table>

                          </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </form>

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
