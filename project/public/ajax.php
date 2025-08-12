<?php

require_once __DIR__ . '/../app/Controllers/ProductController.php';

use App\Controllers\ProductController;

spl_autoload_register(function ($class) {
    $file = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

$controller = new ProductController();
$controller->ajax();
