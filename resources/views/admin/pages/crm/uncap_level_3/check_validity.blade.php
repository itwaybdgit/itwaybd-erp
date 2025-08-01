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
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-header">
                              <h3 class="card-title">{{ __('General Information') }}</h3>
                            </div>
                            <div class="card-body">
                              <table class="table table-borderless table-striped" style="font-size: 0.8rem;">
                                <tr>
                                  <th class="col-4 px-1">{{ __('Company Name') }}</th>
                                  <td class="col-8 px-1">{{ $customerDetails->company_name ?? 'N/A' }}</td>
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
                                  <td class="col-8 px-1">{{ $customerDetails->licensetype->name ?? null }}</td>
                                </tr>
                              </table>
                              <hr>
                              <div class="col-md-12">
                                <a href="{{route('upcap_level3.confirm',$customer->id)}}" class="btn btn-info">Done</a>
                            </div>
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
                                             $total +=$package->old_quantity[$key] + $package->quantity[$key] ?? 0;
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
                    <form action="{{ route('upcap_level3.updatestore', $customerDetails->id) }}" method="post">
                        @csrf
                        {{-- <input type="hidden" name="customer_id" value="{{$customerDetails->id}}"> --}}
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
                                              @foreach ($customerDetails->package as $value)
                                                <option value="{{$value->item_id}}">{{$value->item->name ?? ""}}</option>
                                              @endforeach
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" id="vlan_name" autocomplete="off"></td>
                                        <td><input type="text" class="form-control" id="ip_name" autocomplete="off"></td>
                                        <td><button type="button" class="itemadd btn btn-info btn-sm "><i class="fas fa-plus"></i></button></td>
                                      </tr>

                             @if(isset($customerDetails->getewaynoc->vlan))
                             @php
                                 $item = explode(',',$customerDetails->getewaynoc->item_for_vlan ?? '');
                                 $vlan = explode(',',$customerDetails->getewaynoc->vlan ?? '');
                                 $ip = explode(',',$customerDetails->getewaynoc->ip ?? '');
                             @endphp
                               @foreach ($vlan as $key => $val)
                               @if ($val)
                              <tr>
                                <td>
                                    <select class="form-control" name="item_id[]"  id="item_id">
                                      @foreach ($customerDetails->package as $value)
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
                                          @foreach ($customerDetails->package as $value)
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

                                  @if(isset($customerDetails->getewaynoc->item_id))
                                  @php
                                      $item_other = explode(',',$customerDetails->getewaynoc->item_id ?? []);
                                      $remote_asn = explode(',',$customerDetails->getewaynoc->remote_asn ?? []);
                                      $client_asn = explode(',',$customerDetails->getewaynoc->client_asn ?? []);
                                      $ip_lease = explode(',',$customerDetails->getewaynoc->ip_lease ?? []);
                                      $router_id = explode(',',$customerDetails->getewaynoc->router_id ?? []);
                                  @endphp
                                    @foreach ($item_other as $key => $item)
                                    @if ($item)

                                   <tr>
                                    <td>
                                        <select name="item_id_ext[]"  class="form-control">
                                          @foreach ($customerDetails->package as $value)
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

                                  @if($customerDetails->popconnection)
                                  @php
                                      $pop_id = explode(',',$customerDetails->popconnection->pop_id ?? []);
                                      $port = explode(',',$customerDetails->popconnection->port ?? []);
                                      $port_type = explode(',',$customerDetails->popconnection->port_type ?? []);
                                      $device_id = explode(',',$customerDetails->popconnection->device_id ?? []);
                                      $device_name = explode(',',$customerDetails->popconnection->device_name ?? []);
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

@section('scripts')
<script>

$(document).on('click','.itemremove',function(){
            if(confirm('Are You Sure ??')){
                 $(this).closest('tr').remove();
            }

        })

        $(document).on('click','.itemadd',function () {
            let itemid = $("#item_id option:selected").val();
            let item = $("#item_id option:selected").text();

            let ip_name = $("#ip_name").val();

            let vlan = $("#vlan_name").val();
            if(vlan.length > 0){
            let table =`
                <tr>
                    <td><input type="hidden" name="item_id[]" value="${itemid}">${item}</td>
                    <td><input type="text" class="form-control" name="vlan[]" value="${vlan}"></td>
                    <td><input type="text" class="form-control" name="ip[]" value="${ip_name}"></td>
                    <td><button type="button" class="itemremove btn btn-danger btn-sm "><i class="fas fa-minus"></i></button></td>
                </tr>`;
                $("#vlan_name").val('');
                $("#ip_name").val('');
          $('.multi_item').append(table);
            }else{
              alert('Please Enter Vlan!!')
            }
        });

        $(document).on('click','.itemadd_ext',function () {
            let itemid = $("#item_id_ext option:selected").val();
            let item = $("#item_id_ext option:selected").text();
            let router_id = $("#router option:selected").val();
            let router = $("#router option:selected").text();

            let remote_asn = $("#remote_asn").val();
            let client_asn = $("#client_asn").val();
            let ip_lease = $("#ip_lease").val();

            let table =`
                <tr>
                    <td><input type="hidden" name="item_id_ext[]" value="${itemid}">${item}</td>
                    <td><input type="text" class="form-control" name="remote_asn[]" value="${remote_asn}"></td>
                    <td><input type="text" class="form-control" name="client_asn[]" value="${client_asn}"></td>
                    <td><input type="hidden" name="router_id[]" value="${router_id}">${router}</td>
                    <td><input type="text" class="form-control" name="ip_lease[]" value="${ip_lease}"></td>
                    <td><button type="button" class="itemremove btn btn-danger btn-sm "><i class="fas fa-minus"></i></button></td>
                </tr>`;

             $("#remote_asn").val('');
             $("#client_asn").val('');
             $("#ip_lease").val('');

          $('.multi_item_ext').append(table);

        });

        $(document).on('click','.pop_add',function () {
            let pop_id = $("#pop_id option:selected").val();
            let pop = $("#pop_id option:selected").text();
            let port_type_id = $("#port_type option:selected").val();
            let port_type = $("#port_type option:selected").text();
            let device_id_text = $("#device_id option:selected").text();
            let device_id = $("#device_id option:selected").val();
            let device_name = $("#device_name").val();
            let port = $("#port").val();

            let table =`
                <tr>
                    <td><input type="hidden" name="pop_id[]" value="${pop_id}">${pop}</td>
                    <td><input type="hidden" class="form-control" value="${device_id}" name="device_id[]" >${device_id_text}</td>
                    <td><input type="text" class="form-control" value="${device_name}" name="device_name[]" ></td>
                    <td><input type="hidden" class="form-control" name="port_type_id[]" value="${port_type_id}">${port_type}</td>
                    <td><input type="text" class="form-control" name="port[]" value="${port}"></td>
                    <td><button type="button" class="itemremove btn btn-danger btn-sm "><i class="fas fa-minus"></i></button></td>
                </tr>`;
                $("#port").val('');
          $('.pop_body').append(table);

        });


</script>
@endsection
