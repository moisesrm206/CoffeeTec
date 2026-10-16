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
            <div class="row g-3">
                @forelse (($products ?? collect()) as $product)
                    <div class="col-md-6">
                        <div class="card product-card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <span class="display-6">☕</span>
                                    <span class="badge rounded-pill text-bg-light">${{ number_format((float) $product->price, 2) }}</span>
                                </div>
                                <h2 class="h5 mt-3 mb-1">{{ $product->name }}</h2>
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
                        <div class="mb-3">
                            <label class="form-label small" for="group">Grupo o salón</label>
                            <input class="form-control" id="group" name="group" placeholder="Ej. 3°A" required>
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

@push('scripts')
<script>
    const cart = [];
    const itemsContainer = document.getElementById('cart-items');
    const totalElement = document.getElementById('cart-total');
    const itemsInput = document.getElementById('items-input');
    const submitButton = document.getElementById('submit-order');

    function renderCart() {
        if (!cart.length) {
            itemsContainer.innerHTML = '<p class="text-muted small mb-0">Aún no has agregado productos.</p>';
            totalElement.textContent = '$0.00';
            submitButton.disabled = true;
            itemsInput.value = '';
            return;
        }

        itemsContainer.innerHTML = cart.map((item, index) => `
            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                <div class="small"><strong>${item.name}</strong><br><span class="text-muted">${item.quantity} × $${item.price.toFixed(2)}</span></div>
                <button class="btn btn-sm btn-outline-danger remove-product" data-index="${index}" type="button">×</button>
            </div>
        `).join('');

        const total = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
        totalElement.textContent = `$${total.toFixed(2)}`;
        itemsInput.value = JSON.stringify(cart);
        submitButton.disabled = false;
    }

    document.querySelectorAll('.add-product').forEach((button) => {
        button.addEventListener('click', () => {
            const product = { id: Number(button.dataset.id), name: button.dataset.name, price: Number(button.dataset.price), quantity: 1 };
            const existing = cart.find((item) => item.id === product.id);
            existing ? existing.quantity++ : cart.push(product);
            renderCart();
        });
    });

    itemsContainer.addEventListener('click', (event) => {
        if (event.target.matches('.remove-product')) {
            cart.splice(Number(event.target.dataset.index), 1);
            renderCart();
        }
    });
</script>
@endpush
