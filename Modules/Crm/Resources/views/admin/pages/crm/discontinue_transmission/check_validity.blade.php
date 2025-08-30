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
                              <hr>
                              <div class="container">
                                        <button type="button" class="btn btn-primary confirm" approve-route="{{ route('discontinue_transmission.approve', $discontinue->id) }}" >{{ __('Confirm') }}</button>
                              </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-md-6">
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
                                  <tr>
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
                                  </tr>
                                </tbody>
                              </table>
                          </div>
                        </div>
                    </div> --}}

                    <div class="col-md-6">
                        <div class="card">
                          <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                  <tr>
                                    <th scope="col">Vlan</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @if(isset($customer->getewaynoc->vlan))
                                    @php
                                        $vlan = explode(',',$customer->getewaynoc->vlan ?? '');
                                    @endphp
                                      @foreach ($vlan as $key => $val)
                                      <tr>
                                        <td>{{($vlan[$key] ?? 0)}}</td>
                                      </tr>
                                  @endforeach
                                  @endif

                                </tbody>
                              </table>
                          </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                          <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                  <tr>
                                    <th scope="col">Link Id</th>
                                  </tr>
                                </thead>
                                <tbody>

                                    @if(isset($customer->transmission))

                                    @php
                                        $linkid = explode(',', ($customer->transmission->link_id ?? []));
                                        // $itel_id = explode(',', ($customer->transmission->item ?? []));
                                        $vlan = explode(',', ($customer->transmission->vilan ?? []));
                                    @endphp

                                    @foreach ($linkid as $item)
                                    <tr>
                                        <td>{{$item}}</td>
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
                                            <td>{{$popname->name}}</td>
                                            <td>{{$device->name}}</td>
                                            <td>{{$devicename[$itemkey] ?? ""}}</td>
                                            <td>{{$port_type[$itemkey]}}</td>
                                            <td>{{$port[$itemkey]}}</td>
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

                  </div>
                  <hr>

                </div>
            </div>
        </div>
@endsection


@section('scripts')
<script>
        $(document).on('click','.linkid',function(){
           let input  = `<input type="text"  class="form-control mt-1" name="link_id[]" autocomplete="off">`;
           $('.multilinkid').append(input);
        })
        $(document).on('click','.itemremove',function(){
            if(confirm('Are You Sure ??')){
                 $(this).closest('tr').remove();
            }

        })

        $(document).on('click','.itemadd',function () {
            let itemid = $("#item_id option:selected").val();
            let item = $("#item_id option:selected").text();
            let vlan = $("#vlan_name").val();
            if(vlan.length > 0){
            let table =`<tr>
                    <td><input type="hidden" name="item_id[]" value="${itemid}">${item}</td>
                    <td><input type="text" class="form-control" name="vlan[]" value="${vlan}"></td>
                    <td><button type="button" class="itemremove btn btn-danger btn-sm "><i class="fas fa-minus"></i></button></td>
                </tr>`;
                $("#vlan_name").val('');
          $('.multi_item').append(table);
            }else{
              alert('Please Enter Vlan!!')
            }
        });


</script>
@endsection
