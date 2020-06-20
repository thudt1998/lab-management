<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ThanksChatAdmin</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
@auth("lecturer")
    @include("pages.lecturer.layouts.header")
    <main>
        <div id="app" style="margin-top: 10vh;">
            @yield("content")
        </div>
    </main>
    @include("layouts.footer")
@endauth
<script src="{{asset('js/app.js')}}"></script>

</body>
</html>
