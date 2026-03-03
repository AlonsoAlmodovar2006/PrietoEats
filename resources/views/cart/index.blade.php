@extends('layouts.layout')

@section('title', 'Carrito')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4 fw-bold text-success">
                    <i class="bi bi-cart3"></i> Tu Carrito
                </h1>
            </div>
        </div>

        @php
            $precioTotal = 0;
        @endphp

        @if (count($cart) > 0)
            @foreach ($cart as $offerId => $items)
                @php
                    $offer = $offersById[$offerId] ?? null;
                @endphp
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-success bg-opacity-10 border-0 py-3">
                        <h5 class="mb-0 fw-bold text-success">
                            <i class="bi bi-calendar-event me-2"></i>
                            @if ($offer)
                                Oferta del {{ $offer->date_delivery->translatedFormat('j \d\e F \d\e Y') }}
                                <span class="badge bg-success bg-opacity-25 text-success ms-2">
                                    <i class="bi bi-clock me-1"></i>{{ $offer->time_delivery }}
                                </span>
                            @else
                                Oferta #{{ $offerId }}
                            @endif
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-center mb-0">
                                <thead class="table-success">
                                    <tr>
                                        <th scope="col">Imagen</th>
                                        <th scope="col">Producto</th>
                                        <th scope="col">Precio Unitario</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $productOfferId => $item)
                                        @php
                                            $po = $productOffersById[$productOfferId] ?? null;
                                            $product = $po?->product;
                                            $subtotal = $item['price'] * $item['quantity'];
                                            $precioTotal += $subtotal;
                                        @endphp
                                        <tr>
                                            <td>
                                                <img src="{{ asset('storage/' . ($product->image ?? 'img/logo.png')) }}"
                                                    alt="Producto" class="img-fluid rounded" style="max-width: 200px;">
                                            </td>
                                            <td class="fw-semibold">
                                                {{ $product->name ?? 'Producto no disponible' }}
                                            </td>
                                            <td class="fw-bold text-success">
                                                {{ $item['price'] }} €
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center gap-2">
                                                    <form action="{{ route('cart.decrease', $productOfferId) }}" method="POST" class="m-0">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary"
                                                            {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                                            <i class="bi bi-dash-circle"></i>
                                                        </button>
                                                    </form>
                                                    <span class="badge bg-primary fs-6">
                                                        {{ $item['quantity'] }}
                                                    </span>
                                                    <form action="{{ route('cart.increase', $productOfferId) }}" method="POST" class="m-0">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-sm btn-outline-success">
                                                            <i class="bi bi-plus-circle"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="fw-bold text-success">
                                                {{ $subtotal }} €
                                            </td>
                                            <td>
                                                <form action="{{ route('cart.remove', $productOfferId) }}" method="POST" class="m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash"></i> Eliminar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="row mb-4">
                <div class="col-12 col-md-8">
                    <form action="{{ route('cart.clear') }}" method="POST" class="d-inline-block me-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-warning btn-lg">
                            <i class="bi bi-trash3"></i> Vaciar Carrito
                        </button>
                    </form>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card bg-light border-success shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title text-success mb-3">Resumen del Pedido</h5>
                            <h3 class="fw-bold text-success mb-3">{{ $precioTotal }} €</h3>
                            <form action="{{ route('cart.order') }}" method="POST" class="w-100">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-success btn-lg w-100">
                                    <i class="bi bi-check-circle"></i> Reservar Ahora
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="bi bi-info-circle me-3 fs-4"></i>
                        <div>
                            <strong>Tu carrito está vacío</strong>
                            <p class="mb-0">Agrega productos para realizar una reserva.</p>
                        </div>
                    </div>
                    <a href="{{ route('home') }}" class="btn btn-success btn-lg">
                        <i class="bi bi-arrow-left"></i> Continuar comprando
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection
