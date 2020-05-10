
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
                <h1 class="m-0 text-dark">Crear un nuevo post</h1>
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
<form id="form_id" role="form" method="post" action="{{ route('admin.posts.store') }}" onsubmit="return validateForm()">
    {{ csrf_field()  }}
    <div class="row">
        <div class="col-md-8 ">
            <div class="form-group {{ $errors->has('title') ? 'has-error': '' }}">
                <label for="title">Título</label>
                <input value="{{ old('title') }}" name="title" type="text" class="form-control {{ $errors->has('title') ? 'is-invalid': '' }}" id="title" placeholder="Ingresa titulo">
                {!! $errors->first('title', '<span class="invalid-feedback">:message</span>') !!}
            </div>

            <div class="form-group">
                <label for="body">Contenido de la Publicación</label>
                <textarea name="body" class="textarea {{ $errors->has('body') ? 'is-invalid': '' }}" placeholder="Place some text here" cols="30" rows="9">{{ old('body') }}</textarea>
                {!! $errors->first('body', '<span class="invalid-feedback">:message</span>') !!}
            </div>
            <!-- /.card-body -->
        </div>
        <div class="col-md-4">
            <!-- Date -->
            <div class="form-group">
                <label>Fecha</label>
                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                    <input value="{{ old('published_at') }}" type="text" name="published_at" class="form-control datetimepicker-input {{ $errors->has('published_at') ? 'is-invalid': '' }}" data-target="#reservationdate"/>
                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                    {!! $errors->first('published_at', '<span class="invalid-feedback">:message</span>') !!}
                </div>
            </div>

            <!-- select -->
            <div class="form-group">
                <label>Categoría</label>
                <select name="category_id" class="form-control {{ $errors->has('category_id') ? 'is-invalid': '' }}">
                    <option>Selecciona una categoria</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('category_id', '<span class="invalid-feedback">:message</span>') !!}
            </div>

            <div class="form-group">
                <label>Tags</label>
                <select value="{{ old('tags') }}" name="tags[]" class="select2 {{ $errors->has('tags') ? 'is-invalid': '' }}" multiple="multiple" data-placeholder="Selecciona tags" style="width: 100%;">
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }} {{ collect(old('tags'))->contains($tag->id) ? 'selected' : '' }} ">{{ $tag->name }}</option>
                    @endforeach
                </select>
                {!! $errors->first('tags', '<span class="invalid-feedback">:message</span>') !!}

            </div>

            <!-- /.form group -->
            <div class="form-group">
                <label for="excerpt">Extracto</label>
                <textarea name="excerpt" id="" cols="30" rows="3" class="form-control {{ $errors->has('excerpt') ? 'is-invalid': '' }}" placeholder="Ingresa un extracto de la publicacion">{{ old('excerpt') }}</textarea>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;
        $(function () {
            //Date range picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            // Summernote
            $('.textarea').summernote({
                height: 170,   //set editable area's height
                codemirror: { // codemirror options
                    theme: 'monokai'
                }
            });

            $('.select2').select2();

            function getUrl() {
                return document.querySelector('#title').value;
            }

            $(".dropzone").dropzone({
                url: "/admin/posts/"+slug(getUrl())+"/photos",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                init: function() {
                    this.on("processing", function(file) {
                        this.options.url = "/admin/posts/"+slug(getUrl())+"/photos";
                    });

                    this.on("error", function(file, res) {
                        console.log(res);
                    });
                }
            });





            function slug (str) {
                str = str.replace(/^\s+|\s+$/g, ''); // trim
                str = str.toLowerCase();
                // remove accents, swap ñ for n, etc
                var from = "àáãäâèéëêìíïîòóöôùúüûñç·/_,:;";
                var to   = "aaaaaeeeeiiiioooouuuunc------";

                for (var i=0, l=from.length ; i<l ; i++) {
                    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
                }
                str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                    .replace(/\s+/g, '-') // collapse whitespace and replace by -
                    .replace(/-+/g, '-'); // collapse dashes
                return str;
            }

        });
    </script>
@endpush
