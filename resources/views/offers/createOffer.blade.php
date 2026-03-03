@extends('layouts.layout')

@section('title', 'Crear Oferta')

@section('content')
    <div class="container py-5">
        <!-- Encabezado -->
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.offers.index') }}" class="text-success text-decoration-none">
                                <i class="bi bi-tags-fill me-1"></i>Ofertas
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Crear Nueva</li>
                    </ol>
                </nav>
                <h1 class="fw-bold text-success mb-0">
                    <i class="bi bi-plus-circle-fill me-2"></i>Crear Nueva Oferta
                </h1>
                <p class="text-muted mt-2">Configura la fecha, hora y selecciona los productos para la oferta</p>
            </div>
        </div>

        <form action="{{ route('admin.offers.store') }}" class="needs-validation" method="POST"
            enctype="multipart/form-data" novalidate>
            @csrf

            <div class="row g-4">
                <!-- Panel de Configuración -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 140px;">
                        <div class="card-header bg-success text-white rounded-top-4 py-3">
                            <h5 class="mb-0">
                                <i class="bi bi-gear-fill me-2"></i>Configuración
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <!-- Fecha -->
                            <div class="mb-4">
                                <label for="date_delivery" class="form-label fw-semibold">
                                    <i class="bi bi-calendar-event me-1 text-success"></i>Fecha de Entrega
                                </label>
                                <input type="date" name="date_delivery" id="date_delivery"
                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                    value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                    class="form-control form-control-lg" required>
                                <div class="invalid-feedback">
                                    Introduce una fecha correcta
                                </div>
                            </div>

                            <!-- Hora -->
                            <div class="mb-4">
                                <label for="time_delivery" class="form-label fw-semibold">
                                    <i class="bi bi-clock me-1 text-success"></i>Horario de Recogida
                                </label>
                                <input type="text" name="time_delivery" id="time_delivery"
                                    class="form-control form-control-lg" value="13:35-14:30"
                                    pattern="^([01]\d|2[0-3]):([0-5]\d)-([01]\d|2[0-3]):([0-5]\d)$" required>
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>Formato: HH:MM-HH:MM
                                </div>
                                <div class="invalid-feedback">
                                    Introduce una hora correcta (Ej: 13:35-14:30)
                                </div>
                            </div>

                            <!-- Resumen de selección -->
                            <div class="bg-success bg-opacity-10 rounded-3 p-3 mb-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-success fw-medium">
                                        <i class="bi bi-check2-square me-1"></i>Seleccionados
                                    </span>
                                    <span id="selectedCount" class="badge bg-success fs-6">0</span>
                                </div>
                            </div>

                            <!-- Botón Submit -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-check-circle-fill me-2"></i>Crear Oferta
                                </button>
                                <a href="{{ route('admin.offers.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Cancelar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panel de Productos -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="mb-0 fw-bold">
                                        <i class="bi bi-box-seam text-success me-2"></i>Seleccionar Productos
                                    </h5>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <span class="input-group-text bg-success text-white border-0">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <input type="text" name="searchProducts" id="searchProducts"
                                            class="form-control border-0 bg-light" placeholder="Buscar productos...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table id="productsTable" class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" style="width: 60px;">
                                                <i class="bi bi-check-all text-success"></i>
                                            </th>
                                            <th style="width: 80px;">Imagen</th>
                                            <th>Producto</th>
                                            <th class="text-end" style="width: 100px;">Precio</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr class="product-row" style="cursor: pointer;">
                                                <td class="text-center">
                                                    <div class="form-check d-flex justify-content-center m-0">
                                                        <input type="checkbox" class="form-check-input product-checkbox"
                                                            name="producto_selected[]" value="{{ $product->id }}"
                                                            id="product-{{ $product->id }}"
                                                            style="width: 1.5em; height: 1.5em;">
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($product->image)
                                                        <img src="{{ asset('storage/' . $product->image) }}"
                                                            alt="{{ $product->name }}" class="rounded-3 shadow-sm"
                                                            style="width: 60px; height: 60px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center"
                                                            style="width: 60px; height: 60px;">
                                                            <i class="bi bi-image text-muted fs-4"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="product-name fw-semibold text-dark">{{ $product->name }}
                                                    </div>
                                                    <div class="product-desc text-muted small">
                                                        {{ Str::limit($product->description, 60) }}</div>
                                                </td>
                                                <td class="text-end">
                                                    <span
                                                        class="badge bg-success bg-opacity-10 text-success fs-6 fw-bold px-3 py-2">
                                                        {{ number_format($product->price, 2) }} €
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if ($products->count() === 0)
                                <div class="text-center py-5">
                                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                        style="width: 80px; height: 80px;">
                                        <i class="bi bi-box-seam text-muted fs-2"></i>
                                    </div>
                                    <h5 class="text-muted">No hay productos disponibles</h5>
                                    <p class="text-muted mb-3">Crea productos antes de añadirlos a una oferta</p>
                                    <a href="{{ route('admin.products.create') }}" class="btn btn-success">
                                        <i class="bi bi-plus-circle me-1"></i>Crear Producto
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <style>
        .rounded-4 {
            border-radius: 1rem !important;
        }

        .rounded-top-4 {
            border-top-left-radius: 1rem !important;
            border-top-right-radius: 1rem !important;
        }

        .product-row:hover {
            background-color: rgba(25, 135, 84, 0.05);
        }

        .product-row.selected {
            background-color: rgba(25, 135, 84, 0.1);
        }

        .product-checkbox:checked {
            background-color: #198754;
            border-color: #198754;
        }
    </style>
