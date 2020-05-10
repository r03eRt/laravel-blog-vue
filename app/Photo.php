<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    // desavtivamos la proteccion contra la asigancion masiva
    protected $guarded = [];


    protected static function boot() {
        parent::boot();
        static::deleting(function($photo) {
            Storage::disk('public')->delete($photo->url);
        });
    }
}
