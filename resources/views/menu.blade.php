@extends('templates.app')

@section('title', 'Menú de hoy | CoffeeTec')

@section('content')
    <div class="mb-6">
        <span class="inline-block px-3 py-1 rounded-full bg-coffee-gold/10 text-coffee-gold text-xs font-semibold mb-2">MENÚ DE HOY</span>
        <h1 class="text-2xl font-bold mb-1 text-coffee-dark">Pide fácil, come rico</h1>
        <p class="text-coffee-dark/60 mb-0">Selecciona tus alimentos y recoge tu pedido en la cafetería.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="category-filter" class="block text-sm font-medium text-coffee-dark mb-1">Categoría</label>
                    <select id="category-filter" class="block w-full rounded-md border border-coffee-light/50 bg-white py-2 px-3 text-coffee-dark focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none sm:text-sm">
                        <option value="">Todas las categorías</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id_category }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="product-search" class="block text-sm font-medium text-coffee-dark mb-1">Buscar producto o alimento</label>
                    <input id="product-search" type="search" placeholder="Ej. café, sándwich..." autocomplete="off"
                        class="block w-full rounded-md border border-coffee-light/50 bg-white py-2 px-3 text-coffee-dark focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none sm:text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="product-list">
                @forelse (($products ?? collect()) as $product)
                    <div class="product-item group relative"
                        data-category="{{ $product->id_category }}"
                        data-product-name="{{ $product->name }}">
                        <div class="card product-card h-full rounded-lg border border-coffee-light/30 bg-white shadow-sm overflow-hidden flex flex-col">
                            <div class="p-4 flex-1 flex flex-col">
                                <div class="flex justify-between items-start">
                                    <span class="text-3xl line-height-1">☕</span>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-coffee-light text-coffee-dark text-xs font-medium">${{ number_format((float) $product->price, 2) }}</span>
                                </div>
                                <h2 class="mt-3 mb-1 text-lg font-semibold text-coffee-dark group-hover:text-coffee-gold transition-colors">{{ $product->name }}</h2>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-coffee-dark/10 text-coffee-dark text-xs font-semibold mb-3">{{ $product->category->name }}</span>
                                <p class="text-sm text-coffee-dark/60 mb-4 flex-1">{{ $product->description ?? 'Producto de la cafetería escolar.' }}</p>
                                <button class="btn-add-product btn-coffee w-full py-2 rounded-lg font-medium text-sm transition-colors hover:bg-coffee-gold hover:text-white active:scale-95"
                                    data-id="{{ $product->id_product }}"
                                    data-name="{{ $product->name }}"
                                    data-price="{{ $product->price }}">
                                    Agregar al pedido
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="p-6 text-center rounded-lg border border-dashed border-coffee-light/50 bg-coffee-dark/5">
                            <p class="text-coffee-dark/60 text-sm">No hay productos disponibles en este momento.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div id="no-filter-results" class="hidden p-6 text-center rounded-lg border border-coffee-light/50 bg-coffee-dark/5">
                <p class="text-coffee-dark/60 text-sm">No hay productos que coincidan con los filtros seleccionados.</p>
            </div>
        </div>

        <aside class="lg:col-span-4">
            <div class="sticky top-6 rounded-xl border border-coffee-light/30 bg-white shadow-sm">
                <div class="p-4">
                    <h2 class="text-lg font-bold text-coffee-dark mb-3">Tu pedido</h2>
                    <div id="cart-items" class="mb-4 min-h-[80px]">
                        <p class="text-sm text-coffee-dark/50">Aún no has agregado productos.</p>
                    </div>
                    <div class="border-t border-coffee-light/30 pt-3 mb-4 flex justify-between font-bold text-coffee-dark">
                        <span>Total</span>
                        <span id="cart-total">$0.00</span>
                    </div>
                    <form method="POST" action="{{ route('orders.store') }}" id="order-form">
                        @csrf
                        <input type="hidden" name="items" id="items-input">
                        <div class="mb-3">
                            <label for="customer" class="block text-xs font-medium text-coffee-dark mb-1">Nombre</label>
                            <input id="customer" name="customer" type="text" placeholder="Ej. María López" required
                                class="block w-full rounded-md border border-coffee-light/50 bg-white py-2 px-3 text-coffee-dark focus:ring-2 focus:ring-coffee-gold/50 focus:border-coffee-gold outline-none text-sm">
                        </div>
                        <button type="submit" id="submit-order" disabled
                            class="w-full py-2.5 rounded-lg bg-coffee-dark text-white font-medium text-sm disabled:opacity-50 disabled:cursor-not-allowed transition-colors active:scale-[0.98]">
                            Confirmar pedido
                        </button>
                    </form>
                </div>
            </div>
        </aside>
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
