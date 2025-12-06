<?php
// app/views/layout.php
// Get current page from URL
$currentPage = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/', '/');
$currentPage = $currentPage ?: 'home';

// Initialize cart count from session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'PenaPedia - Alat Tulis & Perlengkapan' ?></title>
    <meta name="description" content="Temukan alat tulis dan perlengkapan kantor berkualitas untuk kebutuhan Anda.">
    <script>
        const BASE_URL = '<?= BASE_URL ?>';
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/cart-modal.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
    <header class="navbar">
        <div class="nav-container">
            <a href="<?= BASE_URL ?>" class="logo">
                <span class="logo-icon">P</span>
                <span class="logo-text">PenaPedia</span>
            </a>
            <nav class="nav-menu">
                <ul class="nav-list">
                    <li><a href="<?= BASE_URL ?>" class="nav-link <?= ($currentPage == 'home' || $currentPage == '') ? 'active' : '' ?>">Beranda</a></li>
                    <li><a href="<?= BASE_URL ?>catalogue" class="nav-link <?= $currentPage == 'catalogue' ? 'active' : '' ?>">Katalog</a></li>
                    <li><a href="<?= BASE_URL ?>contact" class="nav-link <?= $currentPage == 'contact' ? 'active' : '' ?>">Kontak</a></li>
                </ul>
            </nav>
            <a href="<?= BASE_URL ?>cart" class="btn-cart">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span class="cart-count" id="cartCount"><?= $cartCount ?></span>
            </a>
        </div>
    </header>

    <main>
        <?= $content ?>
    </main>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-brand">
                <a href="<?= BASE_URL ?>" class="logo">
                    <span class="logo-icon">P</span>
                    <span class="logo-text">PenaPedia</span>
                </a>
                <p>Menyediakan alat tulis dan perlengkapan kantor berkualitas dengan harga terbaik. Kepuasan Anda adalah prioritas kami.</p>
            </div>
            <div class="footer-links">
                <h4>Navigasi</h4>
                <ul>
                    <li><a href="<?= BASE_URL ?>">Beranda</a></li>
                    <li><a href="<?= BASE_URL ?>catalogue">Katalog</a></li>
                    <li><a href="<?= BASE_URL ?>contact">Kontak</a></li>
                </ul>
            </div>
            <div class="footer-contact">
                <h4>Hubungi Kami</h4>
                <ul>
                    <li>hello@penapedia.com</li>
                    <li>+62 812 3456 7890</li>
                    <li>Jakarta, Indonesia</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> PenaPedia. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <!-- Product Modal -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <div class="modal-body">
                <div class="modal-image">
                    <img id="modalProductImage" src="" alt="">
                </div>
                <div class="modal-info">
                    <span class="modal-category" id="modalProductCategory"></span>
                    <h2 id="modalProductTitle"></h2>
                    <p class="modal-price" id="modalProductPrice"></p>
                    <div class="modal-quantity">
                        <label for="quantity">Jumlah:</label>
                        <div class="quantity-control">
                            <button type="button" class="qty-btn" onclick="changeQuantity(-1)">−</button>
                            <input type="number" id="quantity" value="1" min="1" max="99">
                            <button type="button" class="qty-btn" onclick="changeQuantity(1)">+</button>
                        </div>
                    </div>
                    <button class="btn-add-to-cart" onclick="addToCart()">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Tambah ke Keranjang
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content" style="max-width: 400px;">
            <div class="modal-body-centered">
                <div style="margin-bottom: 1rem; color: #ef4444;">
                    <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin: 0 auto;">
                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <h3 style="margin-bottom: 0.25rem; color: #1a1a1a;">Hapus Produk?</h3>
                <p style="color: #666; margin-bottom: 1.25rem; font-size: 0.95rem;">Apakah Anda yakin ingin menghapus produk ini dari keranjang?</p>
                <div style="display: flex; gap: 0.75rem; justify-content: center; width: 100%;">
                    <button class="btn-secondary" onclick="closeDeleteModal()" style="padding: 0.6rem 1.2rem; flex: 1; justify-content: center; display: flex; align-items: center;">Batal</button>
                    <button id="confirmDeleteBtn" class="btn-primary" style="padding: 0.6rem 1.2rem; background: #ef4444; border-color: #ef4444; color: white; flex: 1; justify-content: center; display: flex; align-items: center;">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= BASE_URL ?>js/cart.js"></script>
    <script src="<?= BASE_URL ?>js/checkout.js"></script>
</body>
</html>
