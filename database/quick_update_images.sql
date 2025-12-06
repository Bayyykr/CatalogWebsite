-- Quick SQL untuk update image path ke local

-- 1. Lihat produk yang ada
SELECT id, name, status FROM products;

-- 2. Lihat gambar yang ada saat ini
SELECT * FROM product_images;

-- 3. Contoh update untuk product_id = 1
-- Ganti 'sample-product.jpg' dengan nama file gambar Anda
UPDATE product_images 
SET image_url = '/uploads/products/sample-product.jpg',
    alt_text = 'Sample Product Image'
WHERE product_id = 1;

-- 4. Atau tambah gambar baru
INSERT INTO product_images (product_id, image_url, alt_text, is_primary) 
VALUES 
(1, '/uploads/products/product-1.jpg', 'Product 1 Image', 1);

-- 5. Set is_primary untuk gambar utama
-- Pertama set semua ke 0
UPDATE product_images SET is_primary = 0 WHERE product_id = 1;
-- Lalu set yang dipilih ke 1
UPDATE product_images SET is_primary = 1 WHERE id = 1;

-- 6. Verifikasi hasilnya
SELECT 
    p.id AS product_id,
    p.name,
    pi.image_url,
    pi.is_primary
FROM products p
LEFT JOIN product_images pi ON p.id = pi.product_id
ORDER BY p.id;
