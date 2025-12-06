<?php
// app/views/contact/index.php
$title = 'Hubungi Kami - PenaPedia';
?>

<?php if (isset($success) && $success): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showNotification('Terima kasih! Pesan Anda telah terkirim.', 'success');
    });
</script>
<?php endif; ?>

<?php if (isset($errors) && !empty($errors)): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php foreach ($errors as $error): ?>
            showNotification('<?= addslashes($error) ?>', 'error');
        <?php endforeach; ?>
    });
</script>
<?php endif; ?>

<section class="contact-section">
    <div class="contact-container">
        <div class="contact-info">
            <h1>Hubungi Kami</h1>
            <p>Jangan ragu untuk menghubungi kami melalui saluran di bawah ini. Tim kami siap membantu kebutuhan alat tulis Anda.</p>
            
            <div class="contact-items">
                <div class="contact-item">
                    <div class="contact-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="contact-details">
                        <h3>Email</h3>
                        <p>auliafinannisa@gmail.com</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div class="contact-details">
                        <h3>Telepon</h3>
                        <p>+62 896 2998 9477</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="contact-details">
                        <h3>Alamat</h3>
                        <p>Sekaran, Gunungpati, Jawa Tengah, 50229</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="contact-form-wrapper">
            <h2>Kirim Pesan</h2>
            <form class="contact-form" method="POST" action="<?= BASE_URL ?>contact">
                <div class="form-group">
                    <label for="name">Nama Anda</label>
                    <input type="text" id="name" name="name" placeholder="Liaa" value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input type="email" id="email" name="email" placeholder="auliafinannisa@gmail.com" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="message">Pesan</label>
                    <textarea id="message" name="message" rows="5" placeholder="Tulis pesan Anda di sini..." required><?= htmlspecialchars($old['message'] ?? '') ?></textarea>
                </div>
                <button type="submit" class="btn-send">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Kirim Pesan
                </button>
            </form>
        </div>
    </div>
</section>
