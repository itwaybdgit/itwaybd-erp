@extends('admin.master')

@section('title')
    Dashboard
@endsection

@section('style')
    <link href="{{ asset('admin_assets/vendor/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin_assets/vendor/nouislider/nouislider.min.css') }}">
    <style>
        .card_color {
            background-color: #10245A;
            /* border-radius: 30px; */
            color: #fff;
        }

        .gr_1_color {
            background: linear-gradient(150deg, #f731db, #4600f1 100%);
            color: #fff;
        }

        .gr_2_color {
            background: linear-gradient(150deg, #39ef74, #4600f1 100%);
            color: #fff;
        }

        .gr_3_color {
            background: linear-gradient(150deg, #ff6b00f0, #0015f9f5 100%);
            color: #fff;
        }

        .gr_4_color {
            background: linear-gradient(150deg, #8f0d8b, #5821de 100%);
            color: #fff;
        }

        .h3_title {
            color: #fff;
        }


        .tick_1_color a,
        .tick_2_color a,
        .tick_3_color a {
            color: #fff;
        }

        .tick_1_color {
            background: red;
            color: #fff;
        }

        .tick_2_color {
            background: orange;
            color: #fff;
        }

        .tick_3_color {
            background: green;
            color: #fff;
        }

        .container {
            width: 80%;
            margin: 15px auto;
        }

        h2 {
            text-align: center;
        }
    </style>
@endsection
@section('content')
    <div class="row">

        @if (check_access('team_leader'))
            <div class="col-4">
                <div class="card gr_1_color">
                    <div class="card-header ">
                        <div>
                            <p class="card-text">Active Clients</p>
                            <h3 class="font-weight-bolder mb-0 h3_title">{{ $bandwith_clients }}</h3>
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
                            <p class="card-text">Pending customer</p>
                            <h3 class="font-weight-bolder mb-0 h3_title">{{ $pendingcustomer }}</h3>
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
                            <p class="card-text"> Optimize Sale Approve request</p>
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
                            <p class="card-text"> Upgradtion Sale request</p>
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
                            <p class="card-text"> Downgradtion Sale request</p>
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
                            <p class="card-text"> Reselleruncap request</p>
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
            <div class="col-4">
                <div class="card gr_1_color">
                    <div class="card-header ">
                        <div>
                            <p class="card-text"> Ni request</p>
                            <h3 class="font-weight-bolder mb-0 h3_title">{{ $resellernirequest }}</h3>
                        </div>
                        <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                            <div class="avatar-content">
                                <i data-feather="user" class="font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (check_access('Sales'))
            <div class="col-4">
                <div class="card gr_1_color">
                    <div class="card-header ">
                        <div>
                            <p class="card-text">Active Clients</p>
                            <h3 class="font-weight-bolder mb-0 h3_title">{{ $bandwith_clients }}</h3>
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
                            <p class="card-text">Pending customer</p>
                            <h3 class="font-weight-bolder mb-0 h3_title">{{ $pendingCustomer }}</h3>
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
                            <p class="card-text">Ni Request</p>
                            <h3 class="font-weight-bolder mb-0 h3_title">{{ $resellernirequest }}</h3>
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
                            <p class="card-text"> Pending Optimize Request </p>
                            <h3 class="font-weight-bolder mb-0 h3_title">{{ $optimizelist }}</h3>
                        </div>
                        <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                            <div class="avatar-content">
                                <i data-feather="bell" class="font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card gr_1_color">
                    <div class="card-header ">
                        <div>
                            <p class="card-text"> Pending Upgradtion Request </p>
                            <h3 class="font-weight-bolder mb-0 h3_title">{{ $discontinuelist }}</h3>
                        </div>
                        <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                            <div class="avatar-content">
                                <i data-feather="corner-right-down" class="font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card gr_1_color">
                    <div class="card-header ">
                        <div>
                            <p class="card-text"> Pending Upgradtion Request </p>
                            <h3 class="font-weight-bolder mb-0 h3_title">{{ $upgradtionlist }}</h3>
                        </div>
                        <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                            <div class="avatar-content">
                                <i data-feather="corner-left-up" class="font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card gr_1_color">
                    <div class="card-header ">
                        <div>
                            <p class="card-text"> Pending Downgradtion Request </p>
                            <h3 class="font-weight-bolder mb-0 h3_title">{{ $downgradtionlist }}</h3>
                        </div>
                        <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                            <div class="avatar-content">
                                <i data-feather="corner-right-down" class="font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card gr_1_color">
                    <div class="card-header ">
                        <div>
                            <p class="card-text"> Reseller uncap request</p>
                            <h3 class="font-weight-bolder mb-0 h3_title">{{ $reselleruncap }}</h3>
                        </div>
                        <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                            <div class="avatar-content">
                                <i data-feather="navigation-2" class="font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    @endif
    @if (check_access('billing_department'))
        <div class="col-4">
            <div class="card gr_1_color">
                <div class="card-header ">
                    <div>
                        <p class="card-text"> {{ date('F') }} Generate Bill </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $monthbillgenerate }}</h3>
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
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $differencedeu }}</h3>
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
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $differencecollected }}</h3>
                    </div>
                    <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                        <div class="avatar-content">
                            <i data-feather="navigation-2" class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (check_access('tx_planning'))
        <div class="col-4">
            <div class="card gr_1_color">
                <div class="card-header ">
                    <div>
                        <p class="card-text"> Techonlogy Tx Approve Request </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $txplanning }}</h3>
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
                        <p class="card-text"> Optimize tx planning Request </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $optimizelist_txplanning }}</h3>
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
                        <p class="card-text"> Discontinue tx planning list </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $discontinuelist_txplanning }}</h3>
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
                        <p class="card-text"> Upgradtionlist tx planning list </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $upgradtionlist_txplanning }}</h3>
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
                        <p class="card-text"> Downgradtionlist tx planning list </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $downgradtionlist_txplanning }}</h3>
                    </div>
                    <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                        <div class="avatar-content">
                            <i data-feather="user" class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (check_access('level_3'))
        <div class="col-4">
            <div class="card gr_1_color">
                <div class="card-header ">
                    <div>
                        <p class="card-text"> Techonlogy Level_3 Request </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $level3 }}</h3>
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
                        <p class="card-text"> Optimize Level_3 Request </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $level3ResellerOptimize }}</h3>
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
                        <p class="card-text"> NiRequest Level_3 </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $level3nirequest }}</h3>
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
                        <p class="card-text"> Discontinue level_3 list </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $level3Discontinue }}</h3>
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
                        <p class="card-text"> Upgradtion level_3 list </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $level3Discontinue }}</h3>
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
                        <p class="card-text"> Downgradtion level_3 list </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $level3Downgradtion }}</h3>
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
                        <p class="card-text"> Uncap level_3 list </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $level3uncap }}</h3>
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
                        <p class="card-text"> Cap level_3 list </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $level3cap }}</h3>
                    </div>
                    <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                        <div class="avatar-content">
                            <i data-feather="user" class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    @if (check_access('level_2'))
        <div class="col-4">
            <div class="card gr_1_color">
                <div class="card-header ">
                    <div>
                        <p class="card-text ">Technology level_2 Request </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $level2 }}</h3>
                    </div>
                    <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                        <div class="avatar-content">
                            <i data-feather="user" class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (check_access('level_1'))
        <div class="col-4">
            <div class="card gr_1_color">
                <div class="card-header ">
                    <div>
                        <p class="card-text ">Technology level_1 Request </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $level1 }}</h3>
                    </div>
                    <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                        <div class="avatar-content">
                            <i data-feather="user" class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (check_access('level_4'))
        <div class="col-4">
            <div class="card gr_1_color">
                <div class="card-header ">
                    <div>
                        <p class="card-text ">Technology level 4 Request </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $level4 }}</h3>
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
                        <p class="card-text ">Uncap level 4 Request </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $level4uncap }}</h3>
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
                        <p class="card-text ">Cap level 4 Request </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $level4cap }}</h3>
                    </div>
                    <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                        <div class="avatar-content">
                            <i data-feather="user" class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (check_access('transmission'))
        <div class="col-4">
            <div class="card gr_1_color">
                <div class="card-header ">
                    <div>
                        <p class="card-text ">Technology transmission Request </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $transmission }}</h3>
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
                        <p class="card-text"> Optimize transmission Request </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $optimizelist_transmission }}</h3>
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
                        <p class="card-text"> NiRequest transmission </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $nirequest_transmission }}</h3>
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
                        <p class="card-text">Discontinue transmission list </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $discontinuelist_transmission }}</h3>
                    </div>
                    <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                        <div class="avatar-content">
                            <i data-feather="user" class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (auth()->user()->is_admin == 1)
        <div class="col-4">
            <div class="card gr_1_color">
                <div class="card-header ">
                    <div>
                        <p class="card-text">Active Clients</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $bandwith_clients }}</h3>
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
                        <p class="card-text">Pending Clients</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $pendingcustomer }}</h3>
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
                        <p class="card-text"> Discontinue </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ count($disconnect) }}</h3>
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
                        <p class="card-text"> {{ date('F') }} Generate Bill </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $monthbillgenerate }}</h3>
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
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $differencedeu }}</h3>
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
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $differencecollected }}</h3>
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
                        <p class="card-text"> Pending Optimize Request </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $optimizelist }}</h3>
                    </div>
                    <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                        <div class="avatar-content">
                            <i data-feather="bell" class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card gr_1_color">
                <div class="card-header ">
                    <div>
                        <p class="card-text"> Pending Upgradtion Request </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $upgradtionlist }}</h3>
                    </div>
                    <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                        <div class="avatar-content">
                            <i data-feather="corner-left-up" class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card gr_1_color">
                <div class="card-header ">
                    <div>
                        <p class="card-text"> Pending Downgradtion Request </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $downgradtionlist }}</h3>
                    </div>
                    <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                        <div class="avatar-content">
                            <i data-feather="corner-right-down" class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card gr_1_color">
                <div class="card-header ">
                    <div>
                        <p class="card-text"> Pending Discontinue Request </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $discontinuelist }}</h3>
                    </div>
                    <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                        <div class="avatar-content">
                            <i data-feather="corner-right-down" class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card gr_1_color">
                <div class="card-header ">
                    <div>
                        <p class="card-text"> Reseller uncap request</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $reselleruncap }}</h3>
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
                        <p class="card-text">ONETIME</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $reselleruncap }}</h3>
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
                <form id="billingForm" action="{{ route('report.billingperiod') }}" method="post"
                    onclick="this.submit()">
                    @csrf
                    <input type="hidden" name="month" value="{{ date('Y-m') }}" class="form-control">
                    <input type="hidden" name="billing_frequency" value="MONTHLY" class="form-control">
                    <div class="card-header">
                        <div>
                            <p class="card-text">MONTHLY</p>
                            <h3 class="font-weight-bolder mb-0 h3_title">{{ $monthlyAmount }}</h3>
                        </div>
                        <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                            <div class="avatar-content">
                                <i data-feather="navigation-2" class="font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card gr_1_color">
                <form id="billingForm" action="{{ route('report.billingperiod') }}" method="post"
                    onclick="this.submit()">
                    @csrf
                    <input type="hidden" name="month" value="{{ date('Y-m') }}" class="form-control">
                    <input type="hidden" name="billing_frequency" value="YEARLY" class="form-control">
                    <div class="card-header">
                        <div>
                            <p class="card-text">YEARLY</p>
                            <h3 class="font-weight-bolder mb-0 h3_title">{{ $yearAmount }}</h3>
                        </div>
                        <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                            <div class="avatar-content">
                                <i data-feather="navigation-2" class="font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card gr_1_color">
                <div class="card-header ">
                    <div>
                        <p class="card-text"> Total Task</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ count($tasks) }}</h3>
                    </div>
                    <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                        <div class="avatar-content">
                            <i data-feather="corner-right-down" class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card gr_1_color">
                <div class="card-header ">
                    <div>
                        <p class="card-text"> Pandding Task</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $tasks->where('status', 'Pandding')->count() }}
                        </h3>
                    </div>
                    <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                        <div class="avatar-content">
                            <i data-feather="corner-right-down" class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card gr_1_color">
                <div class="card-header ">
                    <div>
                        <p class="card-text"> In Progress Task</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $tasks->where('status', 'in_progress')->count() }}
                        </h3>
                    </div>
                    <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                        <div class="avatar-content">
                            <i data-feather="corner-right-down" class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card gr_1_color">
                <div class="card-header ">
                    <div>
                        <p class="card-text"> Completed Task</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ $tasks->where('status', 'Completed')->count() }}
                        </h3>
                    </div>
                    <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                        <div class="avatar-content">
                            <i data-feather="corner-right-down" class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12" id="lead_html">
        </div>
    @endif
    </div>

    @if (check_access('level_4') || check_access('level_1') || check_access('level_2') || check_access('level_3'))
        <div class="row ticketid">

        </div>
    @endif
@endsection

@section('scripts')
    <script>
        $.get('{{ route('dashboard.ticketlist') }}', {
            _token: '{{ csrf_token() }}'
        }, function(data) {
            $('.ticketid').html(data);
        });

        $.get('{{ route('dashboard.lead_details') }}', {
            _token: '{{ csrf_token() }}'
        }, function(data) {
            $('#lead_html').html(data);
        });
    </script>
@endsection
