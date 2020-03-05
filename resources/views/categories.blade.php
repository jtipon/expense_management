@extends('layouts.app')

@section('content')
    <category_template :role_id="{{Auth::user()->role_id}}"></category_template>
@endsection