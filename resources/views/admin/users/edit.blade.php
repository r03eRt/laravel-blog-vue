@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3>Datos Personales</h3>
                </div>
                <div class="box-body">
{{--                    Otra forma de mostrar los errores seguidos --}}
                    @if($errors->any())
                    <ul class="list-group">
                        @foreach($errors->all() as $error)
                            <li class="list-group-item list-group-item-danger">
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                    @endif
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        {{ method_field('PUT') }} {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <div class="input-group date" id="name">
                                <input value="{{ old('name', $user->name)  }}" type="text" name="name" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <div class="input-group date" id="email">
                                <input value="{{ old('email', $user->email)  }}" name="email" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <div class="input-group date" id="password">
                                <input value="" type="password" name="password" class="form-control" placeholder="Contraseña"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Repite la Contraseña</label>
                            <div class="input-group date" id="password_confirmation">
                                <input value="" type="password" name="password_confirmation" class="form-control" placeholder="Repite la contraseña"/>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block">Actualizar usuario</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3>Roles</h3>
                </div>
                <div class="box-body">
                    <!--Directiva para que solo se muestre a administradores, si no eres admin no peude actualizar roles -->
                    @role('Admin')
                    <form method="POST" action="{{ route('admin.users.roles.update', $user) }}">
                        {{ csrf_field() }} {{ method_field('PUT') }}
                        @include('admin.roles.checkboxes')
                        <button class="btn btn-primary btn-block">Actualizar Roles</button>
                    </form>
                    @else
                        <ul class="list-group">
                            @forelse($user->roles as $role)
                                <li class="list-group-item"> {{ $role->name }}</li>
                            @empty
                                <li class="list-group-item"> No tiene roles</li>
                            @endforelse
                        </ul>
                    @endrole
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    <h3>Permisos</h3>
                </div>
                <div class="box-body">
                    @role('Admin')
                    <form method="POST" action="{{ route('admin.users.permissions.update', $user) }}">
                        {{ csrf_field() }} {{ method_field('PUT') }}
                        @include('admin.permissions.checkboxes', [ 'model'=> $user])
                        <button class="btn btn-primary btn-block">Actualizar Permisos</button>
                    </form>
                    @else
                        <ul class="list-group">
                            @forelse($user->permissions as $permission)
                                <li class="list-group-item"> {{ $permission->name }}</li>
                            @empty
                                <li class="list-group-item"> No tiene permisos</li>
                            @endforelse
                        </ul>
                    @endrole
                </div>
            </div>
        </div>
    </div>
@endsection
