@extends('layouts.layout')

@section('title', 'Mis Reservas')

@section('content')
    <div class="container py-5">
        <!-- Encabezado -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="bg-success bg-gradient rounded-4 p-4 shadow-lg text-white">
                    <h1 class="fw-bold mb-1">
                        <i class="bi bi-calendar-check-fill me-2"></i>Mis Reservas
                    </h1>
                    <p class="mb-0 opacity-75">
                        <i class="bi bi-info-circle me-1"></i>Consulta tus pedidos realizados y fechas de recogida
                    </p>
                </div>
            </div>
        </div>

        @if ($grouped->count() > 0)
            <!-- Filtros -->
            <div class="row mb-4">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 p-3">
                        <label for="filterDate" class="form-label fw-semibold text-muted mb-2">
                            <i class="bi bi-funnel me-1"></i>Filtrar por día de reserva
                        </label>
                        <div class="input-group">
                            <input type="date" id="filterDate" class="form-control rounded-start-pill">
                            <button type="button" id="clearDate" class="btn btn-outline-secondary rounded-end-pill d-none">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Secciones por fecha de reserva -->
            @foreach ($grouped as $date => $entries)
                <div class="date-section mb-5" data-date="{{ $date }}">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success text-white rounded-3 p-3 text-center me-3" style="min-width: 70px;">
                            <div class="fs-3 fw-bold lh-1">{{ \Carbon\Carbon::parse($date)->format('d') }}</div>
                            <div class="text-uppercase small">{{ \Carbon\Carbon::parse($date)->translatedFormat('M') }}</div>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold text-success">
                                Reserva realizada el {{ \Carbon\Carbon::parse($date)->translatedFormat('l j \d\e F \d\e Y') }}
                            </h4>
                            <small class="text-muted">{{ $entries->groupBy('order_id')->count() }} pedido(s)</small>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-success">
                                    <tr class="fs-5">
                                        <th><i class="bi bi-hash me-1"></i>Pedido</th>
                                        <th><i class="bi bi-box-seam me-1"></i>Productos</th>
                                        <th><i class="bi bi-calendar-event me-1"></i>Recogida</th>
                                        <th class="text-center"><i class="bi bi-cart me-1"></i>Cant.</th>
                                        <th class="text-end"><i class="bi bi-currency-euro me-1"></i>Precio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($entries->groupBy('order_id') as $orderId => $orderItems)
                                        @php
                                            $order = $orderItems->first()->order;
                                        @endphp
                                        <tr class="fs-5">
                                            <td class="py-4">
                                                <span class="badge bg-secondary rounded-pill fs-6 px-3">#{{ $order->id }}</span>
                                                <div class="text-muted small mt-1">
                                                    {{ $order->created_at->format('H:i') }}
                                                </div>
                                            </td>
                                            <td class="py-4">
                                                <div class="d-flex flex-column gap-2">
                                                    @foreach ($orderItems as $item)
                                                        <div class="d-flex align-items-center">
                                                            <i class="bi bi-dot text-success fs-3"></i>
                                                            <span class="fw-semibold">{{ $item->productOffer->product->name ?? 'Eliminado' }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="py-4">
                                                <div class="d-flex flex-column gap-2">
                                                    @foreach ($orderItems as $item)
                                                        <div class="d-flex align-items-center">
                                                            <span class="badge bg-success bg-opacity-75 fs-6 fw-normal text-white">
                                                                {{ $item->productOffer->offer->date_delivery->translatedFormat('d M Y') }}
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="text-center py-4">
                                                <div class="d-flex flex-column gap-2 align-items-center">
                                                    @foreach ($orderItems as $item)
                                                        <span class="badge bg-success fs-5 px-3">x{{ $item->quantity }}</span>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="text-end py-4">
                                                <div class="d-flex flex-column gap-2 align-items-end">
                                                        <span>{{ number_format($order->total, 2) }} €</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach

            <div id="noResults" class="alert alert-warning mt-3 d-none">
                <i class="bi bi-exclamation-circle me-2"></i>No se encontraron reservas realizadas en esa fecha.
            </div>

        @else
            <div class="alert alert-success shadow-sm rounded-4 p-4 text-center">
                <div class="display-1 text-success mb-3"><i class="bi bi-cart-x"></i></div>
                <h4 class="alert-heading fw-bold">No tienes reservas activas</h4>
                <p class="mb-0">Cuando realices pedidos de productos con fecha de entrega futura, aparecerán aquí agrupados por el día en que los reservaste.</p>
                <div class="mt-3">
                    <a href="{{ route('home') }}" class="btn btn-success rounded-pill px-4">
                        <i class="bi bi-shop me-2"></i>Ir a la tienda
                    </a>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const filterDate = document.getElementById('filterDate');
                const clearDate = document.getElementById('clearDate');
                const sections = document.querySelectorAll('.date-section');
                const noResults = document.getElementById('noResults');

                function filterOrders() {
                    const selectedDate = filterDate.value;
                    let hasVisible = false;

                    sections.forEach(section => {
                        if (!selectedDate || section.dataset.date === selectedDate) {
                            section.style.display = 'block';
                            hasVisible = true;
                        } else {
                            section.style.display = 'none';
                        }
                    });

                    // Mostrar/Ocultar botón de limpiar
                    if (selectedDate) {
                        clearDate.classList.remove('d-none');
                    } else {
                        clearDate.classList.add('d-none');
                    }

                    // Mensaje de no resultados
                    if (!hasVisible && selectedDate) {
                        noResults.classList.remove('d-none');
                    } else {
                        noResults.classList.add('d-none');
                    }
                }

                filterDate.addEventListener('change', filterOrders);

                clearDate.addEventListener('click', function() {
                    filterDate.value = '';
                    filterOrders();
                });
            });
        </script>
    @endpush
@endsection
