@extends('layouts.layout')

@section('title', 'Ofertas')

@section('content')
    <div class="container py-5">
        <!-- Encabezado con gradiente -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="bg-success bg-gradient rounded-4 p-4 shadow-lg text-white">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                        <div>
                            <h1 class="fw-bold mb-1">
                                <i class="bi bi-tags-fill me-2"></i>Gestión de Ofertas
                            </h1>
                            <p class="mb-0 opacity-75">
                                <i class="bi bi-info-circle me-1"></i>Administra las ofertas del menú del día
                            </p>
                        </div>
                        <a href="{{ route('admin.offers.create') }}" class="btn btn-light btn-lg shadow-sm px-4">
                            <i class="bi bi-plus-circle-fill me-2"></i>Nueva Oferta
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtro por fecha de entrega -->
        <div class="row mb-4">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-3">
                    <label for="filterDate" class="form-label fw-semibold text-muted mb-2">
                        <i class="bi bi-funnel me-1"></i>Filtrar por día de entrega
                    </label>
                    <div class="input-group">
                        <input type="date" id="filterDate" class="form-control rounded-start-pill">
                        <button type="button" id="clearFilter" class="btn btn-outline-secondary rounded-end-pill d-none">
                            <i class="bi bi-x-lg"></i>
                        </button>
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

        @if ($offers->count() > 0)
            <div class="row g-4">
                @foreach ($offers as $offer)
                    <div class="col-12 col-lg-6 offer-card" data-date="{{ $offer->date_delivery->format('Y-m-d') }}">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow">
                            <!-- Card Header con fecha -->
                            <div class="card-header bg-success bg-opacity-10 border-0 py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-success text-white rounded-3 p-3 text-center"
                                            style="min-width: 70px;">
                                            <div class="fs-3 fw-bold lh-1">{{ $offer->date_delivery->format('d') }}</div>
                                            <div class="text-uppercase small">
                                                {{ $offer->date_delivery->translatedFormat('M') }}</div>
                                        </div>
                                        <div>
                                            <h5 class="mb-1 fw-bold text-success">
                                                {{ $offer->date_delivery->translatedFormat('l') }}
                                            </h5>
                                            <span class="badge bg-success bg-opacity-25 text-success">
                                                <i class="bi bi-clock me-1"></i>{{ $offer->time_delivery }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Body con productos -->
                            <div class="card-body">
                                <h6 class="text-muted mb-3">
                                    <i class="bi bi-box-seam me-1"></i>
                                    Productos incluidos ({{ $offer->productsOffer->count() }})
                                </h6>

                                @if ($offer->productsOffer->count() > 0)
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($offer->productsOffer as $item)
                                            <div class="d-flex align-items-center bg-light rounded-pill px-3 py-2">
                                                @if ($item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                                        alt="{{ $item->product->name }}" class="rounded-circle me-2"
                                                        style="width: 28px; height: 28px; object-fit: cover;">
                                                @else
                                                    <i class="bi bi-image text-muted me-2"></i>
                                                @endif
                                                <span class="fw-medium small">{{ $item->product->name }}</span>
                                                <span
                                                    class="badge bg-success ms-2">{{ number_format($item->product->price, 2) }}€</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-muted text-center py-3">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        Sin productos asignados
                                    </div>
                                @endif
                            </div>

                            <!-- Card Footer con acciones -->
                            <div class="card-footer bg-transparent border-0 py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar-plus me-1"></i>
                                        Creada: {{ $offer->created_at->diffForHumans() }}
                                    </small>
                                    <form action="{{ route('admin.offers.destroy', $offer->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta oferta?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                            <i class="bi bi-trash3 me-1"></i>Eliminar
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
                                <i class="bi bi-tags text-success fs-1"></i>
                            </div>
                            <h4 class="text-muted mb-3">No hay ofertas registradas</h4>
                            <p class="text-muted mb-4">Comienza creando tu primera oferta del día</p>
                            <a href="{{ route('admin.offers.create') }}" class="btn btn-success btn-lg px-4 rounded-pill">
                                <i class="bi bi-plus-circle me-2"></i>Crear Primera Oferta
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterDate = document.getElementById('filterDate');
            const clearBtn = document.getElementById('clearFilter');
            const cards = document.querySelectorAll('.offer-card');

            filterDate.addEventListener('input', function() {
                const selected = this.value;
                clearBtn.classList.toggle('d-none', !selected);

                cards.forEach(card => {
                    if (!selected || card.dataset.date === selected) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });

            clearBtn.addEventListener('click', function() {
                filterDate.value = '';
                clearBtn.classList.add('d-none');
                cards.forEach(card => card.style.display = '');
            });
        });
    </script>
@endsection
