@extends("pages.manager.layouts.index")
@section("content")
    <laboratory-component
        :laboratories='@json($laboratories)'
        :laboratory-create-success='@json(session()->has("laboratory_create_success") ? session()->get("laboratory_create_success") : null)'
        :laboratory-create-fail="@json(session()->has("laboratory_create_fail") ? session()->get("laboratory_create_fail") : null)"
    />
@endsection
