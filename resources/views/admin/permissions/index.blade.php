
@extends('admin.layout')

@section('header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="fa fa-home"></i> Inicio</a></li>
                    <li class="breadcrumb-item">Permisos</li>
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
            <th>Acciones</th>
            {{--quitamos el guard_name porque solo usamos web, no api que tambien está disponible--}}
            {{--            <th>Guard</th>--}}
        </tr>
        </thead>
        <tbody>
        @if(isset($permissions))
            @foreach($permissions as $permission)
                <tr>
                    <td>{{ $permission->id }}</td>
                    <td>{{ $permission->name }}</td>
                    <td>{{ $permission->display_name }}</td>
                    {{--                    quitamos el guard_name porque solo usamos web, no api que tambien está disponible--}}
                    {{--                    <td>{{ $permission->guard_name }}</td>--}}
                    <td>
                        <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-info"><i class="fa fa-pen"></i></a>
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
