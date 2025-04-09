<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo with User Info -->
    <div class="brand-container">
        <a href="{{ route('home') }}" class="brand-link" style="text-decoration: none;">
            <div class="brand-image-container">
                <i class="fas fa-user-circle" style="font-size: 2.5rem; color: white;"></i>
            </div>
            <div class="brand-text-container">
                <span class="brand-text font-weight-light" style="color: white;">
                    {{ auth()->user()->name }}
                </span>
                <small class="brand-subtext">{{ auth()->user()->email }}</small>
            </div>
        </a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- SidebarSearch Form -->
        <div class="sidebar-search-container">
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Buscar..." aria-label="Buscar">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar" type="button" aria-label="Buscar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Tickets Section -->
                <li class="nav-item {{ request()->routeIs('historial-tickets.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('historial-tickets.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-ticket-alt"></i>
                        <p>
                            Tickets
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('historial-tickets.index') }}" class="nav-link {{ request()->routeIs('historial-tickets.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Historial</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('historial-tickets.export', ['ticket' => 1]) }}" class="nav-link">
                                <i class="far fa-file-pdf nav-icon"></i>
                                <p>Exportar PDF</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Reservations -->
                <li class="nav-item">
                    <a href="{{ route('reservas.index') }}" class="nav-link {{ request()->routeIs('reservas.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-check"></i>
                        <p>Reservas</p>
                    </a>
                </li>

                <!-- Divider -->
                <li class="nav-header mt-2">CONFIGURACIÓN</li>

                <!-- Configuration Items -->
                <li class="nav-item">
                    <a href="{{ route('tipotickets.index') }}" class="nav-link {{ request()->routeIs('tipotickets.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Tipos de Ticket</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('estados-tickets.index') }}" class="nav-link {{ request()->routeIs('estados-tickets.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>Estados</p>
                    </a>
                </li>

                <!-- Divider -->
                <li class="nav-header mt-2">USUARIO</li>

                <!-- User Profile -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>Mi Perfil</p>
                    </a>
                </li>

                <!-- Logout -->
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Cerrar Sesión</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<style>
    .brand-container {
        padding: 0.5rem 1rem;
        background-color: rgba(0, 0, 0, 0.15);
    }
    .brand-image-container {
        display: inline-block;
        vertical-align: middle;
        margin-right: 10px;
    }
    .brand-text-container {
        display: inline-block;
        vertical-align: middle;
    }
    .brand-subtext {
        display: block;
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.8);
    }
    .sidebar-search-container {
        padding: 10px;
    }
    .nav-header {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
        text-transform: uppercase;
    }
    .fa-user-circle {
        font-size: 2.5rem !important;
        color: white !important;
    }
</style>