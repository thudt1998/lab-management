@extends('pages.student.layouts.index')
@section('content')
    <project-list-component
        :list='@json($projects)'
        :topics='@json($topics)'
    />
@endsection
