@extends("pages.manager.layouts.index")
@section("content")
    <laboratory-component
        :list='@json($laboratories)'
        :laboratory-create-success='@json(session()->has("laboratory_create_success") ? session()->get("laboratory_create_success") : null)'
        :laboratory-create-fail="@json(session()->has("laboratory_create_fail") ? session()->get("laboratory_create_fail") : null)"
        :laboratory-update-success='@json(session()->has("laboratory_update_success") ? session()->get("laboratory_update_success") : null)'
        :laboratory-update-fail="@json(session()->has("laboratory_update_fail") ? session()->get("laboratory_update_fail") : null)"
    />
@endsection
