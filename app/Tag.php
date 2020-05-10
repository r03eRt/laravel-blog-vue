<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'url';
    }

    /**
     * Creamos  la declaración de la relacion
     */
    public function posts() {
        return $this->belongsToMany(Post::class);
    }

    /**
     * Esto es un mutador para modificar attributos del modelo antes de guardar de basde datos, como un filtro la sintaxis getNameAttribute
     */
    public function setNameAttribute($name) {
        $this->attributes['name'] =  $name;
        $this->attributes['url'] =  str_slug($name);

    }
}
