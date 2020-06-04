<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ThanksChat</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

@auth
    @include("layouts.header")
@endauth
<div id="app">
    @yield("content")
</div>

<script src="{{asset('js/app.js')}}"></script>

</body>
</html>
