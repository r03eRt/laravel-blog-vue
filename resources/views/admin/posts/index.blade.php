
@extends('admin.layout')

@section('header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Todas las publicaciones</h1>
                <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#exampleModal">Crear publicación</button>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="fa fa-home"></i> Inicio</a></li>
                    <li class="breadcrumb-item">Posts</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@stop

@section('content')
    <table id="post-table" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Extracto</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @if(isset($posts))
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->excerpt }}</td>
                    <td>
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-default" target="_blank"><i class="fa fa-eye"></i></a>
                        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-info"><i class="fa fa-pen"></i></a>
                        <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" style="display: inline">
                            {{ method_field('DELETE') }}{{ csrf_field() }}
                            <button onclick="return confirm('Seguro que quieres eliminar?')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@stop


@push('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
@endpush


@push('scripts')
    <!-- DataTables -->
    <script src="/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(function () {
            $('#post-table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

        });
    </script>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <form role="form" method="POST" action="{{ route('admin.posts.create2', $post, '#create') }}">
            {{ csrf_field()  }}
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agrega el titulo para la nueva notifcación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group {{ $errors->has('title') ? 'has-error': '' }}">
                        <label for="title">Título</label>
                        <input value="{{ old('title') }}" name="title" type="text" class="form-control {{ $errors->has('title') ? 'is-invalid': '' }}" id="title" placeholder="Ingresa titulo" >
                        {!! $errors->first('title', '<span class="invalid-feedback">:message</span>') !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Crear puplicación</button>
                </div>
            </div>
        </div>
        </form>
    </div>
@endpush
