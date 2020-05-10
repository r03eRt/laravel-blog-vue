<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Requests\StorePostRequest;
use App\Post;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {

        // Con los roles decimos  si el usuario logeado es admin mostramos todos los post sino solo los post del usuario
        if(auth()->user()->hasRole('Admin')) {
            //en vez de obtener todos los posts solamente obtenemos los post de cierto usuario porque cada usuario en su
            //dashboard tiene sis posts
            $posts = Post::all();
        } else {
            //cogemos solo los pots del usuario logeado, podemos ahcerlo por relacion $posts = auth()->user()->posts;
            $posts = Post::where('user_id', auth()->id())->get();
            //$posts = auth()->user()->posts;
        }

        //Se puede utilizar
        //$posts = Post::allowed()->get();


        return view('admin.posts.index', [
            'posts' => $posts
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {

        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.create', [
            'categories' => $categories,
            'tags' => $tags
        ]);
    }


    /**
     * @param Post $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    // Poniendo como parametro Post y eso que nos viene un string encuentra el objeto post por nosotros(Model Binding)
    public function edit(Post $post) {

        //php artisan make:policy PostPolicy -m Post
        // para permitir al usuario editar un post que no es suyo usamos Policy,  y le pasamos el metodo
        // tenemos que poner la relacion en Providers $policies 'App\Post' => 'App\Policies\PostPolicy'
        // autorizacion para ver esta publicacion
        $this->authorize('view', $post);

        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.edit', [
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store2(Request $request) {

        // como el metodo create no tiene la instancia de Post porque no hace falta el post para crear un nuevo post
        // le pasamos la instancia y siempre retornamos true
        $this->authorize('create', new Post);

        $this->validate($request, [
            'title' => 'required|min:3'
        ]);

        $post = Post::create([
            'title' => $request->get('title'),
            'url' => str_slug($request->get('title')),
            'user_id' => auth()->id()
        ]);

        return redirect()->route('admin.posts.edit', [
            'post' => $post
        ]);
    }

        /**
         * Utilizamos el Store Request para las validacion no hacerlas en el controlaodor
         * @param StorePostRequest $request
         * @param Post $post
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Illuminate\Validation\ValidationException
         */
    public function update(StorePostRequest $request, Post $post) {

        // Validaciones
//        $this->validate($request, [
//            'title' =>  'required',
//            'excerpt' =>  'required',
//            'body' =>  'required',
//            'category_id' => 'required',
//            'tags' => 'required'
//        ]);


        //php artisan make:policy PostPolicy -m Post
        // para permitir al usuario editar un post que no es suyo usamos Policy,  y le pasamos el metodo
        // tenemos que poner la relacion en Providers $policies 'App\Post' => 'App\Policies\PostPolicy'
        // autorizacion para ver esta publicacion
        $this->authorize('update', $post);

        $post->title = $request->get('title');
        $post->url = str_slug($request->get('title'));
        $post->excerpt = $request->get('excerpt');
        $post->body = $request->get('body');
        $post->iframe = $request->get('iframe');

        // queremos dejar a null el campo de publishd para no mosrarlo
        // Esto es para usarlo sin mutadores
        //$post->published_at = !is_null($request->get('published_at')) ? Carbon::parse($request->get('published_at')) : null;
        $post->published_at = $request->get('published_at');

        //Con simple select
        // este codigo cambia con refacto para llevar la logica a StorePostRequest como filtro para modificar los datos que vienen del formulario
        //$cat = $request->get('category_id');
        //$post->category_id = Category::find($cat) ? $cat : Category::create([ 'name' => $cat])->id;
        $post->category_id = $request->get('category_id');
        //etiquetas
        $post->save();

        // Categorias de tags sin refactor
        //$tags = [];
        //foreach ($request->get('tags') as $tag) {
        //    $tags[] = Tag::find($tag) ? $tag : Tag::create(['name' => $tag])->id;
        //}

        $post->syncTags($request->get('tags'));

        // Sin adicionde tag segun los vamos añadiendo
        //$post->tags()->sync($request->get('tags'));

        return back()->with('flash', 'Tu publicacion Ha sido Actualizada');
        //return $request->all();
    }


    public function store(StorePostRequest $request) {

        /** primera forma de crear un post
        $post = new Post;
        $post->title = $request->get('title');
        $post->excerpt = $request->get('excerpt');
        $post->body = $request->get('body');
        $post->published_at = Carbon::parse($request->get('published_at'));
        $post->category_id = $request->get('category_id');
        //etiquetas
        $post->save();
        $post->tags()->attach($request->get('tags'));
         * **/

        // Validaciones0
//        $this->validate($request, [
//            'title' =>  'required',
//            'excerpt' =>  'required',
//            'body' =>  'required',
//            'category_id' => 'required',
//            'tags' => 'required'
//        ]);

        $post = new Post;
        $post->title = $request->get('title');
        // la generacion del la url ahora la hacemos con un mutador en lugar de aqui pero estoe  correcto tambien
        //$post->url = str_slug($request->get('title'));
        $post->excerpt = $request->get('excerpt');
        $post->body = $request->get('body');
        // queremos dejar a null el campo de publishd para no mosrarlo
        //$post->published_at = !is_null($request->get('published_at')) ? Carbon::parse($request->get('published_at')) : null;
        $post->published_at = $request->get('published_at');


        //Con simple select
        //$post->category_id = $request->get('category_id');
        // Con creación de categoria en select, si no encontramos la categoria nueva la creamos sino la seleccionamos y pasamos el valor
        // este codigo cambia con refacto para llevar la logica a StorePostRequest como filtro para modificar los datos que vienen del formulario
        //$cat = $request->get('category_id');
        //$post->category_id = Category::find($cat) ? $cat : Category::create([ 'name' => $cat])->id;
        $post->category_id = $request->get('category_id');



        //etiquetas
        $post->save();


        // Categorias de tags sin refactor
        //$tags = [];
        //foreach ($request->get('tags') as $tag) {
        //    $tags[] = Tag::find($tag) ? $tag : Tag::create(['name' => $tag])->id;
        //}

        $post->syncTags($request->get('tags'));

        // Sin adicionde tag segun los vamos añadiendo
        //$post->tags()->sync($request->get('tags'));



        return back()->with('flash', 'Tu publicacion Ha sido creada');
        //return $request->all();
    }

    public function destroy(Post $post) {

//        // eliminamos todas las etiquetas y sus relaciones
//        $post->tags()->detach();
//        // eliminamos cada una de las fotos del post
//        $post->photos->each->delete();
//        // para quitar estos metodos de aqui los hemos peusto en el modelo  de Post con una mutacion en el boot
        // para que a parte de que elimine el post, elminime los tags y las fotos estaicas tambien, por lo que solo tenemos que ejecutar el delete


        //php artisan make:policy PostPolicy -m Post
        // para permitir al usuario editar un post que no es suyo usamos Policy,  y le pasamos el metodo
        // tenemos que poner la relacion en Providers $policies 'App\Post' => 'App\Policies\PostPolicy'
        // autorizacion para ver esta publicacion
        $this->authorize('delete', $post);

        // eliminamos el post
        $post->delete();

        return redirect()->route('admin.posts.index')->with('flash', 'El post ha sido eliminado');

    }
}
