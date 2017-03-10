<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <title>Bracket Responsive Bootstrap3 Admin</title>
    <link href="{{ asset('css/style.default.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--[if lt IE 9]>
        <script src="{{ asset('js/html5shiv.js') }}"></script>
        <script src="{{ asset('js/respond.min.js') }}"></script>
    <![endif]-->
</head>
<body class="@yield('body-class')">
    @yield('layout')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-migrate-1.2.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/modernizr.min.js') }}"></script>
    <script src="{{ asset('js/jquery.datatables.min.js') }}"></script>
    <script src="{{ asset('js/chart.min.js') }}"></script>
    <script src="{{ asset('js/masonry.pkgd.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    @stack('scripts')
</body>
</html>