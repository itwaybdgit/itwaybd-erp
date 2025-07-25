@extends('customer.master')

@section('title')
    Dashboard
@endsection

@section('style')
    <link href="{{ asset('admin_assets/vendor/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin_assets/vendor/nouislider/nouislider.min.css') }}">
    <style>
    </style>
@endsection
@section('content')

@if(!auth()->guard('bandwidthcustomer')->check())
    <div class="row justify-content-center">
   @php
       $month = App\Models\Billing::where('customer_id',auth()->guard('customer')->user()->id ?? 0)->where('status', "!=" ,"paid")->orderBy('id', 'desc')->first();
   @endphp
   @if ($month)
        <div class="col-8 justify-content-center text-center">
            <div class="card text-center" >
                <div class="card-body">
                    <h3 style="color: #000">Payment summary</h3>
                    <h5 class="card-title" style="color: #000">{{Carbon\Carbon::parse($month->date_)->format('M-Y')}}</h5>
                    <p class="card-text" style="color: #000">Amount : {{$month->customer_billing_amount}}</p>
                </div>
            </div>
            <h4 style="color: #000">Please Pay On Bkash</h4>
            <a href="{{route('billing_details.bkash-create-payment',$month->id)}}">

                <img src="https://seeklogo.com/images/B/bkash-logo-250D6142D9-seeklogo.com.png"  style="width: 18rem;" class="shadow p-3 mb-5 bg-white rounded" alt="...">
            </a>
        </div>
    @else
   <h3>You have No Due Bill </h3>
    @endif
  </div>
@else
<div class="row">
    <div class="col-4">
        <div class="card gr_1_color">
            <div class="card-header ">
                <div>
                    <p class="card-text"> {{ date('F') }} Generate Bill </p>
                    <h3 class="font-weight-bolder mb-0 h3_title">{{ number_format($monthbillgenerate) }}</h3>
                </div>
                <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                    <div class="avatar-content">
                        <i data-feather="user" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card gr_1_color">
            <div class="card-header ">
                <div>
                    <p class="card-text"> {{ date('F') }} Month Due </p>
                    <h3 class="font-weight-bolder mb-0 h3_title">{{ number_format($differencedeu) }}</h3>
                </div>
                <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                    <div class="avatar-content">
                        <i data-feather="navigation-2" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card gr_1_color">
            <div class="card-header ">
                <div>
                    <p class="card-text"> {{ date('F') }} Month Collected </p>
                    <h3 class="font-weight-bolder mb-0 h3_title">{{ number_format($differencecollected) }}</h3>
                </div>
                <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                    <div class="avatar-content">
                        <i data-feather="navigation-2" class="font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="col-4">
    <div class="card gr_1_color">
        <div class="card-header ">
            <div>
                <p class="card-text"> Optimize Pending request</p>
                <h3 class="font-weight-bolder mb-0 h3_title">{{ $approve }}</h3>
            </div>
            <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                <div class="avatar-content">
                    <i data-feather="user" class="font-medium-5"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-4">
    <div class="card gr_1_color">
        <div class="card-header ">
            <div>
                <p class="card-text"> Upgradtion Pending request</p>
                <h3 class="font-weight-bolder mb-0 h3_title">{{ $upgradtionapprove }}</h3>
            </div>
            <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                <div class="avatar-content">
                    <i data-feather="user" class="font-medium-5"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-4">
    <div class="card gr_1_color">
        <div class="card-header ">
            <div>
                <p class="card-text"> Downgradtion Pending request</p>
                <h3 class="font-weight-bolder mb-0 h3_title">{{ $downgradtionapprove }}</h3>
            </div>
            <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                <div class="avatar-content">
                    <i data-feather="user" class="font-medium-5"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-4">
    <div class="card gr_1_color">
        <div class="card-header ">
            <div>
                <p class="card-text"> Reselleruncap Pending request</p>
                <h3 class="font-weight-bolder mb-0 h3_title">{{ $reselleruncap }}</h3>
            </div>
            <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                <div class="avatar-content">
                    <i data-feather="user" class="font-medium-5"></i>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endif
@endsection

@section('chartsctipts')

    {{-- <script src="{{ asset('admin_assets/vendor/chart.js/Chart.bundle.min.js') }}"></script> --}}

    <!-- Apex Chart -->
    {{-- <script src="{{ asset('admin_assets/vendor/apexchart/apexchart.js') }}"></script> --}}

    {{-- <script src="{{ asset('admin_assets/vendor/chart.js/Chart.bundle.min.js') }}"></script> --}}

    <!-- Chart piety plugin files -->
    <script src="{{ asset('admin_assets/vendor/peity/jquery.peity.min.js') }}"></script>
    <!-- Dashboard 1 -->
    <script src="{{ asset('admin_assets/js/dashboard/dashboard-1.js') }}"></script>

    {{-- <script src="{{ asset('admin_assets/vendor/owl-carousel/owl.carousel.js') }}"></script> --}}
@endsection
