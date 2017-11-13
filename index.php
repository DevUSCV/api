<?php

session_start();

require './vendor/autoload.php';

use Slim\Http\Request;
use Slim\Http\Response;

// Create Application
$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

// Define container's contents
$container = $app->getContainer();

// Define Routes
$app->get("/", function(Request $request, Response $response, $args){
    var_dump($args);
    $response->write("ok");
    return $response;
})->add(new App\Middleware\Security\Logged());

$app->get("/user/id/{id}", App\Ressources\UserResource::class . ":getUserById" )->add(new App\Middleware\Security\Logged());
$app->get("/user/email/{email}", App\Ressources\UserResource::class . ":getUserByEmail" );
$app->post("/user/login", App\Ressources\UserResource::class . ":login" );
$app->get("/user/logout", App\Ressources\UserResource::class . ":logout" );

// Run the Application
$app->run();