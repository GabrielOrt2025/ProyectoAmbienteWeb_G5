// Estado del carrito
let cart = {
    items: [],
    shipping: 2500, // Precio en colones
    discount: 0,
    promoCode: null
};

// Códigos de descuento válidos
const promoCodes = {
    'SAVE10': 10,
    'SAVE20': 20,
    'WELCOME15': 15
};

// Inicializar el carrito cuando carga la página
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

// Configurar event listeners
function setupEventListeners() {
    // Botones de incrementar cantidad
    document.querySelectorAll('.increase').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const item = e.target.closest('.cart-item');
            updateQuantity(item, 1);
        });
    });

    // Botones de decrementar cantidad
    document.querySelectorAll('.decrease').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const item = e.target.closest('.cart-item');
            updateQuantity(item, -1);
        });
    });

    // Botones de eliminar
    document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const item = e.target.closest('.cart-item');
            removeItem(item);
        });
    });

    // Selector de envío
    document.getElementById('shippingSelect').addEventListener('change', (e) => {
        cart.shipping = parseFloat(e.target.value);
        updateCart();
    });

    // Aplicar código promocional
    document.getElementById('promoBtn').addEventListener('click', applyPromoCode);
    document.getElementById('promoInput').addEventListener('keypress', (e) => {
        if (e.key === 'Enter') applyPromoCode();
    });
}

// Actualizar cantidad de un producto
function updateQuantity(itemElement, change) {
    const id = itemElement.dataset.id;
    const cartItem = cart.items.find(item => item.id === id);
    
    if (!cartItem) return;

    const newQuantity = cartItem.quantity + change;

    if (newQuantity < 1) {
        removeItem(itemElement);
        return;
    }

    // Actualizar en el servidor
    fetch('api/actualizarCarrito.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            id_carrito: id,
            cantidad: newQuantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            cartItem.quantity = newQuantity;
            
            // Actualizar UI
            const quantitySpan = itemElement.querySelector('.quantity');
            quantitySpan.textContent = newQuantity;

            const itemPrice = itemElement.querySelector('.item-price');
            itemPrice.textContent = `₡${formatNumber(cartItem.price * newQuantity)}`;

            updateCart();
        } else {
            alert('Error al actualizar la cantidad');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al actualizar el carrito');
    });
}

// Eliminar un producto del carrito
function removeItem(itemElement) {
    const id = itemElement.dataset.id;
    
    if (!confirm('¿Deseas eliminar este producto del carrito?')) {
        return;
    }

    // Eliminar del servidor
    fetch('api/eliminarCarrito.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            id_carrito: id
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Eliminar del estado local
            cart.items = cart.items.filter(item => item.id !== id);
            
            // Animación de eliminación
            itemElement.style.opacity = '0';
            itemElement.style.transform = 'translateX(20px)';
            itemElement.style.transition = 'all 0.3s ease';
            
            setTimeout(() => {
                itemElement.remove();
                updateCart();
                checkEmptyCart();
            }, 300);
        } else {
            alert('Error al eliminar el producto');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al eliminar del carrito');
    });
}

// Verificar si el carrito está vacío
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

// Calcular subtotal
function calculateSubtotal() {
    return cart.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
}

// Calcular descuento
function calculateDiscount(subtotal) {
    return (subtotal * cart.discount) / 100;
}

// Calcular total
function calculateTotal() {
    const subtotal = calculateSubtotal();
    const discount = calculateDiscount(subtotal);
    return subtotal + cart.shipping - discount;
}

// Aplicar código promocional
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

// Formatear número con separadores de miles
function formatNumber(num) {
    return num.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// Actualizar todos los valores del carrito
function updateCart() {
    const itemCount = cart.items.reduce((sum, item) => sum + item.quantity, 0);
    const subtotal = calculateSubtotal();
    const discount = calculateDiscount(subtotal);
    const total = calculateTotal();

    // Actualizar contador de items
    document.getElementById('itemCount').textContent = itemCount;
    document.getElementById('summaryItemCount').textContent = itemCount;

    // Actualizar subtotal
    document.getElementById('subtotal').textContent = `₡${formatNumber(subtotal)}`;

    // Actualizar total
    document.getElementById('totalPrice').textContent = `₡${formatNumber(total)}`;

    // Mostrar descuento si existe
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
            <span class="summary-value">-₡${formatNumber(discount)}</span>
        `;
    }
}

// Iniciar cuando cargue el DOM
document.addEventListener('DOMContentLoaded', initCart);