@extends('layouts.layout')

@section('title', 'Editar Producto')

@section('content')
    <div class="container py-5">
        <!-- Encabezado -->
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.products.index') }}" class="text-success text-decoration-none">
                                <i class="bi bi-box-seam-fill me-1"></i>Productos
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Editar: {{ $product->name }}</li>
                    </ol>
                </nav>
                <h1 class="fw-bold text-success mb-0">
                    <i class="bi bi-pencil-square me-2"></i>Editar Producto
                </h1>
                <p class="text-muted mt-2">Modifica los datos del producto #{{ $product->id }}</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Formulario -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-warning bg-opacity-75 text-dark rounded-top-4 py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-pencil-fill me-2"></i>Información del Producto
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.products.update', $product->id) }}" class="needs-validation"
                            method="POST" enctype="multipart/form-data" novalidate id="productForm">
                            @csrf
                            @method('PUT')

                            <!-- Nombre -->
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="bi bi-type me-1 text-warning"></i>Nombre del Producto
                                </label>
                                <input type="text" name="name" id="name"
                                       class="form-control form-control-lg"
                                       value="{{ $product->name }}"
                                       required>
                                <div class="invalid-feedback">
                                    Introduce un nombre para el producto
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div class="mb-4">
                                <label for="description" class="form-label fw-semibold">
                                    <i class="bi bi-text-paragraph me-1 text-warning"></i>Descripción
                                </label>
                                <textarea name="description" id="description"
                                          class="form-control"
                                          rows="4"
                                          required>{{ $product->description }}</textarea>
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>Máximo 255 caracteres
                                </div>
                                <div class="invalid-feedback">
                                    Introduce una descripción
                                </div>
                            </div>

                            <!-- Precio -->
                            <div class="mb-4">
                                <label for="price" class="form-label fw-semibold">
                                    <i class="bi bi-currency-euro me-1 text-warning"></i>Precio
                                </label>
                                <div class="input-group input-group-lg">
                                    <input type="number" name="price" id="price"
                                           class="form-control"
                                           min="0" step="0.01"
                                           value="{{ $product->price }}"
                                           required>
                                    <span class="input-group-text bg-warning text-dark">€</span>
                                </div>
                                <div class="invalid-feedback">
                                    Introduce un precio válido
                                </div>
                            </div>

                            <!-- Imagen actual -->
                            @if ($product->image)
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-image-fill me-1 text-warning"></i>Imagen Actual
                                    </label>
                                    <div class="border rounded-3 p-3 bg-light">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                 alt="{{ $product->name }}"
                                                 class="rounded-3 shadow-sm"
                                                 style="width: 100px; height: 100px; object-fit: cover;">
                                            <div>
                                                <p class="mb-1 fw-medium">{{ basename($product->image) }}</p>
                                                <small class="text-muted">Imagen guardada actualmente</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Nueva imagen -->
                            <div class="mb-4">
                                <label for="image" class="form-label fw-semibold">
                                    <i class="bi bi-upload me-1 text-warning"></i>
                                    {{ $product->image ? 'Cambiar Imagen (opcional)' : 'Añadir Imagen' }}
                                </label>
                                <div class="input-group">
                                    <input type="file" name="image" id="image"
                                           class="form-control form-control-lg"
                                           accept=".jpg, .jpeg, .png">
                                </div>
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    {{ $product->image ? 'Sube una nueva imagen solo si deseas reemplazar la actual.' : 'Formatos: JPG, JPEG, PNG. Máximo 2MB.' }}
                                </div>
                            </div>

                            <!-- Botones (visible en móvil) -->
                            <div class="d-lg-none d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-warning btn-lg">
                                    <i class="bi bi-check-circle-fill me-2"></i>Guardar Cambios
                                </button>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Panel lateral -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 140px;">
                    <div class="card-header bg-light border-0 rounded-top-4 py-3">
                        <h6 class="mb-0 fw-bold">
                            <i class="bi bi-eye me-2 text-warning"></i>Vista Previa
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        <!-- Preview del producto -->
                        <div class="border rounded-3 overflow-hidden">
                            <div id="imagePreview" style="height: 150px;">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         class="w-100 h-100"
                                         style="object-fit: cover;"
                                         id="currentImage">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                        <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-3">
                                <h6 class="fw-bold text-warning mb-1" id="namePreview">{{ $product->name }}</h6>
                                <p class="text-muted small mb-2" id="descPreview">{{ Str::limit($product->description, 100) }}</p>
                                <span class="badge bg-warning text-dark fs-6" id="pricePreview">{{ number_format($product->price, 2) }} €</span>
                            </div>
                        </div>

                        <!-- Info adicional -->
                        <div class="mt-3 p-3 bg-light rounded-3">
                            <small class="text-muted d-block mb-1">
                                <i class="bi bi-hash me-1"></i>ID: {{ $product->id }}
                            </small>
                            <small class="text-muted d-block mb-1">
                                <i class="bi bi-calendar-plus me-1"></i>Creado: {{ $product->created_at->format('d/m/Y') }}
                            </small>
                            <small class="text-muted d-block">
                                <i class="bi bi-calendar-check me-1"></i>Actualizado: {{ $product->updated_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3 d-none d-lg-block">
                        <div class="d-grid gap-2">
                            <button type="submit" form="productForm" class="btn btn-warning btn-lg">
                                <i class="bi bi-check-circle-fill me-2"></i>Guardar Cambios
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .rounded-4 {
            border-radius: 1rem !important;
        }
        .rounded-top-4 {
            border-top-left-radius: 1rem !important;
            border-top-right-radius: 1rem !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const descInput = document.getElementById('description');
            const priceInput = document.getElementById('price');
            const imageInput = document.getElementById('image');

            const namePreview = document.getElementById('namePreview');
            const descPreview = document.getElementById('descPreview');
            const pricePreview = document.getElementById('pricePreview');
            const imagePreview = document.getElementById('imagePreview');

            // Actualizar nombre
            nameInput.addEventListener('input', function() {
                namePreview.textContent = this.value || 'Nombre del producto';
            });

            // Actualizar descripción
            descInput.addEventListener('input', function() {
                const text = this.value || 'Descripción del producto...';
                descPreview.textContent = text.length > 100 ? text.substring(0, 100) + '...' : text;
            });

            // Actualizar precio
            priceInput.addEventListener('input', function() {
                const price = parseFloat(this.value) || 0;
                pricePreview.textContent = price.toFixed(2) + ' €';
            });

            // Actualizar imagen
            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.innerHTML = '<img src="' + e.target.result + '" class="w-100 h-100" style="object-fit: cover;">';
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
@endsection
