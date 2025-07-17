@extends('customer.master')

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
                                    <td>Status</td>
                                    <td>
                                        <a href=""></a>
                                    <form action="{{route('my_supportticket.assignto',$supportticket->id)}}" method="get">
                                        <select name="assign_to" id="" class="form-control select2">
                                        @foreach ($employees as $employee)
                                        <option {{$supportticket->assign_to == $employee->user_id ? "selected":""}} value="{{$employee->user_id}}">{{$employee->name}}</option>
                                        @endforeach
                                        </select>
                                        @if(in_array($supportticket->status , [1,2]))
                                        <tr>
                                            <td></td>
                                            <td>
                                                <button class="btn btn-info btn-sm mt-2">Assign</button>
                                            </td>
                                        </tr>
                                        @endif
                                    </form>
                                    </td>
                                </tr>
                            </table>
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Ticket Info') }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{route('my_supportticket.statusup',$supportticket->id)}}" method="post">
                                @csrf
                            <table class="table table-borderless">
                                <tr>
                                    <td>Problem: </td>
                                    <td>{{$supportticket->problem->name ?? ""}}</td>
                                </tr>
                                <tr>
                                    <td>Complain: </td>
                                    <td>{{$supportticket->note ?? ""}}</td>
                                </tr>
                                <tr>
                                    <td>Complain Time: </td>
                                    <td>{{$supportticket->complain_time ?? ""}}</td>
                                </tr>
                                <tr>
                                    <td>Working Person: </td>
                                    <td>{!! $supportticket->assignUser->name ?? '<a  onclick="return confirm(`Are you sure you would like to accept this reply as your favor?`);" href=" '. route("supportticket.assign",$supportticket->id) .'" class="btn btn-warning btn-sm">No One</a>' !!}</td>
                                </tr>
                                <tr>
                                    <td>Status: </td>
                                    <td>{{$supportticket->supportstatus->name ?? ""}}</td>
                                </tr>
                                <tr>
                                    <td>Duration: </td>
                                    @php
                                      $startDateTime = \Carbon\Carbon::parse($supportticket->complain_time);
                                      $endDateTime = \Carbon\Carbon::parse($supportticket->complete_time ?? now());
                                      $duration = $startDateTime->diff($endDateTime);
                                      $format = $duration->format('Day:(%d) - Time: %h:%i %s s');
                                    @endphp
                                    <td>{{$format}}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td> <select name="status" id="" class="form-control">
                                        @foreach ($status as $statu)
                                        <option {{$supportticket->status == $statu->id ? "selected":""}} value="{{$statu->id}}">{{$statu->name}}</option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Remark</td>
                                    <td>
                                        <textarea name="remark" class="form-control" rows="5">{{$supportticket->remark}}</textarea>
                                    </td>
                                </tr>
                                @if(in_array($supportticket->status , [1,2]))
                                <tr>
                                    <td></td>
                                    <td>
                                       <button  class="btn btn-info">Save</a>
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
