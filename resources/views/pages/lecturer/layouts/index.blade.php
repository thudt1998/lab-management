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
            font-size: 1.2rem;
            font-style: italic;
        }

        .route {
            text-decoration: underline;
        }
    </style>
</head>
<body>
@auth("lecturer")
    @include("pages.lecturer.layouts.header")
    <main class="pb-5">
        <div id="app" style="margin-top: 10vh;">
            <div class="header-main">
                <li><a href="{{route(LECTURER)}}" class="route">Trang chủ</a> >>
                    @if(\Request::is('lecturers/students*'))
                        <a href="{{route('students.index')}}" class="route">Sinh viên
                    @elseif(\Request::is('lecturers/topics*'))
                        <a href="{{route('topics.index')}}" class="route">Đề tài
                    @elseif(\Request::is('lecturers/projects*'))
                        <a href="{{route('projects.index')}}" class="route">Project
                    @endif
                </li>
            </div>
            <div class="modal fade" id="modalLogout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                            <a class="btn btn-danger" href="{{route(LOGOUT_LECTURER)}}" style="text-decoration: none">Yes</a>
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
