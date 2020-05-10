@extends('admin.layout')

@section('content')
    <h1> DASHBOARD</h1>
    <p>Usuario autentificado {{ auth()->user()->name }} | {{ auth()->user()->email }}</p>
@stop
