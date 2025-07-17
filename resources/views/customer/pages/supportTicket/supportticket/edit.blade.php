@extends('customer.master')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$page_heading ?? 'Edit'}}
                </h4>
                <a href="{{$back_url ?? 'javascript:;'}}" class="btn btn-dark">Back</a>
            </div>
            <div class="card-body">

                <x-alert></x-alert>

                <div class="basic-form">
                    <form action="{{ $update_url ?? '#' }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group mb-1 col-sm-4 col-md-3">
                                <label>Complain Number</label>
                                <input type="text" value="{{   $editinfo->complain_number }}" readonly style="background: green;color:aliceblue"  class="form-control">
                            </div>
                            <div class="form-group mb-1 col-sm-4 col-md-3">
                                <label>Date</label>
                                <input type="date" value="{{ $editinfo->date }}" readonly name="date" class="form-control">
                            </div>
                            <div class="form-group mb-1 col-md-4 col-sm-4">
                                <label>Complain Type</label><br>
                                <select name="problem_category" class="form-control select2">
                                    <option disabled selected>Select</option>
                                    @foreach($supportCategorys as $supportCategory)
                                    <option {{$editinfo->problem_category == $supportCategory->id ? "selected":""}} value="{{$supportCategory->id}}">{{$supportCategory->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" name="client_id" value="{{$editinfo->client_id}}">
                        </div>
                        <hr>
                        <div class="row">

                                <div class="form-group mb-1 col-12">
                                    <label>Details</label></br>
                                    <textarea name="note" class="form-control" id="ckeditor" rows="1">{{$editinfo->note}}</textarea>
                                </div>
                        </div>
                        <hr>
                       @if(in_array($editinfo->status,[1,2]))
                           <div class="mb-1 form-group">
                               <button type="submit" class="btn btn-primary">Update</button>
                           </div>
                       @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script>
    function userDetails(e) {
        $.ajax({
            "url": "{{route('supportticket.userdetails')}}",
            method: "get",
            data: {
                'userid': e,
            },
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (data) {
                $('#loading').hide();
                $('#cClientname').val(data.name);
                $('#mobile').val(data.phone);
                $('#cClientaddress').val(data.address);
                $('#MonthlyBill').val(data.bill_amount);
                $('#dueamount').val("Due:( " + data.due + ")");
                $('#MikrotikStatus').html("<a  class='btn btn-md btn-square btn-success'>Active</a>");
                $('#cService').val(data.service);
                $('#clSupportMac').val(data.mac_address);
                $('#clSupportIp').val(data.ip_address);
                $('#clSupportIp').val(data.ip_address);
                $('#onlineStatus').html("<a  class='btn btn-md  btn-square btn-danger'>Offline</a>");
                console.log(data);
            }
        })
    }

    userDetails("{{$editinfo->client_id}}");
</script>
@endsection
