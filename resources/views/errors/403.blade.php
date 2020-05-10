@extends('layout')

@section('content')
    <section class="pages container">
        <div class="page page-about">
            <h1 class="text-capitalize">Página no Autorizada</h1>
            {{ $exception->getMessage() }}
            <p><a href="{{ url()->previous() }}">Regresar</a></p>
        </div>
    </section>
@stop
