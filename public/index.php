<?php

use App\controllers\EventController;
use App\controllers\HomeController;
use App\controllers\UserController;
use App\core\Auth;
use App\core\Router;
use App\core\Session;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
require_once "../app/Core/Router.php";
require_once "../app/Core/Controller.php";
require realpath(__DIR__ . "/../vendor/autoload.php");
Session::start();

$router = new Router();

$router->get("/",HomeController::class, "index");
$router->get("/Auth/{type}",Auth::class, "index");
$router->post("/register",UserController::class, "register");
$router->post("/login",UserController::class, "login");
$router->get("/CreateEvent",EventController::class, "index");
$router->get("/logout",UserController::class, "logout");


$router->dispatch();
