<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    @vite(['resources/scss/layouts/modern-dark-menu/dark/loader.scss', 'resources/layouts/modern-dark-menu/loader.js'])

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap/bootstrap.min.css') }}" rel="stylesheet" type="text/css">

    @vite(['resources/scss/dark/assets/main.scss'])

    <!-- global mandatory styles -->
    {{ $headers }}
    <!-- /global mandatory styles -->
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

    {{ $slot }}

    <!-- global mandatory scripts -->
    {{ $footers }}
    <!-- /global mandatory scripts -->
</body>
</html>
