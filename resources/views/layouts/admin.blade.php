<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>@yield('title', __('panel.site_title')) - {{ trans('panel.site_title3') }} </title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- site icon -->
    <link rel="icon" href="{{ asset('backend/images/fevicon.png') }}" type="image/png" />
    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}" />
    <!-- site css -->
    <link rel="stylesheet" href="{{ asset('backend/style.css') }}" />
    <!-- responsive css -->
    <link rel="stylesheet" href="{{ asset('backend/css/responsive.css') }}" />
    <!-- color css -->
    {{--
    <link rel="stylesheet" href="{{ asset('backend/css/colors.css') }}" /> --}}
    <!-- select bootstrap -->
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap-select.css') }}" />
    <!-- scrollbar css -->
    <link rel="stylesheet" href="{{ asset('backend/css/perfect-scrollbar.css') }}" />
    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}" />
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
    {{-- 13-03-2025 --}}
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.0/css/buttons.bootstrap5.min.css">
    {{-- multiselect --}}
    <!-- Include Select2 CSS -->
    <!-- jQuery (Latest version from jQuery CDN) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- today --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>



</head>

<body class="dashboard dashboard_1">
    <div class="full_container">
        <div class="inner_container">
            <!-- Sidebar  -->
            @include('partials.menu')
            <!-- end sidebar -->
            <!-- right content -->
            <div id="content">
                <!-- topbar -->
                <div class="topbar">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <div class="full">
                            <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i
                                    class="fa fa-bars"></i></button>
                            <div class="logo_section">
                                <a href="{{ '/home' }}">
                                    <img class="img-responsive" src="{{ asset('backend/images/logo/logo.png') }}"
                                        alt="#" />
                                </a>
                            </div>
                            <div class="right_topbar">
                                <div class="icon_info">
                                    <ul>
                                        <li><a href="{{ route('admin.leads.index') }}" title="Total Leads"><i
                                                    class="fa fa-bell-o"></i><span class="badge" title="Total Leads"> {{
                                                    $todayLeads }}</span></a></li>
                                        {{-- <li>
                                            <a href="{{ route('admin.leads.index') }}" title="Today's Leads">
                                                <i class="fa fa-question-circle"></i>
                                                <span class="badge" title="Today's Leads">{{ $todayLeads }}</span>
                                            </a>
                                        </li> --}}
                                        @if (auth()->check() && auth()->id() == 1)
                                        <li>
                                            <a href="{{ route('admin.leads.index') }}" title="Not Opened Leads">
                                                <i class="fa fa-thumbs-up"></i>
                                                <span class="badge" title="Not Opened Leads">{{ $openedLeadsNull
                                                    }}</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('admin.leads.index') }}" title="Opened Leads">
                                                <i class="fa fa-thumbs-down"></i>
                                                <span class="badge" title="Opened Leads">{{ $openedLeadsNotNull
                                                    }}</span>
                                            </a>
                                        </li>
                                        @else
                                        <li>
                                            <a href="{{ route('admin.our-leads.index') }}" title="Not Opened Leads">
                                                <i class="fa fa-thumbs-up"></i>
                                                <span class="badge" title="Not Opened Leads">{{ $openedLeadsNull
                                                    }}</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('admin.our-leads.index') }}" title="Opened Leads">
                                                <i class="fa fa-thumbs-down"></i>
                                                <span class="badge" title="Opened Leads">{{ $openedLeadsNotNull
                                                    }}</span>
                                            </a>
                                        </li>
                                        @endif


                                    </ul>
                                    <ul class="user_profile_dd">
                                        <li>
                                            <a class="dropdown-toggle" data-toggle="dropdown">
                                                {{-- <img class="img-responsive rounded-circle"
                                                    src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : asset('backend/images/layout_img/user_img.jpg') }}"
                                                    alt="User Image" /> --}}

                                                <img class="img-responsive rounded-circle"
                                                    src="{{ auth()->user()->profile_image ? asset(auth()->user()->profile_image) : asset('backend/images/layout_img/user_img.jpg') }}"
                                                    alt="User Image" />

                                                <span class="name_user"> Welcome,
                                                    {{ auth()->user()->name }}</span></a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('profile.password.edit') }}">My
                                                    Profile</a>
                                                {{-- <a class="dropdown-item" href="settings.html">Settings</a>
                                                <a class="dropdown-item" href="help.html">Help</a> --}}
                                                {{-- <a class="dropdown-item" href="#"><span>Log Out</span> <i
                                                        class="fa fa-sign-out"></i></a> --}}
                                                <a href="#" class="dropdown-item"
                                                    onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                                                    <span> {{ trans('global.logout') }} <i
                                                            class="fa fa-sign-out red_color">
                                                        </i></span>
                                                </a>
                                            </div>


                                            {{-- <div class="dropdown-menu dropdown-menu-right">

                                                <a class="dropdown-item" href="{{ route('profile.password.edit') }}">
                                                    <i class="fa-fw fas fa-user"></i> &nbsp; cc
                                                </a>

                                                <a class="dropdown-item"
                                                    href="{{ route('profile.password.change-password') }}">
                                                    <i class="fa-fw fas fa-key"></i> &nbsp; {{
                                                    trans('global.change_password') }}
                                                </a>

                                                <a href="#" class="dropdown-item"
                                                    onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                                                    <i class="fas fa-fw fa-sign-out-alt">
                                                    </i> &nbsp;
                                                    {{ trans('global.logout') }}
                                                </a>
                                            </div> --}}


                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
                <!-- end topbar -->
                <!-- dashboard inner -->
                @yield('content')

                <!-- end dashboard inner -->
            </div>
        </div>
    </div>
    <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
    <!-- jQuery -->
    <script src="{{ asset('backend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/js/popper.min.js') }}"></script>
    <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
    <!-- wow animation -->
    <script src="{{ asset('backend/js/animate.js') }}"></script>
    <!-- select country -->
    <script src="{{ asset('backend/js/bootstrap-select.js') }}"></script>
    <!-- owl carousel -->
    <script src="{{ asset('backend/js/owl.carousel.js') }}"></script>
    <!-- chart js -->
    <script src="{{ asset('backend/js/Chart.min.js') }}"></script>
    <script src="{{ asset('backend/js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/js/utils.js') }}"></script>
    <script src="{{ asset('backend/js/analyser.js') }}"></script>
    <!-- nice scrollbar -->
    <script src="{{ asset('backend/js/perfect-scrollbar.min.js') }}"></script>
    <script>
        var ps = new PerfectScrollbar('#sidebar');
    </script>
    <!-- custom js -->
    <script src="{{ asset('backend/js/custom.js') }}"></script>
    <script src="{{ asset('backend/js/chart_custom_style1.js') }}"></script>
    {{-- 13-03-2025 --}}

    <!-- jQuery & DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.0/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.0/js/buttons.print.min.js"></script>

    {{-- multiselect --}}

    <!-- Include Select2 JS -->
    <!-- Include jQuery and Select2 -->

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- today --}}
    {{-- <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script> --}}



    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
    </script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script> --}}
    <script src="{{ asset('backend/js/main.js') }}"></script>
    @yield('scripts')
</body>

</html>