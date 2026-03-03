@extends('layouts.layout')

@section('title', 'Verificar Email')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-info text-white text-center py-3">
                        <h4 class="mb-0">
                            <i class="bi bi-envelope-check-fill me-2"></i>Verificar Email
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-info border-0 mb-4">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            {{ __('¡Gracias por registrarte! Antes de comenzar, ¿podrías verificar tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar? Si no recibiste el correo, con gusto te enviaremos otro.') }}
                        </div>

                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-success border-0 shadow-sm mb-4">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                {{ __('Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionaste durante el registro.') }}
                            </div>
                        @endif

                        <div class="d-flex flex-column flex-sm-row justify-content-between gap-3">
                            <form method="POST" action="{{ route('verification.send') }}" class="flex-grow-1">
                                @csrf
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="bi bi-send-fill me-2"></i>{{ __('Reenviar Email') }}
                                    </button>
                                </div>
                            </form>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-outline-secondary btn-lg">
                                        <i class="bi bi-box-arrow-right me-2"></i>{{ __('Cerrar Sesión') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
