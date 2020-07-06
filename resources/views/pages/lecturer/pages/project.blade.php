@extends('pages.lecturer.layouts.index')
@section('content')
    <project-component :list='@json($projects)'
                       :user='@json($user)'
                     :topic-create-success='@json(session()->has("topic_create_success") ? session()->get("topic_create_success") : null)'
                     :topic-create-fail="@json(session()->has("topic_create_fail") ? session()->get("topic_create_fail") : null)"
    />
@endsection
