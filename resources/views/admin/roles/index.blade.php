
@extends('admin.layout')

@section('header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Todos los Roles</h1>
                <!-- directiva can con policy para controlar que se pued hacer o ver elementos-->
                @can('create', $roles->first())
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary pull-right" >Crear rol</a>
                @endcan
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="fa fa-home"></i> Inicio</a></li>
                    <li class="breadcrumb-item">Roles</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@stop

@section('content')

    <table id="roles-table" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Identificador</th>
            <th>Nombre</th>
            <th>Permisos</th>
            <th>Acciones</th>
{{--quitamos el guard_name porque solo usamos web, no api que tambien está disponible--}}
{{--            <th>Guard</th>--}}
        </tr>
        </thead>
        <tbody>
        @if(isset($roles))
            @foreach($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->display_name }}</td>
                    <td>{{ $role->permissions->pluck('display_name')->implode(', ') }}</td>
{{--                    quitamos el guard_name porque solo usamos web, no api que tambien está disponible--}}
{{--                    <td>{{ $role->guard_name }}</td>--}}
                    <td>
                        @can('update', $role)
                        <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-info"><i class="fa fa-pen"></i></a>
                        @endcan
                        @can('delete', $role)
                            <!-- Si somos admin no mostramos el boton de eliminar-->
                            @if($role->id !== 1)
                            <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" style="display: inline">
                                {{ method_field('DELETE') }}{{ csrf_field() }}
                                <button onclick="return confirm('Seguro que quieres eliminar?')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                            </form>
                            @endif
                        @endcan
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
            $('#roles-table').DataTable({
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

@endpush
