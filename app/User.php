<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    // Has roles para autentificar este modelo y asiganerle roles
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Mutacion para encriptar la contraseña, Hay que ir al RegisterController al create  porque en al paquete de por defecto
     * ya se está encriptando antes de guardar la contraseña
     * @param $password
     */
    public function setPasswordAttribute($password) {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relacion para indicar que un usuario puede tener varios post
    public function posts() {
        return $this->hasMany(Post::class, 'user_id');
    }

    /**
     * Hacemos esta funcion extra para encapsular esta logica, siempre se ejecutará cuando el usuario esté logeado
     * @param $query
     * @return Post[]|\Illuminate\Database\Eloquent\Collection
     */
    public function scopeAllowed($query) {
        // Con los roles decimos  si el usuario logeado es admin mostramos todos los post sino solo los post del usuario
        if(auth()->user()->can('view', $this)) {
            //en vez de obtener todos los posts solamente obtenemos los post de cierto usuario porque cada usuario en su
            //dashboard tiene sis posts
            return $query;
        } else {
            //cogemos solo los pots del usuario logeado, podemos ahcerlo por relacion $posts = auth()->user()->posts;
            return $query->where('id', auth()->id());
            //return auth()->user()->posts;
        }
    }
}
