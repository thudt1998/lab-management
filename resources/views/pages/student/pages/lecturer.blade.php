@extends('pages.student.layouts.index')
@section('content')
    <lecturer-list-component
        :list='@json($lecturers)'
        :subjects='@json($subjects)'
    />
@endsection
