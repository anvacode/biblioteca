<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo with User Info -->
    <div class="brand-container">
        <a href="{{ route('home') }}" class="brand-link" style="text-decoration: none;">
            <div class="brand-image-container">
                <i class="fas fa-user-circle"></i>
            </div>
            <div class="brand-text-container">
                <span class="brand-text font-weight-light">
                    {{ auth()->user()->name }}
                </span>
                <small class="brand-subtext">{{ auth()->user()->email }}</small>
            </div>
        </a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
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

                <!-- Tickets -->
                <li class="nav-item">
                    <a href="{{ route('tickets.index') }}" class="nav-link {{ request()->routeIs('tickets.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-ticket-alt"></i>
                        <p>Tickets</p>
                    </a>
                </li>

                <!-- Ticket History -->
                <li class="nav-item">
                    <a href="{{ route('historial-tickets.index') }}" class="nav-link {{ request()->routeIs('historial-tickets.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-history"></i>
                        <p>Historial Tickets</p>
                    </a>
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

                <!-- Ticket Status -->
                <li class="nav-item">
                    <a href="{{ route('estados-tickets.index') }}" class="nav-link {{ request()->routeIs('estados-tickets.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>Estados Tickets</p>
                    </a>
                </li>

                <!-- Ticket Types -->
                <li class="nav-item">
                    <a href="{{ route('tipotickets.index') }}" class="nav-link {{ request()->routeIs('tipotickets.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>Tipos de Ticket</p>
                    </a>
                </li>

                <!-- Divider -->
                <li class="nav-header mt-2">USUARIO</li>

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