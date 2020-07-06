@extends("layouts.app")
@section("content")
    <login-component :url='@json($url)'/>
@endsection
