@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3>Crear Roles</h3>
                </div>
                <div class="box-body">
                    @include('partials.error-messages')
                    <form method="POST" action="{{ route('admin.roles.store') }}">
                        {{ method_field('POST') }}
                        @include('admin.roles.form')
                        <button class="btn btn-primary btn-block">Crear Rol</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
