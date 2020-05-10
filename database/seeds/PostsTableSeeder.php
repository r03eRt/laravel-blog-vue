<?php

use App\Category;
use App\Post;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Database\Seeder;


class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Limpiar la tabla post
        Post::truncate();
        Category::truncate();
        Tag::truncate();

        $category = new Category;
        $category->name = 'Categoria 1';
        $category->save();

        $category = new Category;
        $category->name = 'Categoria 2';
        $category->save();





        $post = new Post;
        $post->title = 'Titulo de post 1';
        $post->url = str_slug('Titulo de post 1');
        $post->excerpt = 'Excerpt del post numero 1';
        $post->body = '<p>Cuerpo del primer post 1</p>';
        $post->published_at = Carbon::now();
        $post->category_id = 1;
        $post->user_id = 1;
        $post->save();

        $post->tags()->sync(Tag::create(['name' => 'Etiqueta 1']));

        $post = new Post;
        $post->title = 'Titulo de post 2';
        $post->url = str_slug('Titulo de post 2');
        $post->excerpt = 'Excerpt del post numero 2';
        $post->body = '<p>Cuerpo del primer post 2</p>';
        $post->published_at = Carbon::now()->subDays(1);
        $post->category_id = 1;
        $post->user_id = 1;
        $post->save();

        $post->tags()->sync(Tag::create(['name' => 'Etiqueta 2']));

        $post = new Post;
        $post->title = 'Titulo de post 3';
        $post->url = str_slug('Titulo de post 3');
        $post->excerpt = 'Excerpt del post numero 3';
        $post->body = '<p>Cuerpo del primer post 3</p>';
        $post->published_at = Carbon::now()->subDays(2);
        $post->category_id = 2;
        $post->user_id = 2;
        $post->save();

        $post->tags()->sync(Tag::create(['name' => 'Etiqueta 3']));

        $post = new Post;
        $post->title = 'Titulo de post 4';
        $post->url = str_slug('Titulo de post 4');
        $post->excerpt = 'Excerpt del post numero 4';
        $post->body = '<p>Cuerpo del primer post 4</p>';
        $post->published_at = Carbon::now()->subDays(3);
        $post->category_id = 2;
        $post->user_id = 2;
        $post->save();

        $post->tags()->sync(Tag::create(['name' => 'Etiqueta 4']));

//        $tag = new Tag;
//        $tag->name = 'Etiqueta 1';
//        $tag->save();
//
//        $tag = new Tag;
//        $tag->name = 'Etiqueta 2';
//        $tag->save();
    }
}
