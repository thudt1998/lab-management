@extends('pages.lecturer.layouts.index')
@section('content')
    <create-project-component
        :laboratories='@json($laboratories)'
    />
@endsection
