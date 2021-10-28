<?php

use Slim\Factory\AppFactory;
use Slim\HttpCache\Cache;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Slim\HttpCache\CacheProvider;


require __DIR__ . '/../vendor/autoload.php';

$loader = new FilesystemLoader('templates');
$view = new Environment($loader);

try {
    $app = AppFactory::create();

    // Register the http cache middleware.
    $app->add(new Cache('public', 86400));

// Create the cache provider.
    $cacheProvider = new CacheProvider();
    include '../src/routers/TodoRotes.php';
    include '../src/routers/UsersRoutes.php';

    session_start();

    $app->run();

} catch (PDOException $exception){
    echo 'Database error' . $exception->getMessage();
    exit();
} catch (Exception $exception){
    echo $exception->getMessage();
    exit();
}


