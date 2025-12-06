<?php
// app/views/partials/footer.php
?>
<footer class="footer">
    <div class="footer-container">
        <div class="footer-brand">
            <a href="<?= BASE_URL ?>" class="logo">
                <span class="logo-icon">S</span>
                <span class="logo-text">Store</span>
            </a>
            <p>Discover premium products with modern design and exceptional quality. Your satisfaction is our priority.</p>
        </div>
        <div class="footer-links">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="<?= BASE_URL ?>">Home</a></li>
                <li><a href="<?= BASE_URL ?>catalogue">Catalog</a></li>
                <li><a href="<?= BASE_URL ?>contact">Contact</a></li>
            </ul>
        </div>
        <div class="footer-contact">
            <h4>Contact</h4>
            <ul>
                <li>auliafinannisa@gmail.com</li>
                <li>+62 896 2998 9477</li>
                <li>Sekaran, Gunungpati, Jawa Tengah, 50229</li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> Store. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
