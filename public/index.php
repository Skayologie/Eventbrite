<?php

use App\controllers\CategorieController;
use App\controllers\DashboardController;
use App\controllers\EventController;
use App\controllers\HomeController;
use App\controllers\TagController;
use App\controllers\UserController;
use App\core\Auth;
use App\core\Router;
use App\core\Session;
use App\mail\WelcomeMail;
use App\models\Participant;
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
$router->get("/Event/{event_id}",EventController::class, "index");
$router->get("/Explore/Event/{category}",HomeController::class, "getEventByCategorie");
$router->get("/CreateEvent",EventController::class, "createEvent");
$router->post("/CreateEvent",EventController::class, "AddEvent");
$router->get("/ChangeRole",UserController::class, "switch_role");
$router->get("/logout",Auth::class, "logout");
$router->get("/Admin/Dashboard",DashboardController::class, "index");
$router->get("/Admin/Users",UserController::class, "index");
$router->get("/checkRole",UserController::class, "checkRole");

//Tag
$router->get("/Tags",TagController::class, "index");
$router->post("/DeleteTag/{id}",TagController::class, "deleteTag");
$router->get("/GetTags",TagController::class, "GetTags");
$router->post("/AddTag",TagController::class, "addTag");

//Categories
$router->get("/Categories",CategorieController::class, "index");
$router->post("/DeleteCategorie/{id}",CategorieController::class, "deleteCategorie");

$router->get("/checkRole",UserController::class, "checkRole");



$router->get("/SendWelcome",WelcomeMail::class, "Send");

//$TESTS
$router->get("/TEST",EventController::class, "testEvent");




$router->dispatch();
