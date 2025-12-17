<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'dao/CarritoDaoImpl.php';

$carritoDao = new CarritoDaoImpl();
$items = $carritoDao->obtenerCarritoCompleto($_SESSION['usuario_id']);

// Convertir precios a colones (multiplicar por 1000 si estaban en otra moneda)
foreach ($items as &$item) {
    $item['precio_unitario'] = $item['precio_unitario'] * 1000;
    $item['subtotal'] = $item['cantidad'] * $item['precio_unitario'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/carrito.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <title>LA VACA | Carrito</title>
</head>
<body>
    <header>
        <div class="brand">LA VACA</div>
        <div class="header-links">
            <a href="index.php">Inicio</a>
            <a href="categorias.php">Categorias</a>
            <a href="#">Hola, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></a>
            <a href="carrito.php"><i class="bi bi-cart-fill"></i></a>
        </div>
    </header>
    
    <div class="container">
        <div class="cart-section">
            <h1>Shopping Cart</h1>
            <div class="items-count"><span id="itemCount"><?php echo count($items); ?></span> Items</div>

            <div id="cartItems">
                <?php if (empty($items)): ?>
                    <div class="empty-cart">
                        <div class="empty-cart-icon">🛒</div>
                        <div class="empty-cart-text">Tu carrito está vacío</div>
                        <a href="index.php" class="back-link" style="display: inline-flex; margin-top: 20px;">
                            <span>←</span>
                            Volver a la tienda
                        </a>
                    </div>
                <?php else: ?>
                    <?php foreach ($items as $item): ?>
                    <div class="cart-item" data-id="<?php echo $item['id_carrito']; ?>" data-price="<?php echo $item['precio_unitario']; ?>">
                        <div class="item-image">
                            <img src="<?php echo htmlspecialchars($item['imagen']); ?>" alt="<?php echo htmlspecialchars($item['nombre']); ?>">
                        </div>
                        <div class="item-details">
                            <div class="item-label">Producto</div>
                            <div class="item-name"><?php echo htmlspecialchars($item['nombre']); ?></div>
                        </div>
                        <div class="quantity-controls">
                            <button class="quantity-btn decrease">−</button>
                            <span class="quantity"><?php echo $item['cantidad']; ?></span>
                            <button class="quantity-btn increase">+</button>
                        </div>
                        <div class="item-price">₡<?php echo number_format($item['subtotal'], 0, ',', '.'); ?></div>
                        <button class="remove-btn">×</button>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <a href="index.php" class="back-link">
                <span>←</span>
                Back to shop
            </a>
        </div>

        <div class="summary-section">
            <h2>Summary</h2>
            
            <div class="summary-row">
                <span class="summary-label">Items <span id="summaryItemCount"><?php echo count($items); ?></span></span>
                <span class="summary-value" id="subtotal">₡0</span>
            </div>

            <div class="shipping-section">
                <div class="summary-label" style="margin-bottom: 15px;">SHIPPING</div>
                <select class="shipping-select" id="shippingSelect">
                    <option value="2500">Standard Delivery - ₡2.500</option>
                    <option value="3000">Express Delivery - ₡3.000</option>
                    <option value="3500">Next Day Delivery - ₡3.500</option>
                </select>
            </div>

            <div class="promo-section">
                <div class="summary-label" style="margin-bottom: 15px;">GIVE CODE</div>
                <div class="promo-input-wrapper">
                    <input type="text" class="promo-input" id="promoInput" placeholder="Enter your code">
                    <button class="promo-btn" id="promoBtn">→</button>
                </div>
                <div id="promoMessage" style="margin-top: 10px; font-size: 12px;"></div>
            </div>

            <div class="total-section">
                <div class="total-row">
                    <span>TOTAL PRICE</span>
                    <span id="totalPrice">₡0</span>
                </div>
            </div>

            <button class="checkout-btn" id="checkoutBtn" onclick="window.location.href='checkout.php'">CHECKOUT</button>
        </div>
    </div>
    
    <script src="js/carrito.js"></script>
</body>
</html>