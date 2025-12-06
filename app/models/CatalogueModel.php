<?php
namespace App\Models;

use Core\Database;
use PDO;

class CatalogueModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Get all products with their primary image and category
     * @return array
     */
    public function getItems(): array {
        $sql = "SELECT 
                    p.id,
                    p.name AS title,
                    p.short_description AS description,
                    c.name AS category,
                    p.price,
                    COALESCE(pi.image_url, 'https://via.placeholder.com/400x300') AS image
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN product_images pi ON p.id = pi.product_id
                WHERE p.status IN ('active', 'published')
                ORDER BY p.created_at DESC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Get unique categories
     * @return array
     */
    public function getCategories(): array {
        // Add "All" as the first category
        $categories = ['All'];
        
        $sql = "SELECT DISTINCT c.name 
                FROM categories c
                INNER JOIN products p ON c.id = p.category_id
                WHERE p.status IN ('active', 'published')
                ORDER BY c.name";
        
        $stmt = $this->db->query($sql);
        $dbCategories = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        return array_merge($categories, $dbCategories);
    }

    /**
     * Get product by ID with all images
     * @param int $id
     * @return array|null
     */
    public function getProductById(int $id): ?array {
        $sql = "SELECT 
                    p.*,
                    c.name AS category_name,
                    c.slug AS category_slug
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.id = :id AND p.status = 'active'";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch();
        
        if ($product) {
            // Get all images for this product
            $sql = "SELECT * FROM product_images WHERE product_id = :id ORDER BY is_primary DESC, created_at";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $id]);
            $product['images'] = $stmt->fetchAll();
        }
        
        return $product ?: null;
    }
}
?>
