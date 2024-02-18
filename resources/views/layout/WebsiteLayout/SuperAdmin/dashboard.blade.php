<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <link href="{{ asset('storage/WebsiteAsset/SuperAdmin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('storage/WebsiteAsset/SuperAdmin/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <!-- Morris -->
    <link href="{{ asset('storage/WebsiteAsset/SuperAdmin/css/plugins/morris/morris-0.4.3.min.css') }}" rel="stylesheet">

    <link href="{{ asset('storage/WebsiteAsset/SuperAdmin/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('storage/WebsiteAsset/SuperAdmin/css/style.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('extra/dashboard.png') }}"> 
    @yield('links')
</head>

<body>
    <div id="wrapper">
        @include('layout.WebsiteLayout.SuperAdmin.dashboard.nav')
        @include('layout.WebsiteLayout.SuperAdmin.dashboard.header')
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/popper.min.js') }}"></script>
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/bootstrap.js') }}"></script>
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Flot -->
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/plugins/flot/jquery.flot.spline.js') }}"></script>
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/plugins/flot/jquery.flot.symbol.js') }}"></script>
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/plugins/flot/curvedLines.js') }}"></script>

    <!-- Peity -->
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/demo/peity-demo.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/inspinia.js') }}"></script>
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/plugins/pace/pace.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- Jvectormap -->
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

    <!-- Sparkline -->
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Sparkline demo data  -->
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/demo/sparkline-demo.js') }}"></script>

    <!-- ChartJS-->
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/plugins/chartJs/Chart.min.js') }}"></script>
    @yield('script')
</body>
</html>
