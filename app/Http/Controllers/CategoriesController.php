<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Category $category) {

        // Con esto sacamos un array con las relaciones de posts con categorias, el posts se define en el  modelo
        // de category para declarar las relaciones
        //$category->load('posts');



        //como necesitamos una coleccion de psot independientas  y meterlos en $posts para usar lo mismo que en welcome
        return view('pages.inicio', [
            'title' => "Publicacion con la categoria {$category->name}",
            'category' => $category,
            'posts' => $category->posts()->paginate()
        ]);
    }
}
