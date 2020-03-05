@extends('layouts.app')

@section('content')
    <expense_template :role_id="{{Auth::user()->role_id}}"></expense_template>
@endsection