@extends("pages.manager.layouts.index")
@section("content")
    <list-projects-component
        :projects='@json($projects)'
    />
@endsection
