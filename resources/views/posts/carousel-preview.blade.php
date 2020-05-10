<div class="">
    @foreach($post->photos as $photo)
        <figure class="test">
            <img src="{{ url($photo->url) }}" class="img-responsive" alt="">
            @if($loop->iteration == 4)
                <div class="overlay">
                    <span>{{ $post->photos->count() }} Fotos</span>
                </div>
            @endif
        </figure>
    @endforeach
</div>
