@extends("pages.manager.layouts.index")
@section("content")
    <lecturer-component
        :list='@json($lecturers)'
        :subjects='@json($subjects)'
        :lecturer-create-success='@json(session()->has("lecturer_create_success") ? session()->get("lecturer_create_success") : null)'
        :lecturer-create-fail="@json(session()->has("lecturer_create_fail") ? session()->get("lecturer_create_fail") : null)"
    />
@endsection
