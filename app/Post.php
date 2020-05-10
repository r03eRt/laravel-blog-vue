<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    // Con esto protegemos los campos del formulario que se pueden alterar en el modelo y podemos en lugar de hacer $post = Post::create([ 'title' => $request->get('title' .... )])
    // pasamos $request->all() y solo coge los que le hayamos dejado.
    protected $fillable = [
        'title', 'body', 'iframe', 'excerpt', 'published_at', 'category_id', 'user_id'
    ];

    //Con esto decimos a Larabel que el campopuclished at es un campo deCarbon de php para usar metodo Format
    protected $dates = ['published_at'];

    //Utilizamos esto para mejorar el rendimiento(precargamos relaciones), debe coincidor con la relacion que está en el metodo post.
    protected $with = ['category', 'tags', 'owner', 'photos'];


    // Lo desactivamos para poder guiardar directamente en base de datos
    protected $guarded = [];

    // Reescribimos este metodo para que reconoaca el post por el nombre en lugar de por el id
    public function getRouteKeyName()
    {
        return 'url';
    }

    // El post pertenece a la categoia
    public function category() { // $post->category()
        return $this->belongsTo(Category::class);
    }

    // El post pertenece al tag 1->N
    public function tags() { // $post->category()
        return $this->belongsToMany(Tag::class);
    }

    // El post puede tener varias photos
    public function photos() { // $post->category()
        return $this->hasMany(Photo::class);
    }

    /**
     * Con esta funcions nos llevamos la query del controlador al Modelo
     * @param $query
     */
    public function scopePublished($query) {
        $query->whereNotNull('published_at')
            ->where('published_at', '<=', Carbon::now())
            ->latest('published_at');
    }

    /**
     * Esto es un mutador para modificar attributos del modelo antes de guardar de basde datos, como un filtro la sintaxis getNameAttribute
     */
//    public function setTitleAttribute($title) {
//        $this->attributes['title'] =  $title;
//
//        $url = str_slug($title);
//        //Este filtro lo usamos por si se repite el titlo para que no coincida la url
//        $duplicateUrlCount = Post::where('url', 'LIKE', "{$url}%")->count();
//
//        if($duplicateUrlCount) {// sacamos el utlimo valro repeido pimer-post-2
//            $url .= '-' . ++$duplicateUrlCount;
//        }
//
//        $this->attributes['url'] =  $url;
//
//    }

    /**
     * Esto es un mutador para modificar attributos del modelo antes de guardar de basde datos, como un filtro la sintaxis getNameAttribute
     */
    public function setPublishedAtAttribute($published_at) {
        $this->attributes['published_at'] =  !is_null($published_at)
                                            ? Carbon::parse($published_at)
                                            : null;

    }

    /**
     * Esto es un mutador para modificar attributos del modelo antes de guardar de basde datos, como un filtro la sintaxis getNameAttribute
     */
    public function setCategoryIdAttribute($category) {
        $this->attributes['category_id'] =  Category::find($category)
                                            ? $category
                                            : Category::create([ 'name' => $category])->id;

    }


    /**
     * @param $tags
     * @return array
     */
    public function syncTags($tags) {
        $tagId = collect( $tags)->map(function($tag) {
            return $tags[] = Tag::find($tag) ? $tag : Tag::create(['name' => $tag])->id;
        });
        return $this->tags()->sync($tags);

    }

    protected static function boot() {
        parent::boot();
        static::deleting(function($post) {
            $post->tags()->detach();
            $post->photos->each->delete();
        });
    }

    /**
     * @return bool
     */
    public function isPublished() {
       return !is_null($this->published_at) && $this->published_at < today();
    }

    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return string
     */
    public function viewType($home = '') {

        if($this->photos->count() === 1):
           return 'posts.photo';
        elseif($this->photos->count() > 1):
          return $home === 'home' ? 'posts.carousel-preview' : 'posts.carousel';
        elseif($this->iframe):
          return 'posts.iframe';
        else:
            return 'posts.text';
        endif;
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
            return $query->where('user_id', auth()->id());
            //return auth()->user()->posts;
        }
    }

    public function scopeByYearAndMonth($query) {
            return $query->selectRaw('year(published_at) year')
            ->selectRaw('month(published_at) month')
            ->selectRaw('monthname(published_at) monthname')
            ->selectRaw('count(*) posts')
            ->groupBy('year', 'month', 'monthname');
            //->orderBy('published_at')
            //->get();
    }




}
