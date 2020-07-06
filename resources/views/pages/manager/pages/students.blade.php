@extends("pages.manager.layouts.index")
@section("content")
    <list-students-component
        :list='@json($students)'
    />
@endsection
