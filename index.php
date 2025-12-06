<?php
// public entry point (index.php)
require __DIR__ . '/config/config.php';

use Core\Router;

$router = new Router();

// Define routes
$router->add('GET', '/', 'HomeController@index');
$router->add('GET', '/catalogue', 'CatalogueController@index');
$router->add('GET', '/contact', 'ContactController@index');
$router->add('POST', '/contact', 'ContactController@index');

// Cart routes
$router->add('GET', '/cart', 'CartController@index');
$router->add('POST', '/api/cart/add', 'CartController@add');
$router->add('POST', '/api/cart/remove', 'CartController@remove');
$router->add('POST', '/api/cart/update', 'CartController@update');
$router->add('POST', '/api/cart/clear', 'CartController@apiClear');
$router->add('POST', '/cart/clear', 'CartController@clear');
$router->add('GET', '/cart/clear', 'CartController@clear');

// Dispatch the request
$router->dispatch();
?>
