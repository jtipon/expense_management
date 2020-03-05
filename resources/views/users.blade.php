@extends('layouts.app')

@section('content')
    <users_template :role_id="{{Auth::user()->role_id}}"></users_template>
@endsection