<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>LAB MANAGEMENT</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

@auth
    @include('layouts.header')
@else
    <nav class="navbar navbar-expand-lg navbar-dark white scrolling-navbar">
        <div class="navbar-brand text-black-50">
            <a href="{{route(WELCOME)}}">
                <img src="{{asset('image/logo.png')}}" width="100">
            </a>
        </div>
    </nav>
@endauth
<div id="app">
    @yield('content')
</div>
@include('layouts.footer')

<script src="{{asset('js/app.js')}}"></script>

</body>
</html>
