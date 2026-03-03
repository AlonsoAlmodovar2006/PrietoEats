@extends('layouts.layout')

@section('title', 'Productos')

@section('content')
    <div class="container py-5">
        <!-- Encabezado con gradiente -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="bg-success bg-gradient rounded-4 p-4 shadow-lg text-white">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                        <div>
                            <h1 class="fw-bold mb-1">
                                <i class="bi bi-box-seam-fill me-2"></i>Gestión de Productos
                            </h1>
                            <p class="mb-0 opacity-75">
                                <i class="bi bi-info-circle me-1"></i>Administra el catálogo de productos disponibles
                            </p>
                        </div>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-light btn-lg shadow-sm px-4">
                            <i class="bi bi-plus-circle-fill me-2"></i>Nuevo Producto
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                    <div>
                        <strong>¡Éxito!</strong> {{ session('success') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($products->count() > 0)
            <!-- Barra de búsqueda -->
            <div class="row mb-4">
                <div class="col-md-6 col-lg-4">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-success text-white border-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" id="searchProducts" class="form-control border-0 bg-light"
                            placeholder="Buscar productos...">
                    </div>
                </div>
                <div class="col-md-6 col-lg-8 text-md-end mt-3 mt-md-0">
                    <span class="badge bg-success bg-opacity-10 text-success fs-6 px-3 py-2">
                        <i class="bi bi-box me-1"></i>
                        <span id="productCount">{{ $products->count() }}</span> productos
                    </span>
                </div>
            </div>

            <!-- Grid de productos -->
            <div class="row g-4" id="productsGrid">
                @foreach ($products as $product)
                    <div class="col-sm-6 col-lg-4 col-xl-3 product-card">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow">
                            <!-- Imagen del producto -->
                            <div class="position-relative">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="card-img-top" style="height: 180px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center"
                                        style="height: 180px;">
                                        <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                                    </div>
                                @endif
                                <!-- Badge de precio -->
                                <span class="position-absolute top-0 end-0 m-2 badge bg-success fs-6 px-3 py-2 shadow">
                                    {{ number_format($product->price, 2) }} €
                                </span>
                            </div>

                            <!-- Contenido -->
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold text-success mb-2 product-name">
                                    {{ $product->name }}
                                </h5>
                                <p class="card-text text-muted small flex-grow-1 product-desc">
                                    {{ Str::limit($product->description, 80) }}
                                </p>
                            </div>

                            <!-- Footer con acciones -->
                            <div class="card-footer bg-transparent border-0 pt-0 pb-3 px-3">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                        class="btn btn-outline-warning flex-grow-1 rounded-pill">
                                        <i class="bi bi-pencil-fill me-1"></i>Editar
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger rounded-pill px-3">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4 text-center py-5">
                        <div class="card-body">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                style="width: 100px; height: 100px;">
                                <i class="bi bi-box-seam text-success fs-1"></i>
                            </div>
                            <h4 class="text-muted mb-3">No hay productos registrados</h4>
                            <p class="text-muted mb-4">Comienza creando tu primer producto</p>
                            <a href="{{ route('admin.products.create') }}"
                                class="btn btn-success btn-lg px-4 rounded-pill">
                                <i class="bi bi-plus-circle me-2"></i>Crear Primer Producto
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        .hover-shadow {
            transition: all 0.3s ease;
        }

        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important;
        }

        .rounded-4 {
            border-radius: 1rem !important;
        }
    </style>

    @if ($products->count() > 0)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchProducts');
                const productCards = document.querySelectorAll('.product-card');
                const productCount = document.getElementById('productCount');

                const normalize = s => (s || '').toString().toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g,
                    '');

                searchInput.addEventListener('input', function() {
                    const query = normalize(this.value.trim());
                    let visibleCount = 0;

                    productCards.forEach(card => {
                        const name = normalize(card.querySelector('.product-name')?.textContent);
                        const desc = normalize(card.querySelector('.product-desc')?.textContent);
                        const matches = !query || name.includes(query) || desc.includes(query);

                        card.style.display = matches ? '' : 'none';
                        if (matches) visibleCount++;
                    });

                    productCount.textContent = visibleCount;
                });
            });
        </script>
    @endif
@endsection
