@extends('layouts.layout')

@section('title', 'Login')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-success text-white text-center py-3">
                    <h4 class="mb-0">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                    </h4>
                </div>
                <div class="card-body p-4">
                    <!-- Session Status -->
                    @if (session('status'))
                    <div class="alert alert-success border-0 shadow-sm">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('status') }}
                    </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">
                                <i class="bi bi-envelope me-1"></i>Email
                            </label>
                            <input
                                type="email"
                                class="form-control form-control-lg @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="tu@email.com">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">
                                <i class="bi bi-lock me-1"></i>Contraseña
                            </label>
                            <input
                                type="password"
                                class="form-control form-control-lg @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••">
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- Remember Me -->
                        <div class="form-check mb-4">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="remember"
                                id="remember_me">
                            <label class="form-check-label" for="remember_me">
                                Recuérdame
                            </label>
                        </div>
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Entrar
                            </button>
                        </div>
                        <div class="text-center">
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-decoration-none text-success">
                                <i class="bi bi-key me-1"></i>¿Olvidaste tu contraseña?
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-light text-center py-3">
                    <span class="text-muted">¿No tienes cuenta?</span>
                    <a href="{{ route('register') }}" class="text-decoration-none text-success fw-semibold ms-1">
                        Regístrate aquí
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
