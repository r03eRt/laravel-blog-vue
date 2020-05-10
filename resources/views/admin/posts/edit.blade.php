
@extends('admin.layout')

@push('styles')
    <!-- daterange picker -->
    <link rel="stylesheet" href="/adminlte/plugins/daterangepicker/daterangepicker.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/adminlte/plugins/summernote/summernote-bs4.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="/adminlte/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.0.1/min/dropzone.min.css">
@endpush

@section('header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">EDITAR un nuevo post</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="fa fa-home"></i> Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}"><i class="fa fa-list"></i> Posts</a></li>
                    <li class="breadcrumb-item active">Crear Post</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@stop

@section('content')
    <form role="form" method="post" action="{{ route('admin.posts.update', $post) }}">
        {{ csrf_field()  }} {{ method_field('PUT') }}
        <div class="row">
            <div class="col-md-8 ">
                <div class="form-group {{ $errors->has('title') ? 'has-error': '' }}">
                    <label for="title">Título</label>
                    <!-- parámetro 2 de old para que por defecto lo ponga si no viene -->
                    <input value="{{ old('title', $post->title) }}" name="title" type="text" class="form-control {{ $errors->has('title') ? 'is-invalid': '' }}" id="title" placeholder="Ingresa titulo">
                    {!! $errors->first('title', '<span class="invalid-feedback">:message</span>') !!}
                </div>

                <div class="form-group">
                    <label for="body">Contenido de la Publicación</label>
                    <textarea name="body" class="textareaEditor {{ $errors->has('body') ? 'is-invalid': '' }}" placeholder="Place some text here" cols="30" rows="9">{{ old('body', $post->body) }}</textarea>
                    {!! $errors->first('body', '<span class="invalid-feedback">:message</span>') !!}
                </div>
                <!-- /.card-body -->

                <div class="form-group">
                    <label for="iframe">Contenido de la Publicación</label>
                    <textarea name="iframe" class="textarea {{ $errors->has('iframe') ? 'is-invalid': '' }}" style="width:100%" placeholder="Contenido Iframe" cols="30" rows="2">{{ old('iframe', $post->iframe) }}</textarea>
                    {!! $errors->first('iframe', '<span class="invalid-feedback">:message</span>') !!}
                </div>
                <!-- /.card-body -->


            </div>
            <div class="col-md-4">
                <!-- Date -->
                <div class="form-group">
                    <label>Fecha</label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input value="{{ old('published_at', $post->published_at ? $post->published_at->format('m/d/Y') : null)  }}" type="text" name="published_at" class="form-control datetimepicker-input {{ $errors->has('published_at') ? 'is-invalid': '' }}" data-target="#reservationdate"/>
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                        {!! $errors->first('published_at', '<span class="invalid-feedback">:message</span>') !!}
                    </div>
                </div>

                <!-- select -->
                <div class="form-group">
                    <label>Categoría</label>
                    <select name="category_id" class="form-control select2 {{ $errors->has('category_id') ? 'is-invalid': '' }}">
                        <option>Selecciona una categoria</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{  old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    {!! $errors->first('category_id', '<span class="invalid-feedback">:message</span>') !!}
                </div>

                <div class="form-group">
                    <label>Tags</label>
                    <select name="tags[]" class="select2 {{ $errors->has('tags') ? 'is-invalid': '' }}" multiple="multiple" data-placeholder="Selecciona tags" style="width: 100%;">
                        @foreach($tags as $tag)
                            <option {{ collect(old('tags', $post->tags->pluck('id')))->contains($tag->id) ? 'selected' : '' }} value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                    {!! $errors->first('tags', '<span class="invalid-feedback">:message</span>') !!}

                </div>

                <!-- /.form group -->
                <div class="form-group">
                    <label for="excerpt">Extracto</label>
                    <textarea name="excerpt" id="" cols="30" rows="3" class="form-control {{ $errors->has('excerpt') ? 'is-invalid': '' }}" placeholder="Ingresa un extracto de la publicacion">{{ old('excerpt', $post->excerpt) }}</textarea>
                    {!! $errors->first('excerpt', '<span class="invalid-feedback">:message</span>') !!}
                </div>

                <!-- /.form group -->
                <div class="form-group">
                    <div class="dropzone"></div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-large btn-primary">Publicar</button>
                </div>
            </div>
        </div>
    </form>

    @if($post->photos->count())
        <!-- Para cada foto ahcemros un formulario que enciará la foto al controlador -->
        <div>
            @foreach($post->photos as $photo)
                <form method="POST" action="{{ route('admin.photos.destroy', $photo) }}"  style="display: inline">
                    <!-- se usa para simular metodos ya que solo se puede usar GET y POST, para PUT Y DELETE se usa -->
                    {{ method_field('DELETE') }} {{ csrf_field() }}
                    <figure class="image-test col-md-2">
                        <button class="btn btn-danger btn-xs" style="position: absolute;"><i class="fa fa-trash"></i></button>
                        <img  width="100" src="{{ url($photo->url) }}" alt="">
                    </figure>
                </form>
            @endforeach
        </div>
    @endif

@stop



@push('scripts')
    <!-- Date picker -->
    <script src="/adminlte/plugins/moment/moment.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="/adminlte/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- Select2 -->
    <script src="/adminlte/plugins/select2/js/select2.full.min.js"></script>
    <!-- Dropzone -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.0.1/min/dropzone.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;
        $(function () {
            //Date range picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            // Summernote
            $('.textareaEditor').summernote({
                height: 170,   //set editable area's height
                codemirror: { // codemirror options
                    theme: 'monokai'
                }
            });

            $('.select2').select2({
                tags: true
            });

            $(".dropzone").dropzone({
                url: "/admin/posts/{{ $post->url }}/photos",
                paramName: 'photo',
                acceptedFiles: 'image/*',
                maxFilesize: 2,
                //maxFiles: 1,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                dictDefaultMessage: 'Arrastra las fotos aqui para subirlas',
                init: function() {
                    this.on("error", function(file, res) {
                        //var msg = res.errors.photo[0];
                        $('.dz-error-message > span').text(res)
                    });
                }
            });
        });
    </script>
@endpush
