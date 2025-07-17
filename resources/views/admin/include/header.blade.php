<style>
    .nav_color {
        background-color: #0f172a !important;
        /* background-image: linear-gradient(135deg, #2600bd 0%, rgb(132 101 160 / 80%) 100%) !important; */
    }

    .color {
        color: #fff !important;
    }
</style>

<nav
    class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl nav_color navbar-dark">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon"
                            data-feather="menu"></i></a></li>
            </ul>
        </div>

        {{-- <li class="nav-item d-none d-lg-block text-left"><a href="{{ route('runSchedul') }}"
                class="btn btn-info">Sync</a></li> --}}

        <ul class="nav navbar-nav align-items-center ml-auto">
            </li>
            @php
                $notification = App\Models\Notification::where('is_view', 0)
                    ->where('user_id', auth()->id())
                    ->whereDate('created_at', date('Y-m-d'))
                    ->get();
                $count = count($notification);
            @endphp
            <li class="nav-item dropdown dropdown-notification mr-25"><a class="nav-link" href="javascript:void(0);"
                    data-toggle="dropdown"><i class="ficon" data-feather="bell"></i><span
                        class="badge badge-pill badge-danger badge-up noticeCount">{{ $count }}</span></a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                    <li class="dropdown-menu-header">
                        <div class="dropdown-header d-flex">
                            <h4 class="notification-title mb-0 mr-auto">Notifications</h4>
                            <div class="badge badge-pill badge-light-primary noticcountLevel">{{ $count }} New
                            </div>
                        </div>
                    </li>

                    <li class="scrollable-container media-list noticeBoard">
                        @foreach ($notification as $value)
                            <a class="d-flex" href="{{$value->link}}">
                                <div class="media d-flex align-items-start">
                                    <div class="media-left">
                                        <div class="avatar"><img
                                                src="https://png.pngtree.com/png-vector/20190725/ourmid/pngtree-bell-icon-png-image_1606555.jpg"
                                                alt="avatar" width="32" height="32"></div>
                                    </div>
                                    <div class="media-body">
                                        <p class="media-heading">
                                            <span class="font-weight-bolder">{{ $value->message }}</span>
                                        <div>
                                        <span class="notification-time text-danger ">{{ $value->created_at->format('M d, Y h:i A') }}</span>
                                        </div>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach

                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link"
                    id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="color user-nav d-sm-flex d-none"><span
                            class="user-name font-weight-bolder">{{ auth()->user()->name ?? '' }}</span><span
                            class="user-status">

                            @if (auth()->user()->is_admin == 1)
                            @elseif(auth()->user()->is_admin == 2)
                                Customer
                            @elseif(auth()->user()->is_admin == 3)
                                Mac Admin
                            @elseif(auth()->user()->is_admin == 4)
                                Employe
                            @elseif(auth()->user()->is_admin == 5)
                                Employe
                            @endif

                        </span></div><span class="avatar"><img class="round" src="{{ asset('dummy-image.jpg') }}"
                            alt="avatar" height="40" width="40"><span
                            class="avatar-status-online"></span></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user"><a class="dropdown-item"
                        href="{{ route('change.password') }}"><i class="mr-50" data-feather="edit"></i>
                        Update Profile</a>
                    <div class="dropdown-divider"></div>

                    <a href="{{ url('/logout') }}" class="dropdown-item"><i class="mr-50" data-feather="power"></i>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
