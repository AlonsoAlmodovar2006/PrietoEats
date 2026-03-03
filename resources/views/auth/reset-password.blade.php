@extends('layouts.layout')

@section('title', 'Restablecer Contraseña')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-success text-white text-center py-3">
                        <h4 class="mb-0">
                            <i class="bi bi-shield-lock-fill me-2"></i>Restablecer Contraseña
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf

                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="bi bi-envelope me-1"></i>{{ __('Email') }}
                                </label>
                                <input type="email"
                                       class="form-control form-control-lg @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', $request->email) }}"
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
                                    <i class="bi bi-lock me-1"></i>{{ __('Nueva Contraseña') }}
                                </label>
                                <input type="password"
                                       class="form-control form-control-lg @error('password') is-invalid @enderror"
                                       id="password"
                                       name="password"
                                       required
                                       autocomplete="new-password"
                                       placeholder="••••••••">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label fw-semibold">
                                    <i class="bi bi-lock-fill me-1"></i>{{ __('Confirmar Contraseña') }}
                                </label>
                                <input type="password"
                                       class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       required
                                       autocomplete="new-password"
                                       placeholder="••••••••">
                                @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-check-circle-fill me-2"></i>{{ __('Restablecer Contraseña') }}
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
