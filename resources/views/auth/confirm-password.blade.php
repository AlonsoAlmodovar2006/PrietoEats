@extends('layouts.layout')

@section('title', 'Confirmar Contraseña')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-warning text-dark text-center py-3">
                        <h4 class="mb-0">
                            <i class="bi bi-shield-exclamation me-2"></i>Área Segura
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-warning border-0 mb-4">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            {{ __('Esta es un área segura de la aplicación. Por favor, confirma tu contraseña antes de continuar.') }}
                        </div>

                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <!-- Password -->
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">
                                    <i class="bi bi-lock me-1"></i>{{ __('Contraseña') }}
                                </label>
                                <input type="password"
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

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-warning btn-lg">
                                    <i class="bi bi-check-circle-fill me-2"></i>{{ __('Confirmar') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
