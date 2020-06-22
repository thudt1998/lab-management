@extends('pages.lecturer.layouts.index')
@section('content')
    <topic-component :topics='@json(topics)'
                       :topic-create-success='@json(session()->has("topic_create_success") ? session()->get("topic_create_success") : null)'
                       :topic-create-fail="@json(session()->has("topic_create_fail") ? session()->get("topic_create_fail") : null)"
    />
@endsection
