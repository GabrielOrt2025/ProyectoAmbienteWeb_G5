let cart = {
    items: [],
    shipping: 2500, 
    discount: 0,
    promoCode: null
};

const promoCodes = {
    'SAVE10': 10,
    'SAVE20': 20,
    'WELCOME15': 15
};

// Función para formatear números como colones
function formatCurrency(amount) {
    return '₡' + amount.toLocaleString('es-CR', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    });
}

function initCart() {
    const items = document.querySelectorAll('.cart-item');
    items.forEach(item => {
        const id = item.dataset.id;
        const price = parseFloat(item.dataset.price);
        const quantity = parseInt(item.querySelector('.quantity').textContent);
        
        cart.items.push({
            id,
            price,
            quantity,
            element: item
        });
    });
    
    updateCart();
    setupEventListeners();
}

function setupEventListeners() {
    document.querySelectorAll('.increase').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const item = e.target.closest('.cart-item');
            updateQuantity(item, 1);
        });
    });

    document.querySelectorAll('.decrease').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const item = e.target.closest('.cart-item');
            updateQuantity(item, -1);
        });
    });

    document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const item = e.target.closest('.cart-item');
            removeItem(item);
        });
    });

    document.getElementById('shippingSelect').addEventListener('change', (e) => {
        cart.shipping = parseFloat(e.target.value);
        updateCart();
    });

    document.getElementById('promoBtn').addEventListener('click', applyPromoCode);
    document.getElementById('promoInput').addEventListener('keypress', (e) => {
        if (e.key === 'Enter') applyPromoCode();
    });
}

function updateQuantity(itemElement, change) {
    const id = itemElement.dataset.id;
    const cartItem = cart.items.find(item => item.id === id);
    
    if (!cartItem) return;

    cartItem.quantity += change;

    if (cartItem.quantity < 1) {
        removeItem(itemElement);
        return;
    }

    const quantitySpan = itemElement.querySelector('.quantity');
    quantitySpan.textContent = cartItem.quantity;

    const itemPrice = itemElement.querySelector('.item-price');
    itemPrice.textContent = formatCurrency(cartItem.price * cartItem.quantity);

    updateCart();
}

function removeItem(itemElement) {
    const id = itemElement.dataset.id;
    cart.items = cart.items.filter(item => item.id !== id);
    
    itemElement.style.opacity = '0';
    itemElement.style.transform = 'translateX(20px)';
    itemElement.style.transition = 'all 0.3s ease';
    
    setTimeout(() => {
        itemElement.remove();
        updateCart();
        checkEmptyCart();
    }, 300);
}

function checkEmptyCart() {
    if (cart.items.length === 0) {
        const cartItems = document.getElementById('cartItems');
        cartItems.innerHTML = `
            <div class="empty-cart">
                <div class="empty-cart-icon">🛒</div>
                <div class="empty-cart-text">Tu carrito está vacío</div>
                <a href="index.php" class="back-link" style="display: inline-flex; margin-top: 20px;">
                    <span>←</span>
                    Volver a la tienda
                </a>
            </div>
        `;
    }
}

function calculateSubtotal() {
    return cart.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
}

function calculateDiscount(subtotal) {
    return (subtotal * cart.discount) / 100;
}

function calculateTotal() {
    const subtotal = calculateSubtotal();
    const discount = calculateDiscount(subtotal);
    return subtotal + cart.shipping - discount;
}

function applyPromoCode() {
    const input = document.getElementById('promoInput');
    const code = input.value.trim().toUpperCase();
    const message = document.getElementById('promoMessage');

    if (!code) {
        message.style.color = '#ff6b6b';
        message.textContent = 'Por favor ingresa un código';
        return;
    }

    if (promoCodes[code]) {
        cart.discount = promoCodes[code];
        cart.promoCode = code;
        message.style.color = '#51cf66';
        message.textContent = `✓ Código aplicado: ${cart.discount}% de descuento`;
        input.disabled = true;
        document.getElementById('promoBtn').disabled = true;
        updateCart();
    } else {
        message.style.color = '#ff6b6b';
        message.textContent = '✗ Código inválido';
        cart.discount = 0;
        cart.promoCode = null;
    }
}

function updateCart() {
    const itemCount = cart.items.reduce((sum, item) => sum + item.quantity, 0);
    const subtotal = calculateSubtotal();
    const discount = calculateDiscount(subtotal);
    const total = calculateTotal();

    document.getElementById('itemCount').textContent = itemCount;
    document.getElementById('summaryItemCount').textContent = itemCount;

    document.getElementById('subtotal').textContent = formatCurrency(subtotal);

    document.getElementById('totalPrice').textContent = formatCurrency(total);

    if (cart.discount > 0) {
        let discountRow = document.querySelector('.discount-row');
        if (!discountRow) {
            discountRow = document.createElement('div');
            discountRow.className = 'summary-row discount-row';
            discountRow.style.color = '#51cf66';
            document.querySelector('.total-section').insertBefore(
                discountRow,
                document.querySelector('.total-row')
            );
        }
        discountRow.innerHTML = `
            <span class="summary-label">Descuento (${cart.discount}%)</span>
            <span class="summary-value">-${formatCurrency(discount)}</span>
        `;
    }
}

document.addEventListener('DOMContentLoaded', initCart);