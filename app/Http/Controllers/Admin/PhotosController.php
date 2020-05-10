<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Photo;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
{
    //

    public function store(Post $post) {
        $this->validate(request(), [
            'photo' => 'required|image|max:2048'
        ]);
        $photo = request()->file('photo');
        $photoUrl = $photo->store('posts', 'public');// ponemos la subcaprta y luego el disco donde lo guarda -> public, con lo cual publi/posts
        //Modelo de Eloquent para crear el objeto en base datos
        // Con esto Storage::url($photoUrl); generamos la url de la foto con este formato {localhost}/storage/url foto de la foto
        Photo::create([
            'url' => Storage::url($photoUrl),
            'post_id' => $post->id
        ]);
//
//        // Storage url se usa para general la url completa valida
//        return Storage::url($photoUrl);
    }

    public function destroy(Photo $photo) {

        // Eliminar de base de datos
        $photo->delete();

//1.-        // Coomo no  está bien el fichero no se encuentra en storage y es un enalce simbolico , necesitamos cambiar para que apunte a public
        $photoPath = str_replace('storage', 'public', $photo->url);
        // Eliminar fichero de foto
        Storage::delete($photoPath);

//2.-
//        Storage::disk('public')->delete($photo->url);

//3.- esta forma es yendo al modelo de photo y modificando las acciones durante el boot, por eso quitamos las otras dos
//formas porque cuando se hace $photo->delete() se ejecuta el metodo del modelo


        return back()->with('flash', 'Foto eliminada');
    }
}
