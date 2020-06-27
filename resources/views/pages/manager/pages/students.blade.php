@extends("pages.manager.layouts.index")
@section("content")
    <list-students-component
        :students='@json($students)'
    />
@endsection
