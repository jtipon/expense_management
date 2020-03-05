@extends('layouts.app')

@section('content')
    <dashboard_template :role_id="{{Auth::user()->role_id}}"></dashboard_template>
@endsection