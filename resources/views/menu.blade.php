@extends('templates.app')

@section('title', 'Menú de hoy | CoffeeTec')

@section('content')
    <div class="mb-4">
        <span class="badge text-bg-warning mb-2">MENÚ DE HOY</span>
        <h1 class="display-6 fw-bold mb-1">Pide fácil, come rico</h1>
        <p class="text-muted mb-0">Selecciona tus alimentos y recoge tu pedido en la cafetería.</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="row g-3 mb-4" aria-label="Filtros del menú">
                <div class="col-md-5">
                    <label class="form-label" for="category-filter">Categoría</label>
                    <select class="form-select" id="category-filter">
                        <option value="">Todas las categorías</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id_category }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-7">
                    <label class="form-label" for="product-search">Buscar producto o alimento</label>
                    <input class="form-control" id="product-search" type="search"
                        placeholder="Ej. café, sándwich..." autocomplete="off">
                </div>
            </div>

            <div class="row g-3" id="product-list">
                @forelse (($products ?? collect()) as $product)
                    <div class="col-md-6 product-item"
                        data-category="{{ $product->id_category }}"
                        data-product-name="{{ $product->name }}">
                        <div class="card product-card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <span class="display-6">☕</span>
                                    <span class="badge rounded-pill text-bg-light">${{ number_format((float) $product->price, 2) }}</span>
                                </div>
                                <h2 class="h5 mt-3 mb-1">{{ $product->name }}</h2>
                                <span class="badge text-bg-secondary">{{ $product->category->name }}</span>
                                <p class="text-muted small mb-3">{{ $product->description ?? 'Producto de la cafetería escolar.' }}</p>
                                <button class="btn btn-sm btn-coffee w-100 add-product"
                                    data-id="{{ $product->id_product }}"
                                    data-name="{{ $product->name }}"
                                    data-price="{{ $product->price }}">
                                    Agregar al pedido
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">No hay productos disponibles en este momento.</div>
                    </div>
                @endforelse
            </div>
            <div class="alert alert-info d-none" id="no-filter-results">
                No hay productos que coincidan con los filtros seleccionados.
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 1rem;">
                <div class="card-body">
                    <h2 class="h5 fw-bold">Tu pedido</h2>
                    <div id="cart-items" class="mb-3">
                        <p class="text-muted small mb-0">Aún no has agregado productos.</p>
                    </div>
                    <div class="d-flex justify-content-between border-top pt-3 mb-3 fw-bold">
                        <span>Total</span><span id="cart-total">$0.00</span>
                    </div>
                    <form method="POST" action="{{ route('orders.store') }}" id="order-form">
                        @csrf
                        <input type="hidden" name="items" id="items-input">
                        <div class="mb-2">
                            <label class="form-label small" for="customer">Nombre</label>
                            <input class="form-control" id="customer" name="customer" placeholder="Ej. María López" required>
                        </div>
                        
                        <button class="btn btn-coffee w-100" type="submit" id="submit-order" disabled>
                            Confirmar pedido
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@pushOnce('scripts')
    @if (file_exists(public_path('build/manifest.json')))
        @vite('resources/js/menu.js')
    @else
        <script>
            {!! file_get_contents(resource_path('js/menu.js')) !!}
        </script>
    @endif
@endpushOnce
