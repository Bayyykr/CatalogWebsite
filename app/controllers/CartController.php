<?php
namespace App\Controllers;

use Core\View;

class CartController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $cart = $_SESSION['cart'] ?? [];
        
        // Calculate total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        View::render('cart/index', [
            'cart' => $cart,
            'total' => $total
        ]);
    }
    
    public function add() {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $productId = $data['product_id'] ?? null;
            $quantity = $data['quantity'] ?? 1;
            
            if (!$productId) {
                echo json_encode(['success' => false, 'message' => 'Product ID required']);
                return;
            }
            
            // Get product details from database
            $model = new \App\Models\CatalogueModel();
            $products = $model->getItems();
            
            // Find product in items list
            $product = null;
            foreach ($products as $p) {
                if ($p['id'] == $productId) {
                    $product = $p;
                    break;
                }
            }
            
            if (!$product) {
                echo json_encode(['success' => false, 'message' => 'Product not found in database']);
                return;
            }
            
            // Initialize cart if not exists
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            
            // Check if product already in cart
            $found = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] == $productId) {
                    $item['quantity'] += $quantity;
                    $found = true;
                    break;
                }
            }
            
            // Add new item if not found
            if (!$found) {
                $_SESSION['cart'][] = [
                    'id' => $product['id'],
                    'title' => $product['title'],
                    'price' => $product['price'],
                    'image' => $product['image'] ?? '/uploads/products/placeholder.jpg',
                    'quantity' => $quantity
                ];
            }
            
            echo json_encode([
                'success' => true,
                'cart_count' => count($_SESSION['cart']),
                'message' => 'Product added to cart'
            ]);
            
        } catch (\Exception $e) {
            error_log("Cart add error: " . $e->getMessage());
            echo json_encode([
                'success' => false, 
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function remove() {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        $productId = $data['product_id'] ?? null;
        
        if (!isset($_SESSION['cart'])) {
            echo json_encode(['success' => false]);
            return;
        }
        
        $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($productId) {
            return $item['id'] != $productId;
        });
        
        // Re-index array
        $_SESSION['cart'] = array_values($_SESSION['cart']);
        
        echo json_encode([
            'success' => true,
            'cart_count' => count($_SESSION['cart'])
        ]);
    }
    
    public function update() {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        $productId = $data['product_id'] ?? null;
        $quantity = $data['quantity'] ?? 1;
        
        if (!isset($_SESSION['cart'])) {
            echo json_encode(['success' => false]);
            return;
        }
        
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $productId) {
                $item['quantity'] = max(1, $quantity);
                break;
            }
        }
        
        echo json_encode(['success' => true]);
    }
    
    public function clear() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['cart'] = [];
        $url = rtrim(BASE_URL, '/') . '/cart';
        header('Location: ' . $url);
        exit;
    }
    
    public function apiClear() {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['cart'] = [];
        echo json_encode(['success' => true, 'message' => 'Cart cleared']);
    }
}
?>
