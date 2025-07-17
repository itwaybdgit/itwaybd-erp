@extends('admin.master')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title ">{{ $page_heading ?? 'Create' }}
                        <x-loading></x-loading>
                    </h4>
                    <a href="{{ $back_url ?? 'javascript:;' }}" class="btn btn-dark">Back</a>
                </div>
                <div class="card-body">

                    <x-alert></x-alert>

                    <div class="basic-form">
                        <form action="{{ $store_url ?? '#' }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group mb-1 col-sm-4 col-md-3">
                                    <label>Complain Number</label>
                                    <input type="text" value="{{ $invoice_no }}" readonly
                                        style="background: green;color:aliceblue" name="complain_number"
                                        class="form-control">
                                </div>

                                <div class="form-group mb-1 col-sm-4 col-md-3">
                                    <label>Date</label>
                                    <input type="date" value="{{ date('Y-m-d') }}" readonly name="date"
                                        class="form-control">
                                </div>

                                <div class="form-group mb-1 col-6">
                                    <label>Customer</label><br>
                                    <select name="client_id" id="single-select2" class="client_id form-control select2">
                                        <option disabled selected>Select</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->company_name }} -
                                                {{ $customer->company_owner_name }} - {{ $customer->company_owner_phone }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-1 col-4">
                                    <label>Assign By</label><br>
                                    <select name="assign_to" id="single-select" class="form-control select2">
                                        <option value="0" selected>Not assign</option>
                                        <option value="1">Admin</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->user_id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-1 col-4">
                                    <label>Data Source</label><br>
                                    <select name="data_source" class="form-control select2">
                                        <option value="Phone">Phone</option>
                                        <option value="Whatsapp">Whatsapp</option>
                                        <option value="Mail">Mail</option>
                                        <option value="Others">Others</option>
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
                                            <option value="{{ $supportCategory->id }}">{{ $supportCategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-1 col-8">
                                    <label>Details</label></br>
                                    <textarea name="note" class="form-control" id="ckeditor" rows="5"></textarea>
                                </div>
                            </div>

                            <hr>
                            <div class="mb-1 form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
