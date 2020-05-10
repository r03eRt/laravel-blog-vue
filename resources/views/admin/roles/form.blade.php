{{ csrf_field() }}
<div class="form-group">
    <label for="name">Identificador</label>
    <div class="input-group date" id="name">
        <!-- Si estamos en el formulario de editar en lugar de de crear no dejamos cambiar el nombre, por ejemplo: cambiar Admin-->
        @if($role->exists)
            <input name="name" value="{{ $role->name }}" type="text" class="form-control" disabled/>
        @else
            <input name="name" value="{{ old('name', $role->name) }}" type="text" class="form-control"/>
        @endif

    </div>
</div>
<div class="form-group">
    <label for="display_name">Nombre</label>
    <div class="input-group date" id="name">
        <input value="{{ old('display_name', $role->display_name)  }}" type="text" name="display_name" class="form-control"/>
    </div>
</div>
{{--<div class="form-group">
    <label for="email">Guard</label>
    <div class="input-group date" id="guard">
        <select class="form-control" name="guard_name" id="">
            <!-- cogemos los datos de config/auth que tenemos un array con los dos tipos de guard auth y api-->
            @foreach(config('auth.guards') as $guardName => $guard)
                <option {{ old('guard_name', $role->guard_name) === $guardName ? 'selected' : '' }} value="{{ $guardName }}">{{ $guardName }}</option>
            @endforeach
        </select>
    </div>
</div>--}}
<div class="row">
    <div class="form-group col-md-6">
        <label>Permissions</label>
        @include('admin.permissions.checkboxes', ['model' => $role])
    </div>
</div>
