<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {

        // Usamos policies para dar permisos al acceder a las vistas
        $this->authorize('view', new Permission);

        return view('admin.permissions.index', [
            'permissions' => Permission::all()
        ]);
    }

    /**
     * @param Permission $permission
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Permission $permission) {

        // Usamos policies para dar permisos al acceder a las vistas
        $this->authorize('update', new Permission);


        return view('admin.permissions.edit', [
            'permission' => $permission
        ]);
    }

    /**
     * @param Permission $permission
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Request $request, Permission $permission) {

        // Usamos policies para dar permisos al acceder a las vistas
        $this->authorize('update', new Permission);


        $data = $request->validate([
            'display_name' => 'required'
        ]);

        $permission->update($data);

        return redirect()->route('admin.permissions.edit', $permission)->withFlash('El permiso ha sido actualizado');
    }
}
