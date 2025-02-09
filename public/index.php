<?php

use App\controllers\EventController;
use App\controllers\HomeController;
use App\controllers\UserController;
use App\core\Auth;
use App\core\Router;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
session_start();
require_once "../app/Core/Router.php";
require_once "../app/Core/Controller.php";
require realpath(__DIR__ . "/../vendor/autoload.php");

$router = new Router();

$router->get("/",HomeController::class, "index");
$router->get("/Auth/{type}",Auth::class, "index");
$router->post("/register",UserController::class, "register");
$router->post("/login",UserController::class, "loginUser");
$router->get("/CreateEvent",EventController::class, "index");
$router->get("/logout",UserController::class, "logout");


$router->dispatch();
