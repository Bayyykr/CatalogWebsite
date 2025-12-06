// js/checkout.js - Checkout and WhatsApp Integration

// Open checkout modal
function openCheckoutModal() {
    document.getElementById('checkoutModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

// Close checkout modal
function closeCheckoutModal() {
    document.getElementById('checkoutModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Get user location
function getLocation() {
    const addressField = document.getElementById('customerAddress');
    const btn = event.target.closest('.btn-location');

    if (!navigator.geolocation) {
        alert('Geolocation is not supported by your browser');
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<span>Getting location...</span>';

    navigator.geolocation.getCurrentPosition(
        async (position) => {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;

            try {
                const response = await fetch(
                    `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1`
                );
                const data = await response.json();

                const address = data.display_name || `Lat: ${lat}, Lon: ${lon}`;
                addressField.value = address;

                btn.disabled = false;
                btn.innerHTML = `<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg> Use My Location`;

                showNotification('Location added successfully!', 'success');
            } catch (error) {
                console.error('Geocoding error:', error);
                addressField.value = `Coordinates: ${lat.toFixed(6)}, ${lon.toFixed(6)}`;
                btn.disabled = false;
                btn.innerHTML = `<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg> Use My Location`;
            }
        },
        (error) => {
            console.error('Geolocation error:', error);
            alert('Unable to get your location. Please enter manually.');
            btn.disabled = false;
            btn.innerHTML = `<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
            </svg> Use My Location`;
        }
    );
}

// Process checkout and send to WhatsApp
function processCheckout(event) {
    event.preventDefault();

    const name = document.getElementById('customerName').value;
    const phone = document.getElementById('customerPhone').value;
    const address = document.getElementById('customerAddress').value;
    const notes = document.getElementById('notes').value;

    // Validate phone number
    let cleanPhone = phone.replace(/\D/g, '');
    if (cleanPhone.startsWith('0')) {
        cleanPhone = '62' + cleanPhone.substring(1);
    } else if (!cleanPhone.startsWith('62')) {
        cleanPhone = '62' + cleanPhone;
    }

    // Build WhatsApp message
    let message = `*NEW ORDER*\n\n`;
    message += `*Customer Details:*\n`;
    message += `Name: ${name}\n`;
    message += `Phone: ${phone}\n`;
    message += `Address: ${address}\n\n`;

    message += `*Order Items:*\n`;
    message += `================================\n`;

    let total = 0;
    cartData.forEach((item, index) => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        message += `${index + 1}. *${item.title}*\n`;
        message += `   Qty: ${item.quantity} x Rp ${formatPrice(item.price)}\n`;
        message += `   Subtotal: Rp ${formatPrice(itemTotal)}\n\n`;
    });

    message += `================================\n`;
    message += `*TOTAL: Rp ${formatPrice(total)}*\n`;
    message += `Shipping: FREE\n\n`;

    if (notes) {
        message += `*Notes:* ${notes}\n\n`;
    }

    message += `Thank you for your order!`;

    // Encode message for URL
    const encodedMessage = encodeURIComponent(message);

    // WhatsApp number
    const waNumber = '6289629989477';

    // Create WhatsApp URL
    const waURL = `https://wa.me/${waNumber}?text=${encodedMessage}`;

    // Open WhatsApp in new tab
    window.open(waURL, '_blank');

    // Close modal immediately
    closeCheckoutModal();

    // Clear cart and redirect immediately
    // Use a small delay to ensure the new tab opens successfully
    setTimeout(() => {
        const clearUrl = BASE_URL.endsWith('/') ? BASE_URL + 'cart/clear' : BASE_URL + '/cart/clear';
        window.location.href = clearUrl;
    }, 1000);
}

// Format price
function formatPrice(price) {
    return new Intl.NumberFormat('id-ID').format(price);
}

// Close modal when clicking outside
window.addEventListener('click', function (event) {
    const checkoutModal = document.getElementById('checkoutModal');
    if (event.target == checkoutModal) {
        closeCheckoutModal();
    }
});

// ESC key to close
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        const checkoutModal = document.getElementById('checkoutModal');
        if (checkoutModal && checkoutModal.style.display === 'block') {
            closeCheckoutModal();
        }
    }
});
