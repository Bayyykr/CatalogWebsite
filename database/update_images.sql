-- Update existing products to use local image paths
-- Run this after uploading images to uploads/products/ folder

-- Example: Update product 1 with local image
-- UPDATE product_images 
-- SET image_url = '/uploads/products/sample-product.jpg'
-- WHERE product_id = 1;

-- Add new image for existing product
-- INSERT INTO product_images (product_id, image_url, alt_text, is_primary)
-- VALUES (1, '/uploads/products/your-image-name.jpg', 'Product Description', 1);

-- Batch update for multiple products (customize as needed)
/*
UPDATE product_images SET image_url = '/uploads/products/headphones.jpg' WHERE product_id = 1;
UPDATE product_images SET image_url = '/uploads/products/watch.jpg' WHERE product_id = 2;
UPDATE product_images SET image_url = '/uploads/products/backpack.jpg' WHERE product_id = 3;
*/

-- Set a new primary image for a product
/*
-- First, unset all as non-primary
UPDATE product_images SET is_primary = 0 WHERE product_id = 1;
-- Then set new primary
UPDATE product_images SET is_primary = 1 WHERE product_id = 1 AND id = 5;
*/

-- View all product images
SELECT 
    pi.id,
    p.name AS product_name,
    pi.image_url,
    pi.is_primary,
    pi.alt_text
FROM product_images pi
JOIN products p ON pi.product_id = p.id
ORDER BY p.id, pi.is_primary DESC;
