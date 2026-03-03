<header>
    <nav class="navbar navbar-expand-lg fixed-top shadow-lg"
        style="background: linear-gradient(135deg, #198754 0%, #146c43 100%);">
        <div class="container">
            <!-- Logo y marca -->
            <a class="navbar-brand d-flex align-items-center gap-2 py-2" href="{{ route('home') }}">
                <div class="bg-white rounded-circle p-1 shadow-sm">
                    <img src="{{ asset('storage/img/logo.png') }}" alt="Logo Prieto Eats" width="50" height="50"
                        class="rounded-circle" style="object-fit: cover;">
                </div>
                <div class="d-none d-sm-block">
                    <span class="fw-bold text-white fs-4">Prieto Eats</span>
                    <span class="d-block text-white-50 small" style="margin-top: -5px;">Menú del día</span>
                </div>
            </a>

            <!-- Toggler móvil -->
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menú colapsable -->
            <div class="collapse navbar-collapse" id="navbarMain">
                <!-- Enlaces centrales (si los necesitas en el futuro) -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                </ul>

                <!-- Zona derecha -->
                <div class="d-flex align-items-center gap-2">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-light rounded-pill px-4">
                            <i class="bi bi-box-arrow-in-right me-1"></i>
                            <span class="d-none d-md-inline">Iniciar Sesión</span>
                            <span class="d-md-none">Entrar</span>
                        </a>

                        <a href="{{ route('register') }}" class="btn btn-light text-success rounded-pill px-4 fw-semibold">
                            <i class="bi bi-person-plus-fill me-1"></i>
                            <span class="d-none d-md-inline">Registrarse</span>
                            <span class="d-md-none">Registro</span>
                        </a>
                    @endguest

                    @auth
                        <ul class="navbar-nav align-items-center gap-1">
                            <!-- Menú Admin -->
                            @admin
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle px-3 py-2 rounded-pill text-white d-flex align-items-center gap-2"
                                        href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false" style="background: rgba(255,255,255,0.15);">
                                        <i class="bi bi-gear-fill"></i>
                                        <span class="d-none d-lg-inline">Admin</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 mt-2 p-2"
                                        aria-labelledby="adminDropdown" style="min-width: 220px;">
                                        <li class="px-2 py-1">
                                            <span class="text-muted small text-uppercase fw-semibold">Administración</span>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider my-2">
                                        </li>
                                        <li>
                                            <a class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2"
                                                href="{{ route('admin.products.index') }}">
                                                <span class="bg-success bg-opacity-10 rounded-2 p-2">
                                                    <i class="bi bi-box-seam-fill text-success"></i>
                                                </span>
                                                Productos
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2"
                                                href="{{ route('admin.offers.index') }}">
                                                <span class="bg-warning bg-opacity-10 rounded-2 p-2">
                                                    <i class="bi bi-tags-fill text-warning"></i>
                                                </span>
                                                Ofertas
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2"
                                                href="{{ route('admin.orders.index') }}">
                                                <span class="bg-info bg-opacity-10 rounded-2 p-2">
                                                    <i class="bi bi-receipt text-info"></i>
                                                </span>
                                                Reservas
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endadmin

                            <!-- Carrito -->
                            <li class="nav-item">
                                <a class="nav-link px-3 py-2 rounded-pill text-white position-relative"
                                    href="{{ route('cart.index') }}" style="background: rgba(255,255,255,0.1);">
                                    <i class="bi bi-cart3 fs-5"></i>
                                    @if (session('cart') && count(session('cart')) > 0)
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark"
                                            style="font-size: 0.65rem;">
                                            {{ count(session('cart')) }}
                                        </span>
                                    @endif
                                </a>
                            </li>

                            <!-- Usuario -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle px-3 py-2 rounded-pill text-white d-flex align-items-center gap-2"
                                    href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false" style="background: rgba(255,255,255,0.15);">
                                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 32px; height: 32px;">
                                        <i class="bi bi-person-fill text-success"></i>
                                    </div>
                                    <span class="d-none d-lg-inline fw-medium">{{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 mt-2 p-2"
                                    aria-labelledby="userDropdown" style="min-width: 220px;">
                                    <!-- Info usuario -->
                                    <li class="px-3 py-2">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 45px; height: 45px;">
                                                <i class="bi bi-person-fill text-success fs-4"></i>
                                            </div>
                                            <div>
                                                <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                                                <small class="text-muted">{{ Auth::user()->email }}</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider my-2">
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2"
                                            href="{{ route('orders.index') }}">
                                            <i class="bi bi-bag-check text-success"></i>
                                            Mis Reservas
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider my-2">
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2 text-danger">
                                                <i class="bi bi-box-arrow-right"></i>
                                                Cerrar sesión
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>

<style>
    /* Estilos del navbar */
    .navbar {
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    .dropdown-item {
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background-color: rgba(25, 135, 84, 0.1);
        transform: translateX(5px);
    }

    .nav-link {
        transition: all 0.3s ease;
    }

    .nav-link:hover {
        background: rgba(255, 255, 255, 0.25) !important;
    }

    /* Animación del dropdown */
    .dropdown-menu {
        animation: dropdownFade 0.2s ease;
    }

    @keyframes dropdownFade {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Mobile adjustments */
    @media (max-width: 991.98px) {
        .navbar-collapse {
            background: linear-gradient(135deg, #198754 0%, #146c43 100%);
            margin: 1rem -1rem -0.5rem;
            padding: 1rem;
            border-radius: 0 0 1rem 1rem;
        }

        .navbar-nav {
            gap: 0.5rem;
        }

        .dropdown-menu {
            background: rgba(255, 255, 255, 0.1);
            border: none;
        }

        .dropdown-menu .dropdown-item {
            color: white;
        }

        .dropdown-menu .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .dropdown-menu .dropdown-divider {
            border-color: rgba(255, 255, 255, 0.2);
        }

        .dropdown-menu .text-muted {
            color: rgba(255, 255, 255, 0.7) !important;
        }
    }
</style>
