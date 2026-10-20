const cart = [];
const itemsContainer = document.getElementById('cart-items');
const totalElement = document.getElementById('cart-total');
const itemsInput = document.getElementById('items-input');
const submitButton = document.getElementById('submit-order');
const categoryFilter = document.getElementById('category-filter');
const productSearch = document.getElementById('product-search');
const productItems = document.querySelectorAll('.product-item');
const noFilterResults = document.getElementById('no-filter-results');

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

function filterProducts() {
    const selectedCategory = categoryFilter.value;
    const searchTerm = productSearch.value.trim().toLocaleLowerCase();
    let visibleProducts = 0;

    productItems.forEach((productItem) => {
        const matchesCategory = !selectedCategory || productItem.dataset.category === selectedCategory;
        const matchesSearch = !searchTerm || productItem.dataset.productName.toLocaleLowerCase().includes(searchTerm);
        const isVisible = matchesCategory && matchesSearch;

        productItem.classList.toggle('d-none', !isVisible);
        visibleProducts += isVisible ? 1 : 0;
    });

    noFilterResults.classList.toggle('d-none', visibleProducts > 0 || productItems.length === 0);
}

categoryFilter.addEventListener('change', filterProducts);
productSearch.addEventListener('input', filterProducts);