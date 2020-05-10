<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Vaciamos la tabla
        Permission::truncate();
        Role::truncate();
        User::truncate();

        // Creamos los Roles
        $adminRole = Role::create(['name' => 'Admin', 'display_name' => 'Administrador']);
        $writerRole = Role::create(['name' => 'Writer', 'display_name' => 'Escritor']);


        // Creamos permisos -> Estos se enlazan con el Post Policy
        $viewPostsPermission = Permission::create(['name' => 'View posts', 'display_name' => 'Ver publicaciones']);
        $createPostsPermission = Permission::create(['name' => 'Create posts', 'display_name' => 'Crear publicaciones']);
        $updatePostsPermission = Permission::create(['name' => 'Update posts', 'display_name' => 'Actualizar publicaciones']);
        $deletePostsPermission = Permission::create(['name' => 'Delete posts', 'display_name' => 'Borrar Pulicaciones']);


        // Creamos permisos -> Estos se enlazan con el Post Policy
        $viewUsersPermission = Permission::create(['name' => 'View users', 'display_name' => 'Ver usuarios']);
        $createUsersPermission = Permission::create(['name' => 'Create users', 'display_name' => 'Crear usuarios']);
        $updateUsersPermission = Permission::create(['name' => 'Update users', 'display_name' => 'Actualizar usuarios']);
        $deleteUsersPermission = Permission::create(['name' => 'Delete users', 'display_name' => 'Borrar usuarios']);

        // Creamos permisos para actualizar roles
        // Creamos permisos -> Estos se enlazan con el Post Policy
        $viewRolesPermission = Permission::create(['name' => 'View roles', 'display_name' => 'Ver roles']);
        $createRolesPermission = Permission::create(['name' => 'Create roles', 'display_name' => 'Crear roles']);
        $updateRolesPermission = Permission::create(['name' => 'Update roles', 'display_name' => 'Actualizar roles']);
        $deleteRolesPermission = Permission::create(['name' => 'Delete roles', 'display_name' => 'Borrar roles']);

        $viewPermissionsPermission = Permission::create(['name' => 'View permissions', 'display_name' => 'Ver permisos']);
        $updatePermissionsPermission = Permission::create(['name' => 'Update permissions', 'display_name' => 'Actualizar permisos']);

//        Usuario estandar
//        $user = new User;
//        $user->name = 'Roberto';
//        $user->email = 'morgadoluengo@gmail.com';
//        $user->password = bcrypt('02289149Mm');
//        $user->save();


        $admin = new User;
        $admin->name = 'Roberto';
        $admin->email = 'morgadoluengo@gmail.com';
        //$admin->password = bcrypt('02289149Mm');
        $admin->password = '02289149Mm';
        $admin->save();

        //Aplicamos a cada usuario los permisos asignandole el rol
        $admin->assignRole($adminRole);

        $writer = new User;
        $writer->name = 'Roberto2';
        $writer->email = 'morgadoluengo2@gmail.com';
        //$writer->password = bcrypt('02289149Mm2');
        $writer->password = '02289149Mm2';
        $writer->save();

        //Aplicamos a cada usuario los permisos asignandole el rol
        $writer->assignRole($writerRole);
    }
}
