<?php
namespace App\Controllers;

use Core\View;
use App\Models\ContactModel;

class ContactController {
    public function index() {
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->submit();
            return;
        }
        
        // Render contact page
        View::render('contact/index', [
            'success' => $_GET['success'] ?? null
        ]);
    }

    private function submit() {
        // Validate input
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $message = trim($_POST['message'] ?? '');
        
        $errors = [];
        
        if (empty($name)) {
            $errors[] = 'Name is required';
        }
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Valid email is required';
        }
        
        if (empty($message)) {
            $errors[] = 'Message is required';
        }
        
        if (!empty($errors)) {
            View::render('contact/index', [
                'errors' => $errors,
                'old' => $_POST
            ]);
            return;
        }
        
        // Save to database
        $model = new ContactModel();
        $success = $model->saveContact([
            'name' => $name,
            'email' => $email,
            'message' => $message
        ]);
        
        if ($success) {
            // Redirect with success message
            header('Location: ' . BASE_URL . 'contact?success=1');
            exit;
        } else {
            View::render('contact/index', [
                'errors' => ['Failed to send message. Please try again.'],
                'old' => $_POST
            ]);
        }
    }
}
?>
