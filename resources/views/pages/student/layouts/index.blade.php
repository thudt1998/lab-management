<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>LAB Management</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .header-main {
            padding: 15px;
        }

        .route {
            text-decoration: underline;
            font-size: 1.4rem;
            color: #661a00 !important;
            font-weight: bold;
        }
    </style>
</head>
<body>
@auth("student")
    @include("pages.student.layouts.header")
    <main class="pb-5">
        <div id="app" style="margin-top: 10vh;margin-bottom: 20px">
            <div class="header-main">
                <a href="{{route(STUDENT)}}" class="route">Trang chủ</a> <i class="fas fa-angle-double-right"></i>
                @if(\Request::is('students/lecturers*'))
                    <a href="{{route(LIST_LECTURES_STUDENT)}}" class="route">Giảng viên
                        @elseif(\Request::is('students/projects*'))
                            <a href="{{route(LIST_PROJECTS_STUDENT)}}" class="route">Project
                @endif
            </div>
            <div class="modal fade" id="modalLogoutStudent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Đăng xuất</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="font-size: 20px">
                            Bạn có thực sự muốn đăng xuất?
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-danger" href="{{route(LOGOUT_STUDENT)}}" style="text-decoration: none">Yes</a>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div>
            @yield("content")
        </div>
    </main>
    @include("layouts.footer")
@endauth
<script src="{{asset('js/app.js')}}"></script>

</body>
</html>
