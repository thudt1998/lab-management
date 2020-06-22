@extends('pages.lecturer.layouts.index')
@section('content')
    <student-component :students='@json($students)'
                       :student-create-success='@json(session()->has("student_create_success") ? session()->get("student_create_success") : null)'
                       :student-create-fail="@json(session()->has("student_create_fail") ? session()->get("student_create_fail") : null)"
    />
@endsection
