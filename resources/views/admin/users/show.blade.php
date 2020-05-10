@extends('admin.layout')


@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle align-content-center" src="/adminlte/img/user4-128x128.jpg" alt="User profile picture">

                    <h3 class="profile-username text-center">{{ $user->name }}</h3>

                    <p class="text-muted text-center">{{ $user->getRoleNames()->implode(', ') }}</p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Email</b> <a class="pull-right">{{ $user->email }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Publicaciones</b> <a class="pull-right">{{ $user->posts->count() }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Roles</b> <a class="pull-right">{{ $user->getRoleNames()->implode(', ') }}</a>
                        </li>
                    </ul>

                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-block"><b>Editar</b></a>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <h3>Publicaciones</h3>
                        @forelse($user->posts as $post)
                            <p>
                                <a href="{{ route('posts.show', $post) }}" target="_blank">{{ $post->title }}</a>
                                <small class="text-muted">Publicado el {{ $post->published_at->format('d/m/Y') }}</small><br>
                                <span>{{ $post->excerpt }}</span>
                            </p>
                            @unless($loop->last)
                            <hr>
                            @endunless
                        @empty
                            <small class="text-muted">No tiene Posts</small>
                        @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <h3>Roles</h3>
                    @forelse($user->roles as $role)
                        <p>
                            <span>{{ $role->name }}</span><br>
                            @if($role->permissions->count())
                                <small class="text-muted">
                                    Permisos: {{ $role->permissions->pluck('name')->implode(', ') }}
                                </small><br>
                            @endif
                        </p>
                        @unless($loop->last)
                            <hr>
                        @endunless
                        @empty
                            <small class="text-muted">No tiene Roles adicionales</small>
                        @endforelse

                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <h3>Permisos extra</h3>
                    @forelse($user->permissions as $permission)
                        <p>
                            <span>{{ $permission->name }}</span><br>
                            @if($permission->permissions->count())
                                <small class="text-muted">
                                    {{ $permission->name }}
                                </small><br>
                            @endif
                        </p>
                        @unless($loop->last)
                            <hr>
                        @endunless
                    @empty
                        <small class="text-muted">No tiene permisos adicionales</small>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@stop
