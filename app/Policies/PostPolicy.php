<?php

namespace App\Policies;

use App\User;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Metodo que s eejecuta antes de cualquier accion
     */
    public function before($user) {

        if($user->hasRole('Admin')) {
           return true;
        }
        // No retornamos false porque pararíamos el flujo
    }

    /**
     * Determine whether the user can view the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function view(User $user, Post $post)
    {
        // retornamos true o false para poder entrar,
        // preguntamos si el suuario actual es el usuario del post entonces dejamos
        return $user->id === $post->user_id
            || $user->hasPermissionTo('View posts');//Damos el permiso, esto solo pasa con permisos activados
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        return $user->hasPermissionTo('Create posts');//Damos el permiso, esto solo pasa con permisos activados
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        //
        return $user->id == $post->user_id
            || $user->hasPermissionTo('Update posts');//Damos el permiso, esto solo pasa con permisos activados
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        //
        return $user->id == $post->user_id
            || $user->hasPermissionTo('Delete posts');//Damos el permiso, esto solo pasa con permisos activados
    }

    /**
     * Determine whether the user can restore the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function restore(User $user, Post $post)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function forceDelete(User $user, Post $post)
    {
        //
    }
}