@endsection

@section('scripts')
    <script>
        (function() {
            const input = document.getElementById('searchProducts');
            const table = document.getElementById('productsTable');
            const selectedCountEl = document.getElementById('selectedCount');
            if (!input || !table) return;

            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));

            // Guardamos el índice original de cada fila para orden estable dentro de cada grupo
            rows.forEach((tr, idx) => tr.dataset.initialIndex = idx);

            const normalize = s =>
                (s || '')
                .toString()
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '');

            let timer;
            const debounced = (fn, delay = 120) => (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => fn(...args), delay);
            };

            const updateSelectedCount = () => {
                const count = document.querySelectorAll('.product-checkbox:checked').length;
                if (selectedCountEl) {
                    selectedCountEl.textContent = count;
                }
            };

            const updateRowStyles = () => {
                rows.forEach(tr => {
                    const checkbox = tr.querySelector('.product-checkbox');
                    if (checkbox && checkbox.checked) {
                        tr.classList.add('selected');
                    } else {
                        tr.classList.remove('selected');
                    }
                });
            };

            const applyFilterAndSort = () => {
                const q = normalize(input.value.trim());

                // 1) Calcular visibilidad y separar en dos grupos
                const selected = [];
                const unselected = [];

                rows.forEach(tr => {
                    const checkbox = tr.querySelector('input[type="checkbox"]');
                    const isChecked = checkbox && checkbox.checked;

                    const name = normalize(tr.querySelector('.product-name')?.textContent);
                    const desc = normalize(tr.querySelector('.product-desc')?.textContent);
                    const matchesQuery = !q || name.includes(q) || desc.includes(q);

                    // Si está marcado, SIEMPRE visible; si no, depende del filtro
                    const show = isChecked || matchesQuery;
                    tr.style.display = show ? '' : 'none';

                    // Solo consideramos para ordenar las que están visibles
                    if (show) {
                        (isChecked ? selected : unselected).push(tr);
                    }
                });

                // 2) Reordenar: primero seleccionados, luego no seleccionados
                //    Manteniendo orden original dentro de cada grupo (por data-initial-index)
                selected.sort((a, b) => a.dataset.initialIndex - b.dataset.initialIndex);
                unselected.sort((a, b) => a.dataset.initialIndex - b.dataset.initialIndex);

                // 3) Reconstruir el tbody con las visibles ordenadas (las ocultas se quedan en su sitio, pero invisibles)
                const fragment = document.createDocumentFragment();
                selected.forEach(tr => fragment.appendChild(tr));
                unselected.forEach(tr => fragment.appendChild(tr));

                tbody.appendChild(fragment);
                updateSelectedCount();
                updateRowStyles();
            };

            // Click en fila para seleccionar
            rows.forEach(tr => {
                tr.addEventListener('click', (e) => {
                    if (e.target.type !== 'checkbox') {
                        const checkbox = tr.querySelector('.product-checkbox');
                        if (checkbox) {
                            checkbox.checked = !checkbox.checked;
                            applyFilterAndSort();
                        }
                    }
                });
            });

            // Filtrar y reordenar al teclear
            input.addEventListener('input', debounced(applyFilterAndSort, 120));

            // Reaplicar cuando cambie cualquier checkbox (selección/deselección)
            table.addEventListener('change', (e) => {
                if (e.target.matches('input[type="checkbox"]')) applyFilterAndSort();
            });

            // Primera pasada
            applyFilterAndSort();
        })();
    </script>
@endsection
