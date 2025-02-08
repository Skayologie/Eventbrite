<?php

use App\controllers\HomeController;
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
$router->get("/Auth",Auth::class, "index");


$router->dispatch();
