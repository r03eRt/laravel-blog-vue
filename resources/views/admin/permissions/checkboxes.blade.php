@foreach($permissions as $id => $name)
    <div class="checkbox">
        <label for="permissions">
{{-- Cmabiamos $user por $model para que nos permita utilizar otro modelo
<input name="permissions[]" type="checkbox" value="{{ $name }}" {{ $user->permissions->contains($id) ? 'checked' : '' }} >
--}}
            <input name="permissions[]" type="checkbox" value="{{ $name }}"
                {{ collect(old('permissions'))->contains($name) ? 'checked' : '' }}
                {{ $model->permissions->contains($id) ||  collect(old('permissions'))->contains($name) ? 'checked' : '' }} >
            {{ $name }}
        </label>
    </div>
@endforeach
