// js/cart.js - Shopping Cart Functionality

// Current product for modal
let currentProduct = null;

// Open product modal
function openProductModal(productId, title, category, price, image) {
    currentProduct = {
        id: productId,
        title: title,
        category: category,
        price: price,
        image: image
    };

    document.getElementById('modalProductImage').src = image;
    document.getElementById('modalProductTitle').textContent = title;
    document.getElementById('modalProductCategory').textContent = category.toUpperCase();
    document.getElementById('modalProductPrice').textContent = 'Rp ' + formatPrice(price);
    document.getElementById('quantity').value = 1;
    document.getElementById('productModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

// Close modal
function closeProductModal() {
    document.getElementById('productModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    currentProduct = null;
}

// Close modal when clicking X or outside
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('productModal');
    const closeBtn = document.querySelector('#productModal .modal-close');

    if (closeBtn) {
        closeBtn.onclick = closeProductModal;
    }

    // Close modals when clicking outside
    window.addEventListener('click', function (event) {
        if (event.target == modal) {
            closeProductModal();
        }

        const deleteModal = document.getElementById('deleteModal');
        if (event.target == deleteModal) {
            closeDeleteModal();
        }
    });

    // ESC key to close
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            if (modal.style.display === 'block') closeProductModal();

            const deleteModal = document.getElementById('deleteModal');
            if (deleteModal && deleteModal.style.display === 'block') closeDeleteModal();
        }
    });
});

// Change quantity
function changeQuantity(delta) {
    const qtyInput = document.getElementById('quantity');
    let newValue = parseInt(qtyInput.value) + delta;
    if (newValue >= 1 && newValue <= 99) {
        qtyInput.value = newValue;
    }
}

// Add to cart
function addToCart() {
    if (!currentProduct) return;

    const quantity = parseInt(document.getElementById('quantity').value);

    // Send to server
    fetch('/api/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            product_id: currentProduct.id,
            quantity: quantity
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update cart count
                document.getElementById('cartCount').textContent = data.cart_count;

                // Show success message
                showNotification('Produk Ditambahkan ke Keranjang!', 'success');

                // Close modal
                closeProductModal();
            } else {
                showNotification('Failed to add product', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred', 'error');
        });
}

// Show notification
function showNotification(message, type = 'success') {
    // Remove existing notification
    const existing = document.querySelector('.notification');
    if (existing) {
        existing.remove();
    }

    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    document.body.appendChild(notification);

    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.classList.add('notification-hide');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Format price
function formatPrice(price) {
    return new Intl.NumberFormat('id-ID').format(price);
}

// Product ID to delete
let productToDelete = null;

// Open delete modal
function openDeleteModal(productId) {
    productToDelete = productId;
    document.getElementById('deleteModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

// Close delete modal
function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    productToDelete = null;
}

// Handle delete confirmation
document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
    if (!productToDelete) return;

    fetch('/api/cart/remove', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            product_id: productToDelete
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Gagal menghapus produk', 'error');
            closeDeleteModal();
        });
});

// Remove from cart (trigger)
function removeFromCart(productId) {
    openDeleteModal(productId);
}

// Update cart quantity
function updateCartQuantity(productId, quantity) {
    fetch('/api/cart/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
