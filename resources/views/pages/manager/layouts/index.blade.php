<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Quản lý phòng thí nghiệm</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        .flexible-content {
            transition: padding-left 0.3s;
            padding-left: 270px;
        }

        main {
            background-color: #ededee;
        }

        .main-content-admin {
            min-height: calc(100vh);
            height: 100vh;
        }

        .avatar{
            height: 120px !important;
            border-radius: 56px;
        }
    </style>
</head>
<body>
<div class="flexible-content">
    @auth("manager")
        @include("pages.manager.layouts.header")
        @include("pages.manager.layouts.side_bar")
        <main>
            <div
                class="mt-5 mb-5 p-5 main-content-admin"
                style="background-image: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(126,126,228,1) 0%, rgba(0,212,255,1) 100%);"
            >
                <div id="app">
                    <notification-component></notification-component>
                    @yield("content")
                </div>
            </div>
        </main>
    @endauth
</div>
<script src="{{asset('js/app.js')}}"></script>

</body>
</html>
