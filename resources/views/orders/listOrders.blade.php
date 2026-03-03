@extends('layouts.layout')

@section('title', 'Reservas')

@section('content')
    <div class="container py-5">
        <!-- Encabezado -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="bg-success bg-gradient rounded-4 p-4 shadow-lg text-white">
                    <h1 class="fw-bold mb-1">
                        <i class="bi bi-calendar-check-fill me-2"></i>Listado de Reservas
                    </h1>
                    <p class="mb-0 opacity-75">
                        <i class="bi bi-info-circle me-1"></i>Filtra por fecha de entrega y busca al usuario
                    </p>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($grouped->count() > 0)
            <!-- Filtros -->
            <div class="row mb-4 g-3">
                <div class="col-12 col-md-5 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 p-3">
                        <label for="filterDate" class="form-label fw-semibold text-muted mb-2">
                            <i class="bi bi-funnel me-1"></i>Filtrar por día de entrega
                        </label>
                        <div class="input-group">
                            <input type="date" id="filterDate" class="form-control rounded-start-pill">
                            <button type="button" id="clearDate" class="btn btn-outline-secondary rounded-end-pill d-none">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-5 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 p-3">
                        <label for="searchUser" class="form-label fw-semibold text-muted mb-2">
                            <i class="bi bi-search me-1"></i>Buscar por usuario
                        </label>
                        <input type="text" id="searchUser" class="form-control rounded-pill"
                            placeholder="Nombre o email...">
                    </div>
                </div>
            </div>

            <!-- Secciones por fecha -->
            @foreach ($grouped as $date => $entries)
                <div class="date-section mb-5" data-date="{{ $date }}">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success text-white rounded-3 p-3 text-center me-3" style="min-width: 70px;">
                            <div class="fs-3 fw-bold lh-1">{{ \Carbon\Carbon::parse($date)->format('d') }}</div>
                            <div class="text-uppercase small">{{ \Carbon\Carbon::parse($date)->translatedFormat('M') }}
                            </div>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold text-success">
                                {{ \Carbon\Carbon::parse($date)->translatedFormat('l j \d\e F \d\e Y') }}
                            </h4>
                            <small class="text-muted">{{ count($entries) }} reserva(s)</small>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-success">
                                    <tr class="fs-5">
                                        <th><i class="bi bi-hash me-1"></i>Pedido</th>
                                        <th><i class="bi bi-person me-1"></i>Usuario</th>
                                        <th><i class="bi bi-envelope me-1"></i>Email</th>
                                        <th><i class="bi bi-box-seam me-1"></i>Productos</th>
                                        <th class="text-center"><i class="bi bi-cart me-1"></i>Cant.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($entries->groupBy('order_id') as $orderId => $orderItems)
                                        @php
                                            $order = $orderItems->first()->order;
                                        @endphp
                                        <tr class="order-row fs-5"
                                            data-user="{{ strtolower(($order->user->name ?? '') . ' ' . ($order->user->email ?? '')) }}">
                                            <td class="py-4">
                                                <span
                                                    class="badge bg-secondary rounded-pill fs-6 px-3">#{{ $order->id }}</span>
                                            </td>
                                            <td class="fw-bold py-4 text-success">{{ $order->user->name ?? 'N/A' }}</td>
                                            <td class="text-muted py-4 fs-6">{{ $order->user->email ?? 'N/A' }}</td>
                                            <td class="py-4">
                                                <div class="d-flex flex-column gap-2">
                                                    @foreach ($orderItems as $item)
                                                        <div class="d-flex align-items-center">
                                                            <i class="bi bi-dot text-success fs-3"></i>
                                                            <span
                                                                class="fw-semibold">{{ $item->productOffer->product->name ?? 'Eliminado' }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="text-center py-4">
                                                <div class="d-flex flex-column gap-2 align-items-center">
                                                    @foreach ($orderItems as $item)
                                                        <span
                                                            class="badge bg-success fs-5 px-3">x{{ $item->quantity }}</span>
                                                    @endforeach
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
                <i class="bi bi-exclamation-circle me-2"></i>No se encontraron reservas con esos criterios.
            </div>
        @else
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info d-flex align-items-center shadow-sm" role="alert">
                        <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                        <div>
                            <strong>No hay reservas registradas</strong>
                            <p class="mb-0">Las reservas aparecerán aquí cuando los clientes realicen pedidos.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterDate = document.getElementById('filterDate');
            const clearDate = document.getElementById('clearDate');
            const searchUser = document.getElementById('searchUser');
            const sections = document.querySelectorAll('.date-section');
            const noResults = document.getElementById('noResults');

            function applyFilters() {
                const selectedDate = filterDate ? filterDate.value : '';
                const userQuery = searchUser ? searchUser.value.toLowerCase().trim() : '';
                let totalVisible = 0;

                sections.forEach(section => {
                    const dateMatch = !selectedDate || section.dataset.date === selectedDate;

                    if (!dateMatch) {
                        section.style.display = 'none';
                        return;
                    }

                    section.style.display = '';
                    const rows = section.querySelectorAll('.order-row');
                    let sectionVisible = 0;

                    rows.forEach(row => {
                        const userMatch = !userQuery || row.dataset.user.includes(userQuery);
                        row.style.display = userMatch ? '' : 'none';
                        if (userMatch) sectionVisible++;
                    });

                    // Ocultar la sección entera si no hay filas visibles
                    section.style.display = sectionVisible > 0 ? '' : 'none';
                    totalVisible += sectionVisible;
                });

                if (noResults) {
                    noResults.classList.toggle('d-none', totalVisible > 0);
                }
            }

            if (filterDate) {
                filterDate.addEventListener('change', function() {
                    clearDate.classList.toggle('d-none', !this.value);
                    applyFilters();
                });
            }

            if (clearDate) {
                clearDate.addEventListener('click', function() {
                    filterDate.value = '';
                    clearDate.classList.add('d-none');
                    applyFilters();
                });
            }

            if (searchUser) {
                searchUser.addEventListener('input', applyFilters);
            }
        });
    </script>

    <style>
        .rounded-4 {
            border-radius: 1rem !important;
        }
    </style>
@endsection
