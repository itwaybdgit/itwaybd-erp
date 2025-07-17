@extends('customer.master')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title ">{{$page_heading ?? 'Create'}}
                    <x-loading></x-loading>
                </h4>
                <a href="{{$back_url ?? 'javascript:;'}}" class="btn btn-dark">Back</a>
            </div>
            <div class="card-body">

                <x-alert></x-alert>

                <div class="basic-form">
                    <form action="{{ $store_url ?? '#' }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group mb-1 col-sm-4 col-md-3">
                                <label>Complain Number</label>
                                <input type="text" value="{{  $invoice_no }}" readonly style="background: green;color:aliceblue" name="complain_number" class="form-control">
                            </div>
                            <div class="form-group mb-1 col-sm-4 col-md-3">
                                <label>Date</label>
                                <input type="date" value="{{ date("Y-m-d") }}" readonly name="date" class="form-control">
                            </div>
                            <div class="form-group mb-1 col-md-4 col-sm-4">
                                <label>Complain Type</label><br>
                                <select name="problem_category" class="form-control select2">
                                    <option disabled selected>Select</option>
                                    @foreach($supportCategorys as $supportCategory)
                                    <option value="{{$supportCategory->id}}">{{$supportCategory->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                                <input type="hidden" name="client_id" value="{{auth()->guard("bandwidthcustomer")->id() ?? 0}}">
                                 <input type="hidden" name="data_source" value="SOFTWARE" class="form-control">
                        </div>
                        <hr>
                        <div class="row">
                                <div class="form-group mb-1 col-12">
                                    <label>Details</label></br>
                                    <textarea name="note" class="form-control" id="ckeditor" rows="1"></textarea>
                                </div>
                        </div>
                        <hr>
                        <div class="mb-1 form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
