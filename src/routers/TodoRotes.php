<?php

namespace App\routes;

use App\middlewares\CheckUserMiddleware;
use App\models\TodoModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$list = new TodoModel();

$app->get('/', function (Request $request, Response $response) use ($view) {
    $body = $view->render('startedPage.twig');
    $response->getBody()->write($body);

    return $response;
});

$app->get('/your-list', function (Request $request, Response $response) use ($view, $list) {
    $userId = $_SESSION['id'];
    $result = $list->getAll($userId);
    $body = $view->render('homePage.twig',
        ['list' => $result]);
    $response->getBody()->write($body);

    return $response;
})->add(CheckUserMiddleware::class);

$app->get('/done', function (Request $request, Response $response) use($view, $list){
    $userId = $_SESSION['id'];
    $result = $list->getDone($userId);
    $body = $view->render('homePage.twig', [
        'list' => $result
    ]);
    $response->getBody()->write($body);

    return $response;
})->add(CheckUserMiddleware::class);

$app->get('/set/{id}', function (Request $request, Response $response, $args) use($list){
    $list->updateStatus($args['id']);

    return $response->withHeader('Location', '/your-list');
})->add(CheckUserMiddleware::class);

$app->post('/new-task', function(Request $request, Response $response) use($list) {
    $userId = $_SESSION['id'];
    $parsedBody = $request->getParsedBody();
    $list->newTask($parsedBody['task'], $userId);

    return $response->withHeader('Location', '/your-list');
})->add(CheckUserMiddleware::class);


$app->get('/delete-{id}', function (Request $request, Response $response, $args) use($list) {
    $list->delete($args['id']);

    return $response->withHeader('Location', '/your-list');
})->add(CheckUserMiddleware::class);



