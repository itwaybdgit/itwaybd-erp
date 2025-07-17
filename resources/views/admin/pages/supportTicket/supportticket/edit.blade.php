@extends('admin.master')

@section('content')

    <style>
        .file-preview img {
            width: 100%;
            height: auto;
            display: block;
        }

        .file-preview i {
            font-size: 5rem;
            display: block;
            margin: 0 auto;
        }

        .file-preview p {
            text-align: center;
            margin-top: 10px;
        }
    </style>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $page_heading ?? 'Edit' }}
                        <x-loading></x-loading>
                    </h4>
                    <a href="{{ $back_url ?? 'javascript:;' }}" class="btn btn-dark">Back</a>
                </div>
                <div class="card-body">

                    <x-alert></x-alert>

                    <div class="basic-form">
                        <form action="{{ $update_url ?? '#' }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group mb-1 col-sm-4 col-md-3">
                                    <label>Complain Number</label>
                                    <input type="text" value="{{ $editinfo->complain_number }}" readonly
                                        style="background: green;color:aliceblue" class="form-control">
                                </div>
                                <div class="form-group mb-1 col-sm-4 col-md-3">
                                    <label>Date</label>

                                    <input type="date"
                                        value="{{ \Carbon\Carbon::parse($editinfo->date)->format('Y-m-d') }}" readonly
                                        name="date" class="form-control">
                                </div>
                                <div class="form-group mb-1 col-6">
                                    <label>Customer</label><br>
                                    <select name="client_id" id="single-select2" class="client_id form-control select2">
                                        <option disabled selected>Company Name</option>
                                        @foreach ($customers as $customer)
                                            <option {{ $editinfo->client_id == $customer->id ? 'selected' : '' }}
                                                value="{{ $customer->id }}">{{ $customer->company_name }} -
                                                {{ $customer->company_owner_name }} - {{ $customer->company_owner_phone }}
                                            </option>
                                        @endforeach


                                    </select>
                                </div>
                                <div class="form-group mb-1 col-4">
                                    <label>Assign By</label><br>
                                    <select name="assign_to" id="single-select" class="form-control select2">
                                        <option value="0" selected>Not assign</option>
                                        @foreach ($employees as $employee)
                                            <option {{ $editinfo->assign_to == $employee->user_id ? 'selected' : '' }}
                                                value="{{ $employee->user_id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-1 col-4">
                                    <label>Data Source</label><br>
                                    <select name="data_source" class="form-control select2">
                                        <option {{ $editinfo->data_source == 'Phone' ? 'selected' : '' }} value="Phone">
                                            Phone</option>
                                        <option {{ $editinfo->data_source == 'Whatsapp' ? 'selected' : '' }}
                                            value="Whatsapp">Whatsapp</option>
                                        <option {{ $editinfo->data_source == 'Mail' ? 'selected' : '' }} value="Mail">
                                            Mail
                                        </option>
                                        <option {{ $editinfo->data_source == 'Others' ? 'selected' : '' }} value="Others">
                                            Others</option>
                                    </select>
                                </div>
                                <div class="form-group mb-1 col-4">
                                    <label>Attachement</label><br>
                                    <input type="file" name="attachments[]" multiple class="form-control">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="form-group mb-1 col-md-4 col-sm-4">
                                    <label>Complain Type</label><br>
                                    <select name="problem_category" class="form-control select2">
                                        <option disabled selected>Select</option>
                                        @foreach ($supportCategorys as $supportCategory)
                                            <option
                                                {{ $editinfo->problem_category == $supportCategory->id ? 'selected' : '' }}
                                                value="{{ $supportCategory->id }}">{{ $supportCategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-1 col-8">
                                    <label>Details</label></br>
                                    <textarea name="note" class="form-control" id="ckeditor" rows="4">{{ $editinfo->note }}</textarea>
                                </div>
                            </div>

                            <div class="row">
                                <label>Files</label>
                                @if ($editinfo->attachments)
                                    @foreach (json_decode($editinfo->attachments, true) as $filePath)
                                        <div class="col-3">
                                            <div class="file-preview text-center">
                                                {!! getFileIcon($filePath) !!}
                                                <a href="{{ $filePath }}" download
                                                    class="btn btn-secondary btn-sm">Download</a>
                                                <div class="mt-2">
                                                    <input type="checkbox" name="remove_files[]"
                                                        value="{{ $filePath }}"> Remove
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <hr>
                            @if (in_array($editinfo->status, [1, 2]))
                                <div class="mb-1 form-group text-right">
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
                "url": "{{ route('supportticket.userdetails') }}",
                method: "get",
                data: {
                    'userid': e,
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
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

        userDetails("{{ $editinfo->client_id }}");
    </script>
@endsection
