<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\User;
use Illuminate\Http\Request;

// aqui tenemos todas las paginas estáticas
class PagesController extends Controller
{
    //
    public function inicio()
    {
        // esta query es por si venidos de archives para filtar los datos que vienen en la url
        $query = Post::published();


        if(request('month')) {
            $query->whereMonth('published_at', request('month'));
        }

        if(request('year')) {
            $query->whereYear('published_at', request('year'));
        }

        //Cogemos los ultimos post pero con otra clave para ordenar y siempre que la fehca nos ea nula
        // Esto lo podemos unicicar en un metodo de forma que nos de los post publicados en lugar de con todos
        //estos filtros queryScopes en el modelo
        //$posts = Post::whereNotNull('published_at')
        //    ->where('published_at', '<=', Carbon::now())
        //    ->latest('published_at')
        //    ->get();
        // Esto es quivalente a lo de arriba con un queryScope
        //$posts = Post::published()->get();
        // Esto es para usar paginacion, para usar otra $posts = Post::published()->simplePaginate(1); ant y sig
        //$posts = Post::published()->paginate(5);

        $posts = $query->paginate();

        // Forma de pasar Variables 1
        //    return view('welcome')->with(
        //        'posts', $posts
        //    );

        //Forma de pasar Variables 2
        //return view('welcome', compact('posts'));



        //Forma de pasar Variables 2
        //['posts' => $posts]
        return view('pages.inicio', [
            'posts' => $posts
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function nosotros() {
        return view('pages.nosotros');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function archivo() {

        //traducir meses
        \DB::statement("SET lc_time_names = 'es_ES'");

        // Lo extraemos a un scope del modelo para refactorizar
//        $archive = Post::selectRaw('year(published_at) year')
//            ->selectRaw('month(published_at) month')
//            ->selectRaw('monthname(published_at) monthname')
//            ->selectRaw('count(*) posts')
//            ->groupBy('year', 'month', 'monthname')
//            //->orderBy('published_at')
//            ->get();
        //$archive =  Post::latest()->take(5)->get();


        $archive = Post::byYearAndMonth()->get();

        return view('pages.archivo', [
            'authors' => User::latest()->take(4)->get(),
            'categories' => Category::latest()->take(7)->get(),
            'posts' => Post::latest('published_at')->take(5)->get(),
            'archive' => $archive
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contacto() {
        return view('pages.contacto');
    }


}
