<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    //

    public function show(Tag $tag) {

        // cogemos los posts que contiene este tag y los paginamos
        $posts = $tag->posts()->paginate();

        return view('pages.inicio', [
            'title' => "Publicacion con el tag {$tag->name}",
            'tag' => $tag,
            'posts' => $posts
        ]);
    }
}
