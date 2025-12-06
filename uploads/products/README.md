# Product Images Folder

Place product images here.

## Naming Convention
- Use lowercase
- Use hyphens instead of spaces
- Include product name or ID

Examples:
- wireless-headphones-pro.jpg
- minimalist-watch-black.png
- premium-backpack-001.jpg

## Image Specifications
- Format: JPG, PNG, WEBP
- Max size: 2MB
- Recommended dimensions: 800x600px or 1:1 ratio
- Quality: 80-90% for JPG

After adding images here, update the database with the path:
```sql
INSERT INTO product_images (product_id, image_url, alt_text, is_primary) 
VALUES (1, '/uploads/products/your-image.jpg', 'Product Name', 1);
```
