<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Lab</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .btn-login{
            text-decoration: none !important;
            color: #fff !important;
            width: 300px;
        }
    </style>
</head>
<body>
    <div id="app">
        <div class="row" style="margin-top: 10vh">
            <div class="col-4"></div>
            <div class="col-4">
                <div class="card">
                    <div class="view">
                        <img src="{{asset('image/school.jpg')}}" class="card-img-top"
                             alt="photo">
                        <a href="#">
                            <div class="mask rgba-white-slight"></div>
                        </a>
                    </div>
                    <div
                        class="card-body"
                        style="text-align: center"
                    >
                        <h4 class="card-title">Đăng nhập</h4>
                        <div>
                            <a
                                href="{{route(LOGIN_MANAGER)}}"
                                class="btn btn-primary btn-login"
                            >
                                Dành cho cán bộ quản lý
                            </a>
                        </div>
                        <hr/>
                        <div>
                            <a
                                href="#"
                                class="btn btn-primary btn-login"
                            >
                                Dành cho giảng viên
                            </a>
                        </div>
                        <hr/>
                        <div>
                            <a
                                href="#"
                                class="btn btn-primary btn-login"
                            >
                                Dành cho sinh viên
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('js/app.js')}}"></script>
</body>
</html>
