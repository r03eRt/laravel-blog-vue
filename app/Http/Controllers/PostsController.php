<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    //
    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
// Una forma
//    public function show($id) {
//
//        $post = Post::find($id);
//
//        return view('posts.show', [
//            'post' => $post
//        ]);
//    }

    /**
     * @param Post $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Post $post) {

        // Utilizamos este metodo del modelo para que el admin pueda ver post que no tienen fecha y que por tanto no son visibles en ningun sitio
        // si el post está publicado, tiene fecha de creacion o estamos autentificados podemos verlo, sino el post queda prohibido para otro
        if($post->isPublished() || auth()->check()) {
            return view('posts.show', [
                'post' => $post
            ]);
        }

        abort(404);



    }
}
