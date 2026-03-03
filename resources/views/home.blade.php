@extends('layouts.layout')

@section('title', 'Home')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show m-3 shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container-fluid py-5">
        <div class="container">
            <div class="mb-5 text-center">
                <h1 class="display-4 mb-3 fw-bold text-success">
                    <i class="bi bi-tag-fill me-2"></i>Ofertas Disponibles
                </h1>
            </div>
            <!-- OFERTAS -->
            <ul class="nav nav-pills nav-fill mb-5 shadow-sm bg-white rounded p-2" id="offersTab" role="tablist">
                @foreach ($ofertas as $i => $oferta)
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link rounded-pill mx-1 offer-tab {{ $i === 0 ? 'active' : '' }}"
                            id="oferta-{{ $oferta->id }}-tab" data-bs-toggle="tab"
                            data-bs-target="#oferta-{{ $oferta->id }}" type="button" role="tab"
                            aria-controls="oferta-{{ $oferta->id }}" aria-selected="{{ $i === 0 ? 'true' : 'false' }}">
                            <i
                                class="bi bi-calendar-event me-2"></i>{{ $oferta->date_delivery->translatedFormat('j \d\e F') }}
                        </button>
                    </li>
                @endforeach
            </ul>
            <!-- PRODUCTOS DE LA OFERTA -->
            <div class="tab-content" id="offersTabContent">
                @foreach ($ofertas as $i => $oferta)
                    <div class="tab-pane fade {{ $i === 0 ? 'show active' : '' }}" id="oferta-{{ $oferta->id }}"
                        role="tabpanel" aria-labelledby="oferta-{{ $oferta->id }}-tab" tabindex="0">
                        <div class="row g-4">
                            @foreach ($oferta->productsOffer as $item)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100 shadow border-0 hover-shadow transition rounded-3">
                                        <div class="position-relative overflow-hidden rounded-top">
                                            <img src="{{ asset('storage/' . ($item->product->image ?? 'img/logo.png')) }}"
                                                class="card-img-top" alt="Imagen de {{ $item->product->name }}"
                                                style="aspect-ratio: 16/9; object-fit:fill; transition: transform 0.3s ease;">
                                        </div>
                                        <div class="card-body d-flex flex-column p-4">
                                            <h5 class="card-title text-success fw-bold mb-3">
                                                <i class="bi bi-box-seam me-2"></i>{{ $item->product->name }}
                                            </h5>
                                            <p class="card-text text-muted flex-grow-1 mb-3">
                                                {{ $item->product->description }}
                                            </p>
                                            <div class="mt-auto pt-3 border-top border-2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <span class="text-muted small d-block">Precio</span>
                                                        <span class="h4 mb-0 text-success fw-bold">
                                                            {{ $item->product->price }} €
                                                        </span>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        @auth
                                                            <form action="{{ route('cart.add', $item->id) }}"
                                                                method="post">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-success text-white shadow-sm px-4 py-2">
                                                                    <i class="bi bi-cart-plus me-2"></i>Reservar
                                                                </button>
                                                            </form>
                                                        @else
                                                            <div class="badge bg-danger text-white px-3 py-2">
                                                                <i class="bi bi-lock-fill me-1"></i>Inicia sesión para reservar
                                                            </div>
                                                        @endauth
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    .nav-link.offer-tab {
        background-color: white !important;
        color: #198754 !important;
        border: 2px solid #198754;
        transition: all 0.3s ease;
    }
    .nav-link.offer-tab.active {
        background-color: #198754 !important;
        color: white !important;
        border-color: #198754;
    }
    .nav-link.offer-tab:not(.active):hover {
        background-color: #f0f0f0 !important;
    }
</style>
@endsection
