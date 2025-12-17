<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LA VACA | Checkout </title>
    <link rel="stylesheet" href="css/checkout.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <header>
        <div class="brand">LA VACA</div>
        <div class="header-links">
            <a href="index.php">Inicio</a>
            <a href="categorias.php">Categorias</a>
            <a href="login.php">Login</a>
            <a href="carrito.php"><i class="bi bi-cart-fill"></i></a>
        </div>
  </header>

    <div class="checkout-container">
        <!-- Left Section: Checkout Form -->
        <div class="checkout-section">
            <div class="page-title">
                <a href="carrito.php" class="back-arrow">←</a>
                Checkout
            </div>

            <!-- 1. Contact Information -->
            <div class="section-title">1. Contact information</div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">First Name</label>
                    <input type="text" class="form-control" value="Eduard" placeholder="First name">
                </div>
                <div class="form-group">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control" value="Franz" placeholder="Last name">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <div class="phone-input-wrapper">
                        <select class="country-select">
                            <option>🇺🇸 +380</option>
                            <option>🇪🇸 +34</option>
                            <option>🇲🇽 +52</option>
                        </select>
                        <input type="tel" class="form-control phone-input" value="555-0115" placeholder="Phone number">
                    </div>
                </div>
                <div class="form-group" style="position: relative;">
                    <label class="form-label">E-mail</label>
                    <input type="email" class="form-control" value="Dinarys@gmail.com" placeholder="Email address">
                    <span class="verified-icon">✓</span>
                </div>
            </div>

            <!-- 2. Delivery Method -->
            <div class="section-title" style="margin-top: 35px;">2. Delivery method</div>
            
            <div class="delivery-options">
                <div class="delivery-option">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18 6h-2c0-2.21-1.79-4-4-4S8 3.79 8 6H6c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-6-2c1.1 0 2 .9 2 2h-4c0-1.1.9-2 2-2zm6 16H6V8h12v12z"/>
                    </svg>
                    Store
                </div>
                <div class="delivery-option active">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18 18.5c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5-1.5.67-1.5 1.5.67 1.5 1.5 1.5zm1.5-9H17V12h4.46L19.5 9.5zM6 18.5c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5-1.5.67-1.5 1.5.67 1.5 1.5 1.5zM20 8l3 4v5h-2c0 1.66-1.34 3-3 3s-3-1.34-3-3H9c0 1.66-1.34 3-3 3s-3-1.34-3-3H1V6c0-1.1.9-2 2-2h14v4h3zM3 6v9h.76c.55-.61 1.35-1 2.24-1 .89 0 1.69.39 2.24 1H15V6H3z"/>
                    </svg>
                    Delivery
                </div>
            </div>

            <div class="date-time-row">
                <div class="form-group input-with-icon">
                    <label class="form-label">Delivery Date</label>
                    <input type="text" class="form-control" value="November 26th, 2021" placeholder="Select date">
                    <span class="input-icon">📅</span>
                </div>
                <div class="form-group input-with-icon">
                    <label class="form-label">Convenient Time</label>
                    <input type="text" class="form-control" value="1 pm - 6 pm" placeholder="Select time">
                    <span class="input-icon">🕐</span>
                </div>
            </div>

            <div class="address-row">
                <div class="form-group">
                    <label class="form-label">City</label>
                    <select class="form-select">
                        <option>New Jersey</option>
                        <option>New York</option>
                        <option>Los Angeles</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Address</label>
                    <input type="text" class="form-control" value="2464 Royal Ln. Mesa" placeholder="Street address">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">ZIP Code</label>
                <input type="text" class="form-control" value="454631" placeholder="ZIP Code" style="max-width: 200px;">
            </div>

            <!-- 3. Payment Method -->
            <div class="section-title" style="margin-top: 35px;">3. Payment method</div>
            
            <div class="payment-methods">
                <div class="payment-method">
                    <svg width="40" height="30" viewBox="0 0 40 30">
                        <circle cx="15" cy="15" r="10" fill="#eb001b"/>
                        <circle cx="25" cy="15" r="10" fill="#f79e1b"/>
                    </svg>
                </div>
                <div class="payment-method active">
                    <svg width="50" height="20" viewBox="0 0 50 20" fill="#1434cb">
                        <text x="5" y="15" font-family="Arial" font-weight="bold" font-size="16">VISA</text>
                    </svg>
                </div>
                <div class="payment-method">
                    <svg width="50" height="20" viewBox="0 0 50 20">
                        <text x="2" y="15" font-family="Arial" font-weight="bold" font-size="12">Apple Pay</text>
                    </svg>
                </div>
                <div class="payment-method">
                    <span style="font-size: 12px; font-weight: 500; color: #666;">OTHER</span>
                </div>
            </div>
        </div>

        <!-- Right Section: Order Summary -->
        <div class="order-summary">
            <div class="order-title">Order</div>

            <div class="order-item">
                <div class="item-image">
                    <svg width="50" height="60" viewBox="0 0 50 60" fill="none">
                        <rect width="50" height="60" rx="5" fill="#dc143c"/>
                        <path d="M15 20h20v25H15z" fill="#b01030"/>
                        <text x="25" y="32" text-anchor="middle" fill="white" font-size="8" font-weight="bold">NIKE</text>
                    </svg>
                </div>
                <button class="remove-item">×</button>
                <div class="item-details">
                    <div class="item-name">Nike Sportswear Men's T-Shirt</div>
                    <div class="item-specs">SIZE: XL • COLOR: Red</div>
                    <div class="item-price">
                        <span class="original-price">$139</span>
                        <span class="current-price">$69</span>
                    </div>
                </div>
            </div>

            <div class="price-breakdown">
                <div class="price-row">
                    <span>SUBTOTAL</span>
                    <span>$139</span>
                </div>
                <div class="price-row discount">
                    <span>DISCOUNT (50% OFF)</span>
                    <span>-$70</span>
                </div>
                <div class="price-row">
                    <span>SHIPPING</span>
                    <span>Free</span>
                </div>
                <div class="price-row total">
                    <span>TOTAL</span>
                    <span>$69</span>
                </div>
            </div>

            <a href="checkout.php" class="checkout-btn">
                r a la Página de Destino
            </a>

            <div class="terms-checkbox">
                <input type="checkbox" id="terms" checked>
                <label for="terms">
                    by confirming the order, I accept the <a href="#">terms of the user</a> agreement
                </label>
            </div>
        </div>
    </div>

    <footer>
        <p>2025 LA VACA</p>
    </footer>
</body>
</html>