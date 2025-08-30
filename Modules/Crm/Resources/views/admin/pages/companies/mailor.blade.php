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
                        <div class="row ">
                            <div class="col-md-6 mb-3">
                                <label>Type</label>
                                <select class="form-control select2 mb-2 mb-md-0" name="MAIL_MAILER"  tabindex="-98">
                                    <option {{env('MAIL_HOST') == "sendmail" ? "selected":""}} value="sendmail">Sendmail</option>
                                    <option {{env('MAIL_HOST') == "smtp" ? "selected":""}} value="smtp" selected="">SMTP</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Mail Mailer</label>
                                <input type="text" class="form-control input-rounded" readonly value="{{env('MAIL_MAILER')}}"
                                    name="MAIL_HOST" placeholder="MAIL HOST">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>MAIL HOST</label>
                                <input type="text" class="form-control input-rounded" value="{{env('MAIL_HOST')}}"
                                    name="MAIL_HOST" placeholder="MAIL HOST">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>MAIL PORT</label>
                                <input type="text" class="form-control input-rounded" value="{{env('MAIL_PORT')}}"
                                    name="MAIL_PORT" placeholder="MAIL PORT">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>MAIL USERNAME</label>
                                <input type="text" class="form-control input-rounded" value="{{env('MAIL_USERNAME')}}"
                                    name="MAIL_USERNAME" placeholder="MAIL USERNAME">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>MAIL PASSWORD</label>
                                <input type="text" class="form-control input-rounded" value="{{env('MAIL_PASSWORD')}}"
                                    name="MAIL_PASSWORD" placeholder="MAIL PASSWORD">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>MAIL ENCRYPTION</label>
                                <input type="text" class="form-control input-rounded" value="{{env('MAIL_ENCRYPTION')}}"
                                    name="MAIL_ENCRYPTION" placeholder="MAIL ENCRYPTION">
                            </div>

                        </div>

                        <div class="mb-3 form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        $(document).on('change', '#zone_id', function(){
            let self = $(this);
            $.ajax({
                "url": "{{ route('api.subzones') }}",
                "type": "GET",
                "data": {
                    zone_id: self.val()
                },
                cache: false,
                success: function (data) {
                    $('#subzone_id').empty();
                    $('#subzone_id').html(data);
                }
            });
        });
    });

</script>
@endsection
