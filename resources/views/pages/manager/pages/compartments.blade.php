@extends("pages.manager.layouts.index")
@section("content")
    <compartment-component
        :compartments='@json($compartments)'
        :laboratories='@json($laboratories)'
        :compartment-create-success='@json(session()->has("compartment_create_success") ? session()->get("compartment_create_success") : null)'
        :compartment-create-fail="@json(session()->has("compartment_create_fail") ? session()->get("compartment_create_fail") : null)"
    />
@endsection
