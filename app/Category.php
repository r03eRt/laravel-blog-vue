<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    // Para creacion de nueva categoria en el select
    protected $guarded = [];
    /**
     * Con este metodo lo que hacemos es cambiar el id numero de las urls por el nombre "friendly name"
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'url';
    }

    /**
     * Relacion para sacar Post
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts() {
        return $this->hasMany(Post::class);
    }

//    /**
//     * Esto es un accesor para modificar attributos del modelo, como un filtro la sintaxis getNameAttribute
//     */
//    public function getNameAttribute($name) {
//        return str_slug($name);
//    }
//
    /**
     * Esto es un mutador para modificar attributos del modelo antes de guardar de basde datos, como un filtro la sintaxis getNameAttribute
     */
    public function setNameAttribute($name) {
        $this->attributes['name'] =  $name;
        $this->attributes['url'] =  str_slug($name);

    }
}
