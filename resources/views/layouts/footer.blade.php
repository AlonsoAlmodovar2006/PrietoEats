<footer class="mt-auto">
    <!-- Wave decorativa -->
    <div class="footer-wave">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path fill="#212529" d="M0,64L48,69.3C96,75,192,85,288,90.7C384,96,480,96,576,85.3C672,75,768,53,864,48C960,43,1056,53,1152,58.7C1248,64,1344,64,1392,64L1440,64L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path>
        </svg>
    </div>

    <!-- Contenido del footer -->
    <div class="bg-dark text-white py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Logo y descripción -->
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="bg-success rounded-circle p-2">
                            <i class="bi bi-egg-fried text-white fs-4"></i>
                        </div>
                        <h5 class="mb-0 fw-bold">Prieto Eats</h5>
                    </div>
                    <p class="text-white-50 small mb-3">
                        Estudiantes de Formación Profesional de Cocina desde ya sirviéndote los mejores productos.
                    </p>
                    <p class="text-white-50 small mb-3">
                        Reserva fácilmente con la nueva aplicación.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="https://www.facebook.com/iesGPrieto/?locale=es_ES" target="_blank" rel="noopener" class="btn btn-outline-light btn-sm rounded-circle" style="width: 38px; height: 38px;">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/iesgregorioprieto/?hl=es" target="_blank" rel="noopener" class="btn btn-outline-light btn-sm rounded-circle" style="width: 38px; height: 38px;">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="https://x.com/Ies_GPrieto" target="_blank" rel="noopener" class="btn btn-outline-light btn-sm rounded-circle" style="width: 38px; height: 38px;">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                    </div>
                </div>

                <!-- Enlaces rápidos -->
                <div class="col-lg-2 col-md-6">
                    <h6 class="text-uppercase fw-bold mb-3 text-success">Enlaces</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <a href="{{ route('home') }}" class="text-white-50 text-decoration-none footer-link">
                                <i class="bi bi-chevron-right small me-1"></i>Inicio
                            </a>
                        </li>
                        @auth
                            <li class="mb-2">
                                <a href="{{ route('cart.index') }}" class="text-white-50 text-decoration-none footer-link">
                                    <i class="bi bi-chevron-right small me-1"></i>Mi Carrito
                                </a>
                            </li>
                        @endauth
                        @guest
                            <li class="mb-2">
                                <a href="{{ route('login') }}" class="text-white-50 text-decoration-none footer-link">
                                    <i class="bi bi-chevron-right small me-1"></i>Iniciar Sesión
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('register') }}" class="text-white-50 text-decoration-none footer-link">
                                    <i class="bi bi-chevron-right small me-1"></i>Registrarse
                                </a>
                            </li>
                        @endguest
                    </ul>
                </div>

                <!-- Horario -->
                <div class="col-lg-3 col-md-6">
                    <h6 class="text-uppercase fw-bold mb-3 text-success">Horario de Recogida</h6>
                    <ul class="list-unstyled mb-0 text-white-50 small">
                        <li class="mb-2 d-flex justify-content-between">
                            <span>Lunes - Viernes</span>
                            <span class="text-white">13:30 - 14:30</span>
                        </li>
                        <li class="mb-2 d-flex justify-content-between">
                            <span>Sábado y Domingo</span>
                            <span class="text-danger">Cerrado</span>
                        </li>
                    </ul>
                </div>

                <!-- Contacto -->
                <div class="col-lg-3 col-md-6">
                    <h6 class="text-uppercase fw-bold mb-3 text-success">Contacto</h6>
                    <ul class="list-unstyled mb-0 text-white-50 small">
                        <li class="mb-2">
                            <i class="bi bi-geo-alt-fill text-success me-2"></i>
                            IES Gregorio Prieto, Valdepeñas
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-envelope-fill text-success me-2"></i>
                            13003336.ies@educastillalamancha.es
                        </li>
                        <li>
                            <i class="bi bi-telephone-fill text-success me-2"></i>
                            +34 926 32 19 03
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="bg-black py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-white-50 small">
                        © {{ date('Y') }} <span class="text-success fw-semibold">Prieto Eats</span>. Todos los derechos reservados.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                    <p class="mb-0 text-white-50 small">
                        <i class="bi bi-code-slash me-1"></i>
                        Desarrollado por alumnado de <span class="text-success">2º DAW</span> - Curso 2025/26
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer-wave {
        margin-bottom: -5px;
        line-height: 0;
    }

    .footer-wave svg {
        width: 100%;
        height: 60px;
    }

    .footer-link {
        transition: all 0.3s ease;
    }

    .footer-link:hover {
        color: #198754 !important;
        padding-left: 5px;
    }

    footer .btn-outline-light:hover {
        background-color: #198754;
        border-color: #198754;
    }
</style>
