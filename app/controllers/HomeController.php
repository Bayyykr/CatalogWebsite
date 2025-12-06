<?php
namespace App\Controllers;

use Core\View;

class HomeController {
    public function index() {
        // Data can be passed to view if needed
        View::render('home/index');
    }
}
?>
