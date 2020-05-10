
@extends('admin.layout')

@section('header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Todos los usuarios</h1>
                @can('create', $users->first())
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary pull-right" >Crear usuario</a>
                @endcan
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="fa fa-home"></i> Inicio</a></li>
                    <li class="breadcrumb-item">Usuarios</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@stop

@section('content')

    <table id="user-table" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Roles</th>
        </tr>
        </thead>
        <tbody>
        @if(isset($users))
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->getRoleNames()->implode(', ') }}</td>
                    <td>
                        @can('view', $user)
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-default" target="_blank"><i class="fa fa-eye"></i></a>
                        @endcan
                        @can('update', $user)
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-info"><i class="fa fa-pen"></i></a>
                        @endcan
                        @can('delete', $user)
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display: inline">
                            {{ method_field('DELETE') }}{{ csrf_field() }}
                            <button onclick="return confirm('Seguro que quieres eliminar?')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
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
            $('#user-table').DataTable({
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
