<?php

namespace App\routes;

use App\models\UserModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


$userModel = new UserModel();

$app->get('/registration', function (Request $request, Response $response) use ($view){
    $body = $view->render('registration.twig');
    $response->getBody()->write($body);

    return $response;
});

$app->post('/create-user', function (Request $request, Response $response) use ($userModel) {
    $parsedBody = $request->getParsedBody();
    $checkInBase = $userModel->getUser($parsedBody['email']);
    if(empty($checkInBase)){
        $userId = $userModel->createNewUser($parsedBody['email'], $parsedBody['password']);
        $_SESSION['id'] = $userId;
        return $response->withHeader('Location', '/your-list');
    }
    return $response->withHeader('Location', '/checkUsers');

});

$app->get('/login', function (Request $request, Response $response) use ($view){
    $body = $view->render('login.twig');
    $response->getBody()->write($body);
    return $response;
});

$app->post('/auth', function (Request $request, Response $response) use ($view, $userModel){
    $parsedBody = $request->getParsedBody();
    $userData = $userModel->getUser($parsedBody['email']);
    $isCorrectPass = password_verify($parsedBody['password'], $userData['password']);

    if ($isCorrectPass) {
        $_SESSION['id'] =(int)$userData['user_id'];

        return $response->withHeader('Location', '/your-list');
    } else {
        $body = $view->render('401.twig');
        $response->getBody()->write($body);

        return $response;
    }
});

$app->get('/checkUsers', function (Request $request, Response $response) use ($view){
    $body = $view->render('checkUsers.twig');
    $response->getBody()->write($body);

    return $response;
});

$app->get('/exit', function (Request $request, Response $response){
    setcookie('PHPSESSID', "", time() - 3600);
    session_destroy();

    return $response->withHeader('Location', '/');
} );