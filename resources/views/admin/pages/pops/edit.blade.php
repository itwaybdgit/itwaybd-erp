@extends('admin.master')

@section('content')
<div class="row">
    {{-- <div class="col-xl-12 col-lg-12"> --}}
    <div class="col-md-6 offset-md-3">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$page_heading ?? 'Edit'}}</h4>
                <a href="{{$back_url ?? 'javascript:;'}}" class="btn btn-dark">Back</a>
            </div>
            <div class="card-body">

                <x-alert></x-alert>

                <div class="basic-form">
                    <form action="{{ $update_url ?? '#' }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <label for="">POP Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-rounded" name="name"
                                    value="{{ old('name') ?? ($editinfo->name ?? '')}}" placeholder="POP name">
                            </div>
                            {{-- <div class="col-md-6 mb-1">
                                <label for="">Details</label>
                                <input type="text" class="form-control input-rounded" name="details"
                                    value="{{ old('details') ?? ($editinfo->details ?? '')}}" placeholder="Details">
                            </div> --}}
                        </div>

                        <div class="mb-1 form-group mt-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
