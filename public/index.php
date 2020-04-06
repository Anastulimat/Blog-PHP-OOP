<?php
use App\Router;

require '../vendor/autoload.php';

//Nous donne le temps actuel avec les miliscondes pour aider le debug et la performance
define('DEBUG_TIME', microtime(true));

//Partie de debug gérée grace à flip/whoops
$whoops = new Whoops\Run();
$whoops->pushHandler(new Whoops\Handler\PrettyPageHandler());
$whoops->register();

$router = new Router(dirname(__DIR__) . '/views');
try {
    $router
        ->get('/', 'post/index', 'home')
        ->get('/blog/[*:slug]-[i:id]', 'post/show', 'post')
        ->get('/blog/category', 'category/show', 'category')
        ->run();
} catch(Exception $e) {
    echo $e->getMessage();
}

