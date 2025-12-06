<?php
// app/views/home/index.php
$title = 'Store - Premium Modern Products';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <div class="badge">
            <span class="badge-icon">✦</span>
            <span>Koleksi Terbaru Tersedia</span>
        </div>
        <h1 class="hero-title">
            Lengkapi Kebutuhan<br>
            <span class="highlight">Kerja & Belajarmu</span>
        </h1>
        <p class="hero-subtitle">
            Temukan berbagai alat tulis dan perlengkapan kantor berkualitas tinggi<br>
            untuk menunjang produktivitas Anda sehari-hari.
        </p>
        <div class="hero-buttons">
            <a href="<?= BASE_URL ?>catalogue" class="btn-primary">
                Lihat Katalog <span class="arrow">→</span>
            </a>
            <a href="<?= BASE_URL ?>contact" class="btn-secondary">
                Hubungi Kami
            </a>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="why-choose">
    <div class="container">
        <h2 class="section-heading">Kenapa Memilih Kami?</h2>
        <p class="section-subheading">Kami berkomitmen memberikan perlengkapan terbaik untuk Anda</p>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-pencil-fill"></i>
                </div>
                <h3>Produk Lengkap</h3>
                <p>Tersedia berbagai jenis alat tulis, kertas, dan perlengkapan kantor</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-patch-check-fill"></i>
                </div>
                <h3>Kualitas Terjamin</h3>
                <p>Produk original dari merek-merek terpercara dan awet</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-truck"></i>
                </div>
                <h3>Pengiriman Cepat</h3>
                <p>Pesanan diproses dan dikirim dengan aman ke seluruh Indonesia</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Banner Section -->
<section class="cta-banner">
    <div class="cta-content">
        <h2>Siap Untuk Berbelanja?</h2>
        <p>Lengkapi meja kerja dan ruang belajarmu dengan peralatan tulis terbaik dari PenaPedia.</p>
        <a href="<?= BASE_URL ?>catalogue" class="btn-cta">
            Mulai Belanja <span class="arrow">→</span>
        </a>
    </div>
</section>
