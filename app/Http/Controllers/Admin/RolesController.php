<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SaveRolesRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Para usar permisos gestionados por policies
        $this->authorize('view', new Role);

        return view('admin.roles.index', [
            'roles' => Role::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // Para usar permisos gestionados por policies
        $this->authorize('create', new Role);

        return view('admin.roles.create', [
            //'permission' => Permission::all()
            'permissions' => Permission::pluck('name', 'id'),
            'role' => new Role
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveRolesRequest $request)
    {

        // Para usar permisos gestionados por policies
        $this->authorize('create', new Role);

//        // Cogemos los datos validados, esta forma es en lugar de comprobarlo en el controlador hacerlo a traves de una Request SaveRoleRequest
//        $data = $request->validate([
//            'name' =>  'required|unique:roles',//poquemos uniques para evitar el error de tener dos roles iguales
//            'display_name' =>  'required'
//            // quitamos el guard_name porque solo usamos web, no api que tambien está disponible
//            //'guard_name' =>  'required'
//        ],
//        [
//            'name.required' => 'El campo identificador es obligatorio',
//            'name.unique' => 'Este identificador ya ha sido registrado',
//            'display_name.required' => 'El campo nombre es obligatorio'
//        ]);
//        // Creamos un rol con los datos, el modelos Rol tiene proteccion contra inserccion masiva el id por lo que ya está protegido
//       $role = Role::create($data);

        // Creamos un rol con los datos, el modelos Rol tiene proteccion contra inserccion masiva el id por lo que ya está protegido
        $role = Role::create($request->validated());

       // asignamos los permisios al rol siempre que haya seleccionado el usuario
        if($request->has('permissions')) {
            $role->givePermissionTo($request->permissions);
        }

        return redirect()->route('admin.roles.index')->withFlash('Rol creado satisfactoriamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {

        // Para usar permisos gestionados por policies
        $this->authorize('update', $role);

        return view('admin.roles.edit', [
            'role' => $role,
            'permissions' => Permission::pluck('name', 'id')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveRolesRequest $request, Role $role)
    {
        // Cogemos los datos validados, esto nos lo hemos llevado a un request SaveRolesRequest, es una forma de validar en el metodo
//        $data = $request->validate([
//            //'name' =>  'required|unique:roles,name,'. $role->id,//poquemos uniques para evitar el error de tener dos roles iguales
//            //'display_name' =>  'required'. $role->id,//poquemos uniques para evitar el error de tener dos roles iguales
//            'display_name' =>  'required'//poquemos uniques para evitar el error de tener dos roles iguales
//            // quitamos el guard_name porque solo usamos web, no api que tambien está disponible
//            //'guard_name' =>  'required'
//        ],
//        // El segundo array son los mensajes de validación
//        [
//            'display_name.required' => 'El campo nombre es obligatorio'
//        ]);
//
//        $role->update($data);


        // Para usar permisos gestionados por policies
        $this->authorize('update', $role);

        $role->update($request->validated());

        //quitamos todos los permisos antes de asignar los nuevos
        $role->permissions()->detach();

        // asignamos los permisios al rol siempre que haya seleccionado el usuario
        if($request->has('permissions')) {
            $role->givePermissionTo($request->permissions);
        }

        return redirect()->route('admin.roles.edit', $role)->withFlash('Rol actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
//          Como ahora usamos policies nos llevamos esta logica al metodo destroy de RolePolicy
//        if($role->id === 1) {
//            throw new \Illuminate\Auth\Access\AuthorizationException('No se puede eliminar este rol: Admin');
//        }

        // Usamos esto para aplicar los permisos en lugar del codigo de arriba, porque estmoas usando ahroa policies
        $this->authorize('delete', $role);

        $role->delete();

        return redirect()->route('admin.roles.index')->withFlash('El rol fue eliminado');
    }
}
