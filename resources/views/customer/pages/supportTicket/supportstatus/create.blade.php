@extends('admin.master')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$page_heading ?? 'Create'}}</h4>
                <a href="{{$back_url ?? 'javascript:;'}}" class="btn btn-dark">Back</a>
            </div>
            <div class="card-body">

                <x-alert></x-alert>

                <div class="basic-form">
                    <form action="{{ $store_url ?? '#' }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-md-6 mb-1">
                                <label for="">Status</label>
                                <input type="text" class="form-control" value="{{ old('name')}}" name="name">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Order Id</label>
                                <input type="number" class="form-control" value="{{ old('order_id')}}" name="order_id">
                            </div>


                        </div>

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
