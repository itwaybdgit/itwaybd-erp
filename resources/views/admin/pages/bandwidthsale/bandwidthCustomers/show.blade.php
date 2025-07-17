@extends('admin.master')


@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashtreme Admin - Free Dashboard for Bootstrap 4 by Codervent</title>
        <link rel="icon" href="{{ asset('/assets/images/favicon.icon') }}" type="image/x-icon">
        <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/sidebar-menu.css') }}" rel="stylesheet" />



    </head>

    <body class="bg-theme bg-red">

        <!-- start loader -->
        <div id="pageloader-overlay" class="visible incoming">
            <div class="loader-wrapper-outer">
                <div class="loader-wrapper-inner">
                    <div class="loader"></div>
                </div>
            </div>
        </div>
        <!-- end loader -->

        <!-- Start wrapper-->
        <div id="wrapper">


            </header>
            <!--End topbar header-->

            <div class="clearfix"></div>

            <div class="content-wrapper">
                <div class="container-fluid">
                    <div class="row mt-3">






                    </div>
                    <style>
                        .td {
                            font-size: 200px
                        }
                    </style>

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
                                    <li class="nav-item">
                                        <a href="javascript:void();" data-target="#profile" data-toggle="pill"
                                            class="nav-link active"><i class="icon-user"></i> <span
                                                class="hidden-xs">Profile</span></a>
                                    </li>

                                </ul>
                                <div class="tab-content p-3" class="bg-primary">
                                    <div class="tab-pane active" id="profile">
                                        <h5 class="mb-3">User Profile</h5>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive" class="text-white">
                                                    <div class="container">
                                                        <h4>Bandwidth Customer</h4>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <strong>Company Name</strong>: {{ $customer->company_name }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Contact Owner Name</strong>:
                                                                {{ $customer->company_owner_name }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <strong>Company owner phone</strong>:
                                                                {{ $customer->company_owner_phone }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Contact person name</strong>:
                                                                {{ $customer->contact_person_name }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <strong>Contact person phone</strong>:
                                                                {{ $customer->contact_person_phone }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Customer address</strong>:
                                                                {{ $customer->customer_address }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <strong>Licenstype name</strong>:
                                                                {{ $customer->licensetype->name ?? "" }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Division</strong>:
                                                                {{ $customer->division->name ?? null }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <strong>District </strong>:
                                                                {{ $customer->district->district_name ?? "" }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Upazila </strong>:
                                                                {{ $customer->upazilla->upozilla_name ?? "" }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <strong>Road</strong>: {{ $customer->road }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>House</strong>: {{ $customer->house }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <strong>Latitude</strong>: {{ $customer->latitude }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Longitude</strong>: {{ $customer->longitude }}
                                                            </div>
                                                        </div>
                                                        <h4 class="mt-2">Admin Contact</h4>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <strong>Admin name</strong>: {{ $customer->admin_name }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Admin designation</strong>:
                                                                {{ $customer->admin_designation }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <strong>Admin cell</strong>: {{ $customer->admin_cell }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Admin email</strong>: {{ $customer->admin_email }}
                                                            </div>
                                                        </div>


                                                        <h4 class="mt-2">Billing Contact</h4>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <strong>Billing name</strong>:
                                                                {{ $customer->billing_name }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Billing designation</strong>:
                                                                {{ $customer->billing_designation }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <strong>Billing cell</strong>:
                                                                {{ $customer->billing_cell }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Billing email</strong>:
                                                                {{ $customer->billing_email }}
                                                            </div>
                                                        </div>
                                                        <h4 class="mt-2">Technical Contact

                                                        </h4>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <strong>Technical name</strong>:
                                                                {{ $customer->technical_name }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Technical designation</strong>:
                                                                {{ $customer->technical_designation }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <strong>Technical Cell</strong>:
                                                                {{ $customer->technical_cell }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Technical designation</strong>:
                                                                {{ $customer->technical_email }}
                                                            </div>
                                                        </div>
                                                        <h4 class="mt-2">Technical Contact
                                                        </h4>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <strong>Technical name</strong>:
                                                                {{ $customer->technical_name }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Technical designation</strong>:
                                                                {{ $customer->technical_designation }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <strong>Technical Cell</strong>:
                                                                {{ $customer->technical_cell }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Technical email</strong>:
                                                                {{ $customer->technical_email }}
                                                            </div>
                                                        </div>
                                                        <h4 class="mt-2">User Access
                                                        </h4>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <strong>Phone</strong>:
                                                                {{ $customer->company_owner_phone }}
                                                            </div>
                                                            <div class="col-md-12">
                                                                <strong>Password</strong>:
                                                                {{ $customer->m_password }}
                                                            </div>
                                                        </div>
                                                        <h4 class="mt-2">Package
                                                        </h4>


                                                        <table class="table table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" width="25%">
                                                                        <small class="text-secondary">Item</small>
                                                                    </th>
                                                                    <th scope="col" width="20%">
                                                                        <small class="text-secondary">Quantity</small>
                                                                    </th>
                                                                    <th scope="col" width="20%">
                                                                        <small class="text-secondary">Price</small>
                                                                    </th>
                                                                    @if ($customer->vat_check == 'yes')
                                                                        <th scope="col" width="15%"
                                                                            class="vatcolumn">
                                                                            <small class="text-secondary">Vat(%)</small>
                                                                        </th>
                                                                    @endif
                                                                    <th scope="col" width="25%">
                                                                        <small class="text-secondary">Total</small>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $total = 0;
                                                                @endphp
                                                                @foreach ($customer->package as $value)
                                                                    <tr>
                                                                        <td>{{ $value->item->name ?? '' }}</td>
                                                                        <td>{{ $value->qty ?? '' }}</td>
                                                                        <td>{{ $value->rate ?? '' }}</td>
                                                                        @if ($customer->vat_check == 'yes')
                                                                            <td>{{ $value->vat ?? '' }}</td>
                                                                            @php
                                                                                $vat = $value->vat / 100;
                                                                            @endphp
                                                                        @else
                                                                        @endif
                                                                        @php
                                                                            $addvat =
                                                                                $value->qty *
                                                                                $value->rate *
                                                                                ($vat ?? 0);
                                                                            $subtotal =
                                                                                $value->qty * $value->rate + $addvat;
                                                                            $total += $subtotal;
                                                                        @endphp
                                                                        <td>{{ $subtotal ?? '' }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    @if ($customer->vat_check == 'yes')
                                                                        <td></td>
                                                                    @endif
                                                                    <td>{{ $total }}</td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>

                                                        <h4>Remark</h4>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <td>
                                                                    <strong>Remark </strong>: {{ $customer->remark }}
                                                                </td>
                                                            </div>
                                                        </div>

                                                        <style>
                                                            button,
                                                            input,
                                                            optgroup,
                                                            select,
                                                            textarea {
                                                                margin: 0;
                                                                font-family: inherit;
                                                                font-size: inherit;
                                                                line-height: inherit;
                                                                visibility: hidden;
                                                            }

                                                            .card .card {
                                                                box-shadow: none !important;
                                                                padding: 2px;
                                                            }

                                                            .card-footer:last-child {
                                                                border-radius: 0 0 calc(.25rem - 1px) calc(.25rem - 1px);
                                                                display: none;
                                                                padding: 0px
                                                            }
                                                        </style>


   <div class="mt-5">
    <div class="card" class="mt-3">
        <div class="card-header" class="">
            <h4 class="card-title">{{ __('Legal Documents') }}</h4>
        </div>
        <div class="card-body">
            <div class="row bg-white">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">{{ __('Agreement') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php

                                $extension1 = File::extension(
                                    $legalInfo->agreement ?? '',
                                );
                            @endphp
                            @if (in_array($extension1, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension1, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension1, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension1, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->agreement ?? '') }}"
                                    class="w-50" height="50px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="agreement" class="form-control">
                            @if ($legalInfo->agreement ?? '')
                                <a href="{{ asset('storage' . $legalInfo->agreement ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">{{ __('Cheque') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension2 = File::extension($legalInfo->cheque ?? '');
                            @endphp
                            @if (in_array($extension2, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50 "
                                    alt="">
                            @elseif (in_array($extension2, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension2, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension2, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->cheque ?? '') }}"
                                    class="w-50" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="cheque" class="form-control">

                            @if ($legalInfo->cheque ?? '')
                                <a href="{{ asset('storage' . $legalInfo->cheque ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">{{ __('Work Order') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension2 = File::extension($legalInfo->work_order ?? '');
                            @endphp
                            @if (in_array($extension2, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50 "
                                    alt="">
                            @elseif (in_array($extension2, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension2, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif(in_array($extension2, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->work_order ?? '') }}"
                                    class="w-50" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="work_order" class="form-control">

                            @if ($legalInfo->work_order ?? '')
                                <a href="{{ asset('storage' . $legalInfo->work_order ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">
                                {{ __('Cheque Authorization') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension3 = File::extension(
                                    $legalInfo->cheque_authorization ?? '',
                                );
                            @endphp
                            @if (in_array($extension3, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension3, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension3, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension3, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->cheque_authorization ?? '') }}"
                                    class="w-50" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="cheque_authorization"
                                class="form-control">

                            @if ($legalInfo->cheque_authorization ?? '')
                                <a href="{{ asset('storage' . $legalInfo->cheque_authorization ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">{{ __('Cash') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension4 = File::extension($legalInfo->cash ?? '');
                            @endphp
                            @if (in_array($extension4, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension4, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension4, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension4, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->cash ?? '') }}"
                                    class="w-50" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="cash" class="form-control">

                            @if ($legalInfo->cash ?? '')
                                <a href="{{ asset('storage' . $legalInfo->cash ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">
                                {{ __('NOC Payment Clearance') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension5 = File::extension(
                                    $legalInfo->noc_payment_clearance ?? '',
                                );
                            @endphp
                            @if (in_array($extension5, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension5, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension5, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension5, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->noc_payment_clearance ?? '') }}"
                                    class="w-50" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="noc_payment_clearance"
                                class="form-control">

                            @if ($legalInfo->noc_payment_clearance ?? '')
                                <a href="{{ asset('storage' . $legalInfo->noc_payment_clearance ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">{{ __('ISP License') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension6 = File::extension(
                                    $legalInfo->isp_license ?? '',
                                );
                            @endphp
                            @if (in_array($extension6, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension6, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension6, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension6, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->isp_license ?? '') }}"
                                    class="w-50" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="isp_license"
                                class="form-control">

                            @if ($legalInfo->isp_license ?? '')
                                <a href="{{ asset('storage' . $legalInfo->isp_license ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">{{ __('Conversion') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension7 = File::extension(
                                    $legalInfo->conversion ?? '',
                                );
                            @endphp
                            @if (in_array($extension7, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension7, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension7, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension7, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->conversion ?? '') }}"
                                    class="w-50" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="conversion" class="form-control">

                            @if ($legalInfo->conversion ?? '')
                                <a href="{{ asset('storage' . $legalInfo->conversion ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">{{ __('Renewal') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension8 = File::extension(
                                    $legalInfo->renewal ?? '',
                                );
                            @endphp
                            @if (in_array($extension8, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension8, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension8, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension8, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->renewal ?? '') }}"
                                    class="w-50" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="renewal" class="form-control">

                            @if ($legalInfo->renewal ?? '')
                                <a href="{{ asset('storage' . $legalInfo->renewal ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">{{ __('Trade') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension9 = File::extension($legalInfo->trade ?? '');
                            @endphp
                            @if (in_array($extension9, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension9, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension9, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension9, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->trade ?? '') }}"
                                    class="w-50" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="trade" class="form-control">

                            @if ($legalInfo->trade ?? '')
                                <a href="{{ asset('storage' . $legalInfo->trade ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">{{ __('NID') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension10 = File::extension($legalInfo->nid ?? '');
                            @endphp
                            @if (in_array($extension10, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension10, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension10, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension10, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->nid ?? '') }}"
                                    class="w-50" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="nid" class="form-control">

                            @if ($legalInfo->nid ?? '')
                                <a href="{{ asset('storage' . $legalInfo->nid ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">{{ __('Photo') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension11 = File::extension($legalInfo->photo ?? '');
                            @endphp
                            @if (in_array($extension11, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension11, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension11, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension11, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->photo ?? '') }}"
                                    class="w-50" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="photo" class="form-control">

                            @if ($legalInfo->photo ?? '')
                                <a href="{{ asset('storage' . $legalInfo->photo ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">{{ __('TIN') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension12 = File::extension($legalInfo->tin ?? '');
                            @endphp
                            @if (in_array($extension12, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension12, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension12, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension12, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->tin ?? '') }}"
                                    class="w-50" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="tin" class="form-control">

                            @if ($legalInfo->tin ?? '')
                                <a href="{{ asset('storage' . $legalInfo->tin ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">{{ __('BIN') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension13 = File::extension($legalInfo->bin ?? '');
                            @endphp
                            @if (in_array($extension13, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension13, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension13, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension13, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->bin ?? '') }}"
                                    class="w-50" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="bin" class="form-control">

                            @if ($legalInfo->bin ?? '')
                                <a href="{{ asset('storage' . $legalInfo->bin ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">
                                {{ __('Authorization Letter') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension14 = File::extension(
                                    $legalInfo->authorization_letter ?? '',
                                );
                            @endphp
                            @if (in_array($extension14, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension14, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension14, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-100"
                                    alt="">
                            @elseif (in_array($extension14, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->authorization_letter ?? '') }}"
                                    class="w-100" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="authorization_letter"
                                class="form-control">

                            @if ($legalInfo->authorization_letter ?? '')
                                <a href="{{ asset('storage' . $legalInfo->authorization_letter ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">
                                {{ __('Partnership Deed Org') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension15 = File::extension(
                                    $legalInfo->partnership_deed_org ?? '',
                                );
                            @endphp
                            @if (in_array($extension15, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-100"
                                    alt="">
                            @elseif (in_array($extension15, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-100"
                                    alt="">
                            @elseif (in_array($extension15, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension15, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->partnership_deed_org ?? '') }}"
                                    class="w-50" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="partnership_deed_org"
                                class="form-control">

                            @if ($legalInfo->partnership_deed_org ?? '')
                                <a href="{{ asset('storage' . $legalInfo->partnership_deed_org ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">
                                {{ __('Partnership Deed') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension16 = File::extension(
                                    $legalInfo->partnership_deed ?? '',
                                );
                            @endphp
                            @if (in_array($extension16, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension16, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension16, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension16, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->partnership_deed ?? '') }}"
                                    class="w-50" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="partnership_deed"
                                class="form-control">

                            @if ($legalInfo->partnership_deed ?? '')
                                <a href="{{ asset('storage' . $legalInfo->partnership_deed ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">
                                {{ __('Power of Attorney') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension17 = File::extension(
                                    $legalInfo->power_of_attorney ?? '',
                                );
                            @endphp
                            @if (in_array($extension17, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension17, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension17, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension17, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->power_of_attorney ?? '') }}"
                                    class="w-50" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="power_of_attorney"
                                class="form-control">

                            @if ($legalInfo->power_of_attorney ?? '')
                                <a href="{{ asset('storage' . $legalInfo->power_of_attorney ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">
                                {{ __('Cert. of Incorporation') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension18 = File::extension(
                                    $legalInfo->cert_of_incorporation ?? '',
                                );
                            @endphp
                            @if (in_array($extension18, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension18, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension18, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension18, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->cert_of_incorporation ?? '') }}"
                                    class="w-50" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="cert_of_incorporation"
                                class="form-control">

                            @if ($legalInfo->cert_of_incorporation ?? '')
                                <a href="{{ asset('storage' . $legalInfo->cert_of_incorporation ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">{{ __('Form XII') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension19 = File::extension(
                                    $legalInfo->form_xii ?? '',
                                );
                            @endphp
                            @if (in_array($extension19, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension19, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension19, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension19, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->form_xii ?? '') }}"
                                    class="w-50" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="form_xii" class="form-control">

                            @if ($legalInfo->form_xii ?? '')
                                <a href="{{ asset('storage' . $legalInfo->form_xii ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">{{ __('MOA AOA') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension20 = File::extension(
                                    $legalInfo->moa_aoa ?? '',
                                );
                            @endphp
                            @if (in_array($extension20, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension20, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension20, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension20, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->moa_aoa ?? '') }}"
                                    class="w-50" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="moa_aoa" class="form-control">

                            @if ($legalInfo->moa_aoa ?? '')
                                <a href="{{ asset('storage' . $legalInfo->moa_aoa ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">{{ __('Utility Bill') }}
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension21 = File::extension(
                                    $legalInfo->utility_bill ?? '',
                                );
                            @endphp
                            @if (in_array($extension21, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension21, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension21, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension21, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->utility_bill ?? '') }}"
                                    class="w-50" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="utility_bill"
                                class="form-control">

                            @if ($legalInfo->utility_bill ?? '')
                                <a href="{{ asset('storage' . $legalInfo->utility_bill ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">{{ __('User List') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension22 = File::extension(
                                    $legalInfo->user_list ?? '',
                                );
                            @endphp
                            @if (in_array($extension22, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension22, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension22, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension22, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->user_list ?? '') }}"
                                    class="w-50" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="user_list" class="form-control">

                            @if ($legalInfo->user_list ?? '')
                                <a href="{{ asset('storage' . $legalInfo->user_list ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">{{ __('Rent Agreement') }}
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension23 = File::extension(
                                    $legalInfo->rent_agreement ?? '',
                                );
                            @endphp
                            @if (in_array($extension23, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension23, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension23, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension23, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->rent_agreement ?? '') }}"
                                    class="w-50" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="rent_agreement"
                                class="form-control">

                            @if ($legalInfo->rent_agreement ?? '')
                                <a href="{{ asset('storage' . $legalInfo->rent_agreement ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">
                                {{ __('Equipment Agreement') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension24 = File::extension(
                                    $legalInfo->equipment_agreement ?? '',
                                );
                            @endphp
                            @if (in_array($extension24, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension24, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension24, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension24, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->equipment_agreement ?? '') }}"
                                    class="w-50" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="equipment_agreement"
                                class="form-control">
                            @if ($legalInfo->equipment_agreement ?? '')
                                <a href="{{ asset('storage' . $legalInfo->equipment_agreement ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header p-0">
                            <h6 class="text-center py-0 my-0">
                                {{ __('IP Lease Agreement') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $extension25 = File::extension(
                                    $legalInfo->iP_lease_agreement ?? '',
                                );
                            @endphp
                            @if (in_array($extension25, ['pdf']))
                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension25, ['doc', 'docx', 'rtf']))
                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension25, ['xls', 'xlsx', 'csv']))
                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                    alt="">
                            @elseif (in_array($extension25, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                <img src="{{ asset('storage' . $legalInfo->iP_lease_agreement ?? '') }}"
                                    class="w-50" height="150px" alt="">
                            @else
                            @endif
                        </div>
                        <div class="card-footer p-0" style="margin-top: 5px;">
                            <input type="file" name="iP_lease_agreement"
                                class="form-control">

                            @if ($legalInfo->iP_lease_agreement ?? '')
                                <a href="{{ asset('storage' . $legalInfo->iP_lease_agreement ?? '') }}"
                                    class="btn btn-sm btn-secondary" target="_blank"
                                    download>{{ __('Download') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   </div>


                                                    </div>





                                                </div><!--End wrapper-->


                                                <!-- Bootstrap core JavaScript-->
                                                <script src="assets/js/jquery.min.js"></script>
                                                <script src="assets/js/popper.min.js"></script>
                                                <script src="assets/js/bootstrap.min.js"></script>

                                                <!-- simplebar js -->
                                                <script src="assets/plugins/simplebar/js/simplebar.js"></script>
                                                <!-- sidebar-menu js -->
                                                <script src="assets/js/sidebar-menu.js"></script>

                                                <!-- Custom scripts -->
                                                <script src="assets/js/app-script.js"></script>

    </body>

    </html>
@endsection
