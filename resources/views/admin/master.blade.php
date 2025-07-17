<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <link rel="apple-touch-icon" href="{{asset('admin_assets/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{!! App\Models\Company::first()->favicon ?? ''!!}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">

    <title>
        @if (isset($page_title) && $page_title)
        {{$page_title}} | {{ env('APP_NAME') }}
        @else
        {{ env('APP_NAME') }}
        @endif
    </title>
    <link rel="stylesheet" href="{{ asset('admin_assets/css/plugins/bs-stepper/bs-stepper.min.css') }}">
    @include('admin.include.style')
    <style>
        table tr td {
            color: black;
            font-weight: 600;
        }

        table tr th {
            color: black;
            font-weight: 600;
        }

        #buttons {
            display: flex;
            justify-content: end;
            margin-right: 10px;
        }

        .dt-buttons .dt-button {
            border: navajowhite;
            padding: 5px 20px;
            background: #161d31;
            color: #fff;
            box-shadow: inset 0px 0px 34px 0px rgba(155, 154, 154, 0.5);
        }
    </style>

</head>


<body class="vertical-layout vertical-menu-modern navbar-floating footer-static pace-done menu-expanded"
    data-open="click" data-menu="vertical-menu-modern" data-col="">
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        <!--**********************************
            Nav header start
        ***********************************-->
        <!--**********************************
            Nav header end
            ***********************************-->

        <!--**********************************
                Header start
                ***********************************-->
        @include('admin.include.header')

        <!--**********************************
                    Header end ti-comment-alt
                    ***********************************-->

        <!--**********************************
                        Sidebar start
                        ***********************************-->
        <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
            <x-sidebar></x-sidebar>
        </div>



        <!--**********************************
                            Sidebar end
                            ***********************************-->

        <!--**********************************
                                Content body start
                                ***********************************-->
        <div class="app-content content">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper">
                @yield('content')
            </div>
        </div>
        <!--**********************************
            Content body end
            ***********************************-->
        <!--**********************************
                Footer start
                ***********************************-->
        @include('admin.include.footer')
        <!--**********************************
                    Footer end
                    ***********************************-->

        <!--**********************************
                        Support ticket button start
        ***********************************-->

        <!--**********************************
            Support ticket button end
            ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
        ***********************************-->

    <!--**********************************
            Scripts
            ***********************************-->
    <!-- Required vendors -->


    @include('admin.include.script')
    @include('admin.include.alertmessage')
    <script src="{{ asset('admin_assets/js/scripts/bs-stepper/bs-stepper.min.js') }}"></script>
    <script>
      $(document).ready(function () {
        $('.confirm').on('click', function (e) {
            e.preventDefault();
            let selectedBusinessId = $('#businessSelect').val();
            let approveURL = $(this).attr('approve-route');
            //   alert('Working');
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve!'
            })
            .then((result) => {
            if (result.isConfirmed) {
                var btn = this;
                $.ajax({
                url: approveURL,
                type: 'GET',
                data: { businessId: selectedBusinessId },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.code == 203) {
                    Swal.fire(
                        'Warning!',
                        'Your status id must be numeric.',
                        'success'
                    )
                    } else if (data.code == 404) {
                    Swal.fire(
                        'Warning!',
                        'Your status info not found.',
                        'warning'
                    )
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated',
                            text: data.message,
                        }).then(() => {
                            // Redirect to the dynamic URL from the response
                            window.location.href = data.redirect_url;
                        });
                    }
                },
                error: function(data) {
                    alert(data.responseText);
                }
                });
            }
            });
        });
    });

    </script>
</body>

</html>
