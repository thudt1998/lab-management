@extends("pages.manager.layouts.index")
@section("content")
    <list-projects-component
        :list='@json($projects)'
    />
@endsection
