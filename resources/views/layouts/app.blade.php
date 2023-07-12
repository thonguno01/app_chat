<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <link href="{{ asset('asset/css/lib/bootrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/sidebar-right.css') }}">
    @stack('css')
    <?php
    // dd($css);
    if (isset($css) && count($css)) {
        foreach ($css as $key => $value) {
            echo '<link rel="stylesheet" href="' . asset($value) . '">';
        }
    }
    ?>


    <script src="{{ asset('asset/js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('asset/js/lib/socket.io.min.js') }}"></script>

    @vite(['resources/js/app.js'])

    {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.0/echo.common.min.js"></script> --}}
    <title>@yield('title')</title>
</head>

<body>
    <input type="hidden" id="authId" value="{{ session()->get('id') }}">
    <div class="header">
        @include('includes.header')

    </div>
    <div class="container-fluid d-flex ">
        <div class="wrap-content">
            @yield('content')
            @yield('sidebarRight')

        </div>

    </div>
    @yield('popup')
    {{-- @include('includes.footer') --}}

    <script src="{{ asset('asset/js/function.js') }}"></script>
    <?php
    if (isset($js) && count($js)) {
        foreach ($js as $key => $value) {
            echo ' <script src="' . asset($value) . '"></script>';
        }
    }
    ?>
    @stack('js')
</body>

</html>
