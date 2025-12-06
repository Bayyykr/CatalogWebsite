<?php
// app/views/partials/header.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Store - Premium Products' ?></title>
    <meta name="description" content="Discover premium modern products for your lifestyle.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
</head>
<body>
    <header class="navbar">
        <div class="nav-container">
            <a href="<?= BASE_URL ?>" class="logo">
                <span class="logo-icon">S</span>
                <span class="logo-text">Store</span>
            </a>
            <nav class="nav-menu">
                <ul class="nav-list">
                    <li><a href="<?= BASE_URL ?>" class="nav-link active">Home</a></li>
                    <li><a href="<?= BASE_URL ?>catalogue" class="nav-link">Catalog</a></li>
                    <li><a href="<?= BASE_URL ?>contact" class="nav-link">Contact</a></li>
                </ul>
            </nav>
            <a href="<?= BASE_URL ?>catalogue" class="btn-get-started">Get Started</a>
        </div>
    </header>
