<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->

    <li class="nav-item">
        <a href="{{ route('admin') }}" class="nav-link {{ request()->is('admin') ? 'active': '' }}">
            <i class="nav-icon fas fa-home"></i>
            <p>
                Inicio
            </p>
        </a>
    </li>
    <li class="nav-item has-treeview {{ request()->is('admin/posts*') ? 'menu-open': '' }}">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-bars"></i>
            <p>
                Starter Pages
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item ">
                <a href="{{ route('admin.posts.index') }}" class="nav-link {{ request()->is('admin/posts') ? 'active': '' }}">
                    <i class="nav-icon fas fa-eye"></i>
                    <p>
                        Ver todos los posts
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.posts.create') }}" class="nav-link {{ request()->is('admin/posts/create') ? 'active': '' }}">
                    <i class="nav-icon fas fa-pen"></i>
                    <p>
                        Crear un post
                    </p>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item has-treeview {{ request()->is('admin/users*') ? 'menu-open': '' }}">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-bars"></i>
            <p>
                Usuarios
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item ">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->is('admin/users') ? 'active': '' }}">
                    <i class="nav-icon fas fa-eye"></i>
                    <p>
                        Ver todos los usuarios
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users.create') }}" class="nav-link {{ request()->is('admin/users/create') ? 'active': '' }}">
                    <i class="nav-icon fas fa-pen"></i>
                    <p>
                        Crear un usuario
                    </p>
                </a>
            </li>
        </ul>
    </li>
        <li class="nav-item has-treeview {{ request()->is('admin/permissions*') ? 'menu-open': '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-bars"></i>
                <p>
                    Permisos
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item ">
                    <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ request()->is('admin/permissions') ? 'active': '' }}">
                        <i class="nav-icon fas fa-eye"></i>
                        <p>
                            Ver todos los permisos
                        </p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item has-treeview {{ request()->is('admin/roles*') ? 'menu-open': '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-bars"></i>
                <p>
                    Roles
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item ">
                    <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->is('admin/roles') ? 'active': '' }}">
                        <i class="nav-icon fas fa-eye"></i>
                        <p>
                            Ver todos los roles
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.roles.create') }}" class="nav-link {{ request()->is('admin/roles/create') ? 'active': '' }}">
                        <i class="nav-icon fas fa-pen"></i>
                        <p>
                            Crear role
                        </p>
                    </a>
                </li>
            </ul>
        </li>
</ul>
</nav>
