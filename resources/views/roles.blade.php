@extends('layouts.app')

@section('content')
    <roles_template :role_id="{{Auth::user()->role_id}}"></roles_template>
@endsection