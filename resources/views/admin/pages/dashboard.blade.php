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
            /* background: linear-gradient(150deg, #f731db, #4600f1 100%); */
            color: #fff;
            background-image: linear-gradient(135deg, #10223d 0%, #1b3344 50%, #0e414d 100%) !important;
            transition: background-image 0.5s ease;
        }

        .gr_1_color:hover {
            background-image: linear-gradient(135deg, #0e414d 0%, #1b3344 50%, #10223d 100%) !important;
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
                            <p class="card-text">Active lients</p>
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
                        <p class="card-text">Today Lead</p>
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
                        <p class="card-text">This Month Lead</p>
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
                        <p class="card-text">Today Follow Up</p>
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
                        <p class="card-text">This Month Follow Up </p>
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
                        <p class="card-text">Today Meeting </p>
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
                        <p class="card-text">This Month Meeting</p>
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


        <div class="col-md-12" id="lead_html">
        </div>

        <div class="col-4">
            <div class="card gr_1_color">
                <div class="card-header ">
                    <div>
                        <p class="card-text">Today Quotation</p>
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
                        <p class="card-text">This Month Quotation</p>
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
                        <p class="card-text">High Priority Lead</p>
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
                        <p class="card-text">All Tasks</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ '200' }}</h3>
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
                        <p class="card-text">Pending Tasks</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ '20' }}</h3>
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
                        <p class="card-text">Ongoing Tasks</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                        <p class="card-text">Complate Tasks</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                        <p class="card-text">Upcoming Sales</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                        <p class="card-text">Today Sales</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
                    </div>

                    <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                        <div class="avatar-content">
                            <i data-feather="user" class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- chart  start --}}
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="card shadow border-0">
                <div class="card-header" style="background: linear-gradient(135deg, #110d2e, #0faeb8); color:#fff">
                    <h5 class="text-center text-white">Monthly Sales</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-center"></h5>
                            <canvas id="newCustomerChart" style="width: 100%; height: 250px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="card shadow border-0">
                <div class="card-header" style="background: linear-gradient(135deg, #110d2e, #0faeb8); color:#fff">
                    <h5 class="text-center text-white">Recent Sales</h5>
                </div>
                <div class="card-body p-0" style="max-height: 278px; overflow-y: auto; overflow-x: auto;">
                    <table class="unPaidClientTable table table-bordered table-striped"
                        style="width: 100%;     height: 280px;">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Phone</th>
                                <th>Billing Amount</th>
                                <th>Due Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- chart  end --}}

        <div class="col-4">
            <div class="card gr_1_color">
                <div class="card-header ">
                    <div>
                        <p class="card-text">This Month Sales</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                        <p class="card-text">Pending Sales</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                        <p class="card-text">Sales Cancel</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                        <p class="card-text">Retrive</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                        <p class="card-text">New sales from Lead </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                        <p class="card-text">New sales from Lead </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                        <p class="card-text">New sales from Lead </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                        <p class="card-text">New sales from Lead </p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                        <p class="card-text">Sales Achievement</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                        <p class="card-text">Best seller</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
                    </div>

                    <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                        <div class="avatar-content">
                            <i data-feather="user" class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- tech --}}
        <div class="col-4">
            <div class="card gr_1_color">
                <div class="card-header ">
                    <div>
                        <p class="card-text">All Projects</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                        <p class="card-text">Pending Projects</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                        <p class="card-text">Ongoing Projects</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                        <p class="card-text">Completed Projects</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                        <p class="card-text">Projects Summary</p>
                        <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
                    </div>

                    <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                        <div class="avatar-content">
                            <i data-feather="user" class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="ticketid">
            </div>
        </div>


        <div class="col-12">
            <h1 class="mb-2">
                Finance
            </h1>
            <div class="row">
                <div class="col-4">
                    <div class="card gr_1_color">
                        <div class="card-header ">
                            <div>
                                <p class="card-text">Today Scheduled Receivable</p>
                                <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                                <p class="card-text">This Month Scheduled Receivable</p>
                                <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                                <p class="card-text">This Month all Receivable </p>
                                <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                                <p class="card-text">This Month Subscriber Receivable </p>
                                <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                                <p class="card-text">This Month Project Receivable </p>
                                <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                                <p class="card-text">This Month Yearly Renewal Receivable </p>
                                <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                                <p class="card-text">Today Scheduled Payment </p>
                                <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                                <p class="card-text">This Month Scheduled Payment </p>
                                <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                                <p class="card-text"> This Month All Payment </p>
                                <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
        </div>


        <div class="col-md-12" id="lead_html">
        </div>


        <!--task start -->
        <div class="col-12">
            <h1 class="mb-2 mt-2">Task</h1>
            <div class="row">
                <div class="col-4">
                    <div class="card gr_1_color">
                        <div class="card-header ">
                            <div>
                                <p class="card-text"> Total Tasks </p>
                                <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                                <p class="card-text"> Pending Tasks </p>
                                <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                                <p class="card-text"> Ongoing Tasks </p>
                                <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
                                <p class="card-text"> Completed Tasks </p>
                                <h3 class="font-weight-bolder mb-0 h3_title">{{ '0' }}</h3>
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
