<?php

namespace App\Http\Controllers\Admin;

use App\Events\UserWasCreated;
use App\Http\Requests\UpdateUserRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Cogemos todos los posts
        //$users = User::all();
        // Cogemos todos los post del usuario cutentificado
        $users = User::allowed()->get();

        return view('admin.users.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User;

        //Requerimos actualziacion para crear este usuario-> con esto pasa por el policy
        $this->authorize('create', new User);

        $roles = Role::with('permissions')->get();
        $permissions = Permission::pluck('name', 'id');

        return view('admin.users.create', [
            'roles' => $roles,
            'permissions' => $permissions,
            'user' => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Requerimos autorizacion para crear este usuario-> con esto pasa por el policy
        $this->authorize('create', new User);


        // Validar formulario
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users'
        ]);

        // Generar una contraseña
        $data['password'] = str_random(8);

        // Creamos usuario
        $user = User::create($data);// password en el mutation de user se encripta solo por eso no ahce falta

        // asignamos roles
        if($request->filled('roles')) {
            $user->assignRole($request->roles);
        }

        //asignamos permisos
        if($request->filled('permissions')) {
            $user->givePermissionTo($request->permissions);
        }

        //Enviamos correo
        //Evento => Usuario Creado
        // Listener => EnviarCorreoConCredenciales
        //php artisan event:generate UserWasCreated, SendLoginCredentials
        UserWasCreated::dispatch($user, $data['password']);

        //retornamos respuesta

        return view('admin.users.index')->withFlash('El usuario ha sido creado');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //Requerimos actualziacion para ver este usuario-> con esto pasa por el policy
        $this->authorize('view', $user);

        return view('admin.users.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //Requerimos actualziacion para editar este usuario-> con esto pasa por el policy
        $this->authorize('update', $user);

        //$roles = Role::all();
        //$roles = Role::pluck('name', 'id'); Para sacar los roles con mas campos, necesitamos por cada rol
        // sacar los permisos que tiene, roles con sus permisos
        $roles = Role::with('permissions')->get();
        $permissions = Permission::pluck('name', 'id');

        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {

//         Se puede simplificar utilizando un request para encapsular las valoraciones php artisan make:request UpdateUserRequest
//          Cmabiamos el Request $request de la function por UpdateUserRequest
//        $rules = [
//            'name' => 'required',
//            // email requerido y hay que ver que no estñe en la base de datos excepto si es el propio
//            'email' => ['required', Rule::unique('users')->ignore($user->id)]
//            //Otra forma 'email' => ['required', 'unique:users']
//        ];
//        if($request->filled('password')) {
//            $rules['password'] = ['confirmed', 'min:6'];
//        }
//        // Generamos las validaciones pasandole al validate el request
//        $user->update($request->validate($rules));

        //Con este metodo susituyendo $rules por validated utilizamos el Objeto request
        $user->update($request->validated());

        return   redirect()->route('admin.users.edit', $user)->withFlash('Usuario actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // Tenemos permiso para borrar usuarios
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->route('admin.users.index')->withFlash('Usuario eliminado');

    }
}
