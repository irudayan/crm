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
    <link rel="stylesheet" href="{{ asset('backend/css/colors.css') }}" />
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
</head>

<body class="header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden login-page">
    <div class="c-app flex-row align-items-center">
        <div class="container">
            @yield('content')
        </div>
    </div>
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
    @yield('scripts')
</body>

</html>
