@extends('admin.master')


@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $page_heading ?? 'Show' }}</h4>
                    <a href="{{ $back_url ?? 'javascript:;' }}" class="btn btn-dark">Back</a>
                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">New Meeting Schedule</h4>
                </div>
                <div class="card-body">

                    <x-alert></x-alert>

                    <div class="basic-form">
                        <form action="{{ $store_url ?? '#' }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Meeting Date</label>
                                    <input type="datetime-local"  name="meeting_date" class="form-control mb-1" >
                                    <input type="hidden"  name="type" value="meeting" >
                                    <label>Meeting Remarks</label>
                                    <textarea class="form-control" name="meeting_remarks" id="exampleFormControlTextarea1" rows="3" placeholder="Remarks"></textarea>
                                </div>
                            </div>
                            <!-- Basic Textarea end -->
                            <div class="mt-1 form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Meeting Schedule</h4>
                </div>

            @foreach ($meetings as $val)
                <div class="card-body">

                    <x-alert></x-alert>
                      @php
                        $expire = strtotime(date('Y-m-d H:i:s')) > strtotime($val->meeting_date);
                      @endphp
                    <div class="basic-form">
                        <form action="{{ route('lead.schedule.update',$val->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Meeting Date</label>
                                    <input type="datetime-local" {{ $expire ? "disabled":""}}  value="{{$val->meeting_date}}" name="meeting_date" class="form-control mb-1" >
                                    <label>Meeting Remarks</label>
                                    <textarea class="form-control" {{ $expire ? "disabled":""}} name="meeting_remarks" id="exampleFormControlTextarea1" rows="3" placeholder="Remarks">{{$val->meeting_remarks}}</textarea>
                                </div>
                            </div>
                            <!-- Basic Textarea end -->
                            <div class="mt-1 form-group">
                                <button type="submit" {{ $expire ? "disabled":""}} class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">New Follow-up</h4>
                </div>
                <div class="card-body">

                    <x-alert></x-alert>

                    <div class="basic-form">
                        <form action="{{ $store_url ?? '#' }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Meeting Date</label>
                                    <input type="datetime-local"  name="meeting_date" class="form-control mb-1" >
                                    <input type="hidden"  name="type" value="followup" >
                                    <label>Meeting Remarks</label>
                                    <textarea class="form-control" name="meeting_remarks" id="exampleFormControlTextarea1" rows="3" placeholder="Remarks"></textarea>
                                </div>
                            </div>
                            <!-- Basic Textarea end -->
                            <div class="mt-1 form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Follow-up Schedule</h4>
                </div>

            @foreach ($followups as $val)
                <div class="card-body">

                    <x-alert></x-alert>
                      @php
                        $expire = strtotime(date('Y-m-d H:i:s')) > strtotime($val->meeting_date);
                      @endphp
                    <div class="basic-form">
                        <form action="{{ route('lead.schedule.update',$val->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Meeting Date</label>
                                    <input type="datetime-local" {{ $expire ? "disabled":""}}  value="{{$val->meeting_date}}" name="meeting_date" class="form-control mb-1" >
                                    <label>Meeting Remarks</label>
                                    <textarea class="form-control" {{ $expire ? "disabled":""}} name="meeting_remarks" id="exampleFormControlTextarea1" rows="3" placeholder="Remarks">{{$val->meeting_remarks}}</textarea>
                                </div>
                            </div>
                            <!-- Basic Textarea end -->
                            <div class="mt-1 form-group">
                                <button type="submit" {{ $expire ? "disabled":""}} class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>

@endsection

