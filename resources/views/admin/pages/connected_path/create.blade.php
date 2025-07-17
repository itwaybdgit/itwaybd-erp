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

                        <div class="row">
                            <div class="col-md-6">
                                <label>Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-rounded" name="name">
                            </div>

                            <div class="col-md-6">
                                <label>Type</label>
                                <select name="type" class="form-control" id="">
                                    <option value="nb">NB</option>
                                    <option value="lb">LB</option>
                                </select>
                            </div>

                            <div class="col-md-12 mt-3">
                                <button type="button" class="btn btn-sm btn-success" id="provider_btn"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>

                        <div class="row provider_id">
                            <div class="col-md-4">
                                <label for="">Provider</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="provider[]" placeholder="" aria-label="" aria-describedby="basic-addon1">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-danger removeBtn" type="button"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mt-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script type="text/javascript">
    $(document).on('click','#provider_btn',function(){
        let html = ` <div class="col-md-4">
                                <label for="">Provider</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="provider[]" placeholder="" aria-label="" aria-describedby="basic-addon1">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-danger removeBtn" type="button"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                            </div>`;
        $('.provider_id').append(html);
    })

    $(document).on('click','.removeBtn',function(){
         if(confirm('Are You Sure!')){
            $(this).closest('.col-md-4').remove();
         }
    })
</script>
@endsection
