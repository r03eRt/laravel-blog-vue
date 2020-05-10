@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3>Datos Personales</h3>
                </div>
                <div class="box-body">
                    @include('partials.error-messages')
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        {{ method_field('POST') }} {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <div class="input-group date" id="name">
                                <input value="{{ old('name')  }}" type="text" name="name" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <div class="input-group date" id="email">
                                <input value="{{ old('email')  }}" name="email" class="form-control"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Roles</label>
                                @include('admin.roles.checkboxes')
                            </div>
                            <div class="form-group col-md-6">
                                <label>Permissions</label>
                                @include('admin.permissions.checkboxes', [ 'model'=> $user])
                            </div>
                        </div>
                        <span class="help-block">La contraseña será generada y enviado por correo electrico</span>
                        <button class="btn btn-primary btn-block">Crear usuario</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
