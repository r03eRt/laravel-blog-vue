<?php

namespace App\Policies;

use App\User;
// como queremos utilizar el modelo rol de spathie
//use App\Role;
use Spatie\Permission\Models\Role;
// Una vez creado tenemos que registrar la politica y asignarsela a un modelo-> Providers\AuthServideProvider

use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any roles.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the role.
     *
     * @param  \App\User  $user
     * @param  \App\Role  $role
     * @return mixed
     */
    public function view(User $user, Role $role)
    {
        return $user->hasRole('Admin') || $user->hasPermissionTo('View roles');
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole('Admin') || $user->hasPermissionTo('Create roles');
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param  \App\User  $user
     * @param  \App\Role  $role
     * @return mixed
     */
    public function update(User $user, Role $role)
    {
        return $user->hasRole('Admin') || $user->hasPermissionTo('Update roles');
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param  \App\User  $user
     * @param  \App\Role  $role
     * @return mixed
     */
    public function delete(User $user, Role $role)
    {
        if($role->id === 1) {
            //throw new \Illuminate\Auth\Access\AuthorizationException('No se puede eliminar este rol: Admin');
            // Como estamos con policies no nos hace falta excepciones con retornar falso ya bloqueamos el acceso,
            //si queremos retornar un mensaje usamos el emtodo deny en lugar del return false, si es positivo el metodo seria allow
            $this->deny('No se puede eliminar este rol: Admin');
        }

        // Doble comprobacion
        return $user->hasRole('Admin') || $user->hasPermissionTo('Delete roles');
    }

    /**
     * Determine whether the user can restore the role.
     *
     * @param  \App\User  $user
     * @param  \App\Role  $role
     * @return mixed
     */
    public function restore(User $user, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the role.
     *
     * @param  \App\User  $user
     * @param  \App\Role  $role
     * @return mixed
     */
    public function forceDelete(User $user, Role $role)
    {
        //
    }
}
