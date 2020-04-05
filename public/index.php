<?php
use App\Router;

require '../vendor/autoload.php';

$router = new Router(dirname(__DIR__) . '/views');
try {
    $router
        ->get('/blog', 'post/index', 'blog')
        ->get('/blog/category', 'category/show', 'category')
        ->run();
} catch(Exception $e) {
    echo $e->getMessage();
}

