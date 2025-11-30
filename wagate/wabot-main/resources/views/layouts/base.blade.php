<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} - {{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/scss/layouts/modern-dark-menu/dark/loader.scss', 'resources/layouts/modern-dark-menu/loader.js'])

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap/bootstrap.min.css') }}" rel="stylesheet" type="text/css">

    @vite(['resources/scss/dark/assets/main.scss'])

    @if ($scrollspy == 1) @vite(['resources/scss/dark/assets/scrollspyNav.scss']) @endif

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/waves/waves.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/highlight/styles/monokai-sublime.css') }}">
    @vite(['resources/scss/dark/plugins/perfect-scrollbar/perfect-scrollbar.scss', 'resources/scss/layouts/modern-dark-menu/dark/structure.scss'])

    <!-- global mandatory styles -->
    {{ $headers }}
    <!-- /global mandatory styles -->

    <style>
        body.dark .layout-px-spacing, .layout-px-spacing { min-height: calc(100vh - 155px) !important; }
    </style>
</head>
<body class="layout-boxed">
    <!-- loader -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!-- /loader -->

    <!-- navbar -->
    @include('layouts.topnav')
    <!-- /navbar -->

    <!-- main container -->
    <div class="main-container " id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  sidebar  -->
        @include('layouts.menu')
        <!-- /sidebar -->

        <!-- content area -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="middle-content container-xxl p-0">
                    {{ $slot }}
                </div>
            </div>
        </div>
        <!-- /content area -->
    </div>
    <!-- /main container -->

    <!-- global mandatory scripts -->
    <script src="{{asset('plugins/global/vendor.min.js')}}"></script>
    <script src="{{asset('plugins/bootstrap/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('plugins/mousetrap/mousetrap.min.js')}}"></script>
    <script src="{{asset('plugins/waves/waves.min.js')}}"></script>
    <script src="{{asset('plugins/highlight/highlight.pack.js')}}"></script>

    @if ($scrollspy == 1) @vite(['resources/assets/js/scrollspyNav.js']) @endif
    @vite(['resources/layouts/modern-dark-menu/app.js'])

    {{ $footers }}
    <!-- /global mandatory scripts -->
</body>
</html>
