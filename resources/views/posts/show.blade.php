@extends('layout')

@section('meta-title')
    {{ $post->title }}
@stop

@section('meta-description')
    {{ $post->excerpt }}
@stop

@push('styles')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script id="dsq-count-scr" src="//zendero.disqus.com/count.js" async></script>
@endpush

@section('content')

    <article class="post container">

            {{-- Polimorfismo para que el post eliga que pintar --}}
            @include( $post->viewType('') )

{{--        @if($post->photos->count() === 1)--}}
{{--            @include('posts.photo')--}}
{{--        @elseif($post->photos->count() > 1)--}}
{{--            @include('posts.carousel')--}}
{{--        @elseif($post->iframe)--}}
{{--            @include('posts.iframe')--}}
{{--        @endif--}}

        <div class="content-post">
           @include('posts.header')

            <h1>{{ $post->title }}</h1>
            <div class="divider"></div>
            <div class="image-w-text">
               {!! $post->body !!}
            </div>
            <footer class="container-flex space-between">
                <div class="buttons-social-media-share">
                    <ul class="share-buttons">
                        <li><a href="https://www.facebook.com/sharer/sharer.php?u=&t=" title="Share on Facebook" target="_blank"><img alt="Share on Facebook" src="/img/flat_web_icon_set/Facebook.png"></a></li>
                        <li><a href="https://twitter.com/intent/tweet?source=&text=:%20" target="_blank" title="Tweet"><img alt="Tweet" src="/img/flat_web_icon_set/Twitter.png"></a></li>
                        <li><a href="http://pinterest.com/pin/create/button/?url=&description=" target="_blank" title="Pin it"><img alt="Pin it" src="/img/flat_web_icon_set/Pinterest.png"></a></li>
                    </ul>
                </div>
                @include('posts.tags')
            </footer>
            <div class="comments">
                <div class="divider"></div>
                <div id="disqus_thread"></div>
                @include('partials.comments')
            </div>
        </div>
    </article>
@stop


