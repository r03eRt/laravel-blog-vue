@extends('layout')


@section('content')

<section class="posts container">
    @if(isset($title))
        <h3>{{ $title }}</h3>
    @endif
    @foreach($posts as $post)
        <article class="post no-image">
                {{-- Polimorfismo para que el post eliga que pintar --}}
                @include( $post->viewType('home') )

{{--            @if($post->photos->count() === 1)--}}
{{--                @include('posts.photo')--}}
{{--            @elseif($post->photos->count() > 1)--}}
{{--               @include('post.carousel-preview')--}}
{{--            @elseif($post->iframe)--}}
{{--               @include('posts.iframe')--}}
{{--            @endif--}}

            <div class="content-post">
                @include('posts.header')
                <h1>{{ $post->title }}</h1>
                <div class="divider"></div>
                <p>{{ $post->excerpt }}</p>
                <footer class="container-flex space-between">
                    <div class="read-more">
                        <a href="{{ route('posts.show', $post) }}" class="text-uppercase c-green">Leer Más</a>
                    </div>
                   @include('posts.tags')
                </footer>
            </div>
        </article>
    @endforeach

</section><!-- fin del div.posts.container -->
{{--{{ $posts->links() }}--}}
<!-- para que mantenga los parametros como month y date de filtros añadimos appends request->all -->
{{ $posts->appends(request()->all())->links() }}
@stop('content')

