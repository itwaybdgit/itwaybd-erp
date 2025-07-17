@extends('admin.master')

@section('content')




<div class="card text-start">
    <img class="card-img-top" src="holder.js/100px180/" alt="Title" />
    <div class="card-body">
        <div class="container" style="margin-left: 350px">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">From</label>
                    <input type="text" class="form-control">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="">To</label>
                    <input type="text" class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Subject</label>
                    <input type="text" class="form-control">
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
