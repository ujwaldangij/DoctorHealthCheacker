<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <link href="{{ asset('storage/WebsiteAsset/SuperAdmin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('storage/WebsiteAsset/SuperAdmin/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('storage/WebsiteAsset/SuperAdmin/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('storage/WebsiteAsset/SuperAdmin/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('storage/WebsiteAsset/SuperAdmin/css/style.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('extra/doctor.png') }}">
    <style>
        #spinnerOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            /* Semi-transparent white background */
            z-index: 9999;
            /* Ensure it's above other content */
        }

        .ibox-content {
            /* Adjust styling for the spinner container as needed */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
    @yield('links')
</head>

<body class="gray-bg">
    <div id="spinnerOverlay">
        <div class="spiner-example">
            <div class="sk-spinner sk-spinner-rotating-plane"></div>
        </div>
    </div>
    <div class="middle-box text-center loginscreen   animated fadeInDown">
        @yield('content')
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/popper.min.js') }}"></script>
    <script src="{{ asset('storage/WebsiteAsset/SuperAdmin/js/bootstrap.js') }}"></script>
    @yield('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("spinnerOverlay").style.display = "none";
        });
    </script>
</body>

</html>
