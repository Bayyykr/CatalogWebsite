<?php
// app/views/cart/index.php
$title = 'Shopping Cart - Store';
?>

<section class="cart-section">
    <div class="cart-container">
        <h1>Shopping Cart</h1>
        
        <?php if (empty($cart)): ?>
            <div class="empty-cart">
                <svg width="100" height="100" fill="none" stroke="#ddd" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h2>Your cart is empty</h2>
                <p>Start shopping to add products to your cart</p>
                <a href="<?= BASE_URL ?>catalogue" class="btn-primary">Browse Products</a>
            </div>
        <?php else: ?>
            <div class="cart-content">
                <div class="cart-items">
                    <?php foreach ($cart as $item): ?>
                    <div class="cart-item">
                        <div class="cart-item-image">
                            <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
                        </div>
                        <div class="cart-item-info">
                            <h3><?= htmlspecialchars($item['title']) ?></h3>
                            <p class="cart-item-price">Rp <?= number_format($item['price'], 0, ',', '.') ?></p>
                        </div>
                        <div class="cart-item-quantity">
                            <button class="qty-btn" onclick="updateCartQuantity(<?= $item['id'] ?>, <?= $item['quantity'] - 1 ?>)">−</button>
                            <span><?= $item['quantity'] ?></span>
                            <button class="qty-btn" onclick="updateCartQuantity(<?= $item['id'] ?>, <?= $item['quantity'] + 1 ?>)">+</button>
                        </div>
                        <div class="cart-item-total">
                            <p>Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></p>
                        </div>
                        <button class="cart-item-remove" onclick="removeFromCart(<?= $item['id'] ?>)">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="cart-summary">
                    <h2>Order Summary</h2>
                    <div class="summary-row">
                        <span>Subtotal (<?= count($cart) ?> items)</span>
                        <span>Rp <?= number_format($total, 0, ',', '.') ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>Free</span>
                    </div>
                    <hr>
                    <div class="summary-row summary-total">
                        <span>Total</span>
                        <span>Rp <?= number_format($total, 0, ',', '.') ?></span>
                    </div>
                    <button class="btn-checkout" onclick="openCheckoutModal()">Proceed to Checkout</button>
                    <a href="<?= BASE_URL ?>catalogue" class="btn-continue">Continue Shopping</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Checkout Modal -->
<div id="checkoutModal" class="modal">
    <div class="modal-content" style="max-width: 500px;">
        <span class="modal-close" onclick="closeCheckoutModal()">&times;</span>
        <div class="checkout-modal-body">
            <h2>Checkout Information</h2>
            <p class="modal-subtitle">Please fill in your details to complete the order</p>
            
            <form id="checkoutForm" onsubmit="processCheckout(event)">
                <div class="form-group">
                    <label for="customerName">Full Name *</label>
                    <input type="text" id="customerName" name="customerName" placeholder="Liaa" required>
                </div>
                
                <div class="form-group">
                    <label for="customerPhone">WhatsApp Number *</label>
                    <input type="tel" id="customerPhone" name="customerPhone" placeholder="08123456789" required>
                    <small>Enter your WhatsApp number (without +62)</small>
                </div>
                
                <div class="form-group">
                    <label for="customerAddress">Delivery Address *</label>
                    <textarea id="customerAddress" name="customerAddress" rows="3" placeholder="Jl. Example No. 123, Jakarta" required></textarea>
                    <button type="button" class="btn-location" onclick="getLocation()">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                        Use My Location
                    </button>
                </div>
                
                <div class="form-group">
                    <label for="notes">Additional Notes (Optional)</label>
                    <textarea id="notes" name="notes" rows="2" placeholder="Special instructions..."></textarea>
                </div>
                
                <button type="submit" class="btn-submit-checkout">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    Send Order via WhatsApp
                </button>
            </form>
        </div>
    </div>
</div>

<script>
// Cart totals for WhatsApp
const cartData = <?= json_encode($cart ?? []) ?>;
const cartTotal = <?= $total ?? 0 ?>;
</script>
