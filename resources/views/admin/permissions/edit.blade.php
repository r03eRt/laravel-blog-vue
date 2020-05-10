@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3>Actualizar Permiso</h3>
                </div>
                <div class="box-body">
                    @include('partials.error-messages')
                    <form method="POST" action="{{ route('admin.permissions.update', $permission) }}">
                        {{ method_field('PUT') }} {{ csrf_field() }}
                        <div class="form-group">
                            <label for="display_name">Identificador</label>
                            <div class="input-group date" id="name">
                                <input disabled value="{{ $permission->name  }}" type="text" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="display_name">Nombre</label>
                            <div class="input-group date" id="name">
                                <input value="{{ old('display_name', $permission->display_name)  }}" type="text" name="display_name" class="form-control"/>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block">Actualizar Permiso</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
