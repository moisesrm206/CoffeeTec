const cart = [];
const itemsContainer = document.getElementById('cart-items');
const totalElement = document.getElementById('cart-total');
const itemsInput = document.getElementById('items-input');
const submitButton = document.getElementById('submit-order');
const categoryFilter = document.getElementById('category-filter');
const productSearch = document.getElementById('product-search');
const productItems = document.querySelectorAll('.product-item');
const addButtons = document.querySelectorAll('.btn-add-product');
const noFilterResults = document.getElementById('no-filter-results');

function findCartItem(productId) {
    return cart.find((item) => item.id === productId);
}

function updateAddButtons() {
    addButtons.forEach((button) => {
        const quantity = findCartItem(Number(button.dataset.id))?.quantity ?? 0;
        const reachedLimit = quantity >= Number(button.dataset.stock);

        button.disabled = reachedLimit;
        button.textContent = reachedLimit ? 'Máximo disponible' : 'Agregar al pedido';
    });
}

function renderCart() {
    updateAddButtons();

    if (!cart.length) {
        itemsContainer.innerHTML = '<p class="text-coffee-dark/50 text-sm">Aún no has agregado productos.</p>';
        totalElement.textContent = '$0.00';
        submitButton.disabled = true;
        itemsInput.value = '';
        return;
    }

    itemsContainer.innerHTML = cart.map((item, index) => `
            <div class="flex justify-between items-center border-b border-coffee-light/10 py-2">
                <div class="text-sm"><strong>${item.name}</strong><br><span class="text-coffee-dark/60 text-xs">${item.quantity} × $${item.price.toFixed(2)}</span></div>
                <button class="text-coffee-gold hover:text-coffee-dark hover:underline text-sm font-medium remove-product" data-index="${index}" type="button">×</button>
            </div>
        `).join('');

    const total = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
    totalElement.textContent = `$${total.toFixed(2)}`;
    itemsInput.value = JSON.stringify(cart);
    submitButton.disabled = false;
}

addButtons.forEach((button) => {
    button.addEventListener('click', () => {
        const productId = Number(button.dataset.id);
        const stock = Number(button.dataset.stock);
        const existing = findCartItem(productId);

        if (existing) {
            if (existing.quantity >= stock) {
                return;
            }

            existing.quantity++;
        } else {
            cart.push({
                id: productId,
                name: button.dataset.name,
                price: Number(button.dataset.price),
                quantity: 1,
            });
        }

        renderCart();
    });
});

itemsContainer.addEventListener('click', (event) => {
    if (event.target.matches('.remove-product')) {
        cart.splice(Number(event.target.dataset.index), 1);
        renderCart();
    }
});

function filterProducts() {
    const selectedCategory = categoryFilter.value;
    const searchTerm = productSearch.value.trim().toLocaleLowerCase();
    let visibleProducts = 0;

    productItems.forEach((productItem) => {
        const matchesCategory = !selectedCategory || productItem.dataset.category === selectedCategory;
        const matchesSearch = !searchTerm || productItem.dataset.productName.toLocaleLowerCase().includes(searchTerm);
        const isVisible = matchesCategory && matchesSearch;

        productItem.classList.toggle('hidden', !isVisible);
        visibleProducts += isVisible ? 1 : 0;
    });

    noFilterResults.classList.toggle('hidden', visibleProducts > 0 || productItems.length === 0);
}

categoryFilter.addEventListener('change', filterProducts);
productSearch.addEventListener('input', filterProducts);
