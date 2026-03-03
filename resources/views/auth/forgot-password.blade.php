@extends('layouts.layout')

@section('title', 'Recuperar Contraseña')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-success text-white text-center py-3">
                        <h4 class="mb-0">
                            <i class="bi bi-key-fill me-2"></i>Recuperar Contraseña
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-info border-0 mb-4">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            {{ __('¿Olvidaste tu contraseña? No hay problema. Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.') }}
                        </div>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-success border-0 shadow-sm mb-4">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="bi bi-envelope me-1"></i>{{ __('Email') }}
                                </label>
                                <input type="email"
                                       class="form-control form-control-lg @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required
                                       autofocus
                                       placeholder="tu@email.com">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-send-fill me-2"></i>{{ __('Enviar Enlace de Recuperación') }}
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer bg-light text-center py-3">
                        <a href="{{ route('login') }}" class="text-decoration-none text-success">
                            <i class="bi bi-arrow-left me-1"></i>Volver al inicio de sesión
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
