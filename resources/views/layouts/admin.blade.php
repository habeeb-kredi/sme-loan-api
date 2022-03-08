{{--<!DOCTYPE html>--}}
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
{{--<head>--}}
{{--    <meta charset="utf-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1">--}}
{{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}

{{--    <title inertia>{{ config('app.name', 'Laravel') }}</title>--}}

{{--    <!-- Fonts -->--}}
{{--    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">--}}

{{--    <!-- Styles -->--}}
{{--    <link rel="stylesheet" href="{{ mix('css/app.css') }}">--}}

{{--    <!-- Scripts -->--}}
{{--    @routes--}}
{{--    <script src="{{ mix('js/app.js') }}" defer></script>--}}
{{--    <meta charset="utf-8"/>--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
{{--    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>--}}
{{--    <meta content="Themesbrand" name="author"/>--}}
{{--    <!-- App favicon -->--}}
{{--    <link rel="shortcut icon" href="assets/images/favicon.ico">--}}

{{--    <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />--}}

{{--    <!-- preloader css -->--}}
{{--    <link rel="stylesheet" href="assets/css/preloader.min.css" type="text/css" />--}}

{{--    <!-- Bootstrap Css -->--}}
{{--    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />--}}
{{--    <!-- Icons Css -->--}}
{{--    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />--}}
{{--    <!-- App Css-->--}}
{{--    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />--}}
{{--    <link rel="stylesheet" href="{{ mix('css/app.css') }}">--}}
{{--    <script src="{{ mix('js/app.js') }}" defer></script>--}}
{{--</head>--}}
{{--<body class="font-sans antialiased">--}}
{{--@inertia--}}

{{--@env ('local')--}}
{{--    <script src="http://localhost:8080/js/bundle.js"></script>--}}
{{--@endenv--}}
{{--</body>--}}
{{--</html>--}}

        <!DOCTYPE html>
<html lang="">

<head>
    <title> Minia - Admin & Dashboard Template</title>

    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />

    <!-- preloader css -->
    <link rel="stylesheet" href="assets/css/preloader.min.css" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
{{--    <link rel="stylesheet" href="{{ mix('css/app.css') }}">--}}
    @routes
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body>

<!-- Begin page -->
<div id="layout-wrapper">

    @inertia

</div>
<!-- END layout-wrapper -->


<!-- Right Sidebar -->
<?php //include 'layouts/right-sidebar.php'; ?>
<!-- /Right-bar -->

<!-- JAVASCRIPT -->
<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/metismenu/metisMenu.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/node-waves/waves.min.js"></script>
<script src="assets/libs/feather-icons/feather.min.js"></script>
<!-- pace js -->
<script src="assets/libs/pace-js/pace.min.js"></script>

<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>

<!-- Plugins js-->
<script src="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>

<!-- dashboard init -->
<script src="assets/js/pages/dashboard.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>
@env ('local')
    <script src="http://localhost:8080/js/bundle.js"></script>
@endenv
</body>

</html>