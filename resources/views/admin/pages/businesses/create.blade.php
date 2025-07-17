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
                                <label>Logo</label>
                                <input type="file" class="form-control input-rounded"
                                    name="logo">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Invoice Logo</label>
                                <input type="file" class="form-control input-rounded"
                                    name="invoice_logo">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Company Name</label>
                                <input type="text" class="form-control input-rounded" value="{{old('company name')}}"
                                    name="business_name" placeholder="company_name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Website</label>
                                <input type="text" class="form-control input-rounded" value="{{old('website')}}"
                                    name="website" placeholder="website">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Phone</label>
                                <input type="text" class="form-control input-rounded" value="{{old('phone')}}"
                                    name="phone" placeholder="phone">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Email</label>
                                <input type="text" class="form-control input-rounded" value="{{old('email')}}"
                                    name="email" placeholder="email">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Address</label>
                                <input type="text" class="form-control input-rounded" value="{{old('address')}}"
                                    name="address" placeholder="address">
                            </div>
                                <div class="col-md-6 mb-3">
                                    <label>Invoice Message</label>
                                    <textarea class="form-control input-rounded" name="message" placeholder="Enter your message" rows="5" cols="4">{{ old('message') }}</textarea>
                                </div>
                        </div>

                        <h4 class="text-center">Mail Setup</h4>
                        <hr>
                        <div class="row ">
                            <div class="col-md-6 mb-3">
                                <label>Type</label>
                                <select class="form-control select2 mb-2 mb-md-0" name="mail_mailer"  tabindex="-98">
                                    <option  value="sendmail">Sendmail</option>
                                    <option value="smtp" selected="">SMTP</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>MAIL HOST</label>
                                <input type="text" class="form-control input-rounded" value=""
                                    name="mail_host" placeholder="MAIL HOST">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>MAIL PORT</label>
                                <input type="text" class="form-control input-rounded" value=""
                                    name="mail_port" placeholder="MAIL PORT">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>MAIL USERNAME</label>
                                <input type="text" class="form-control input-rounded" value=""
                                    name="mail_username" placeholder="MAIL USERNAME">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>MAIL PASSWORD</label>
                                <input type="text" class="form-control input-rounded" value=""
                                    name="mail_password" placeholder="MAIL PASSWORD">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>MAIL ENCRYPTION</label>
                                <input type="text" class="form-control input-rounded" value=""
                                    name="mail_encryption" placeholder="MAIL ENCRYPTION">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Mail From Address</label>
                                <input type="text" class="form-control input-rounded" value=""
                                    name="mail_from_address" placeholder="MAIL ENCRYPTION">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Mail From Name</label>
                                <input type="text" class="form-control input-rounded" value=""
                                    name="mail_from_name" placeholder="MAIL ENCRYPTION">
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
