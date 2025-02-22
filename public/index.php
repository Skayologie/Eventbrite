<?php

use App\controllers\CategorieController;
use App\controllers\DashboardController;
use App\controllers\EventController;
use App\controllers\HomeController;
use App\controllers\SupportController;
use App\controllers\TagController;
use App\controllers\UserController;
use App\controllers\CommentController;
use App\core\Auth;
use App\core\Router;
use App\core\Session;
use App\mail\Mail;
use App\controllers\PaymentController;
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
$router->post("/SearchEvent",EventController::class, "searchEvent");
$router->get("/Explore/Event/{category}",HomeController::class, "getEventByCategorie");
$router->get("/CreateEvent",EventController::class, "createEvent");
$router->post("/CreateEvent",EventController::class, "AddEvent");
$router->get("/Organizer/EventDetails/{id}",EventController::class, "EventDetails");
$router->get("/Organizer/MyEvents",EventController::class, "GetMyEvents");
$router->get("/ChangeRole",UserController::class, "switch_role");
$router->get("/logout",Auth::class, "logout");

$router->get("/Admin/Dashboard",DashboardController::class, "index");
$router->get("/Admin/Users",UserController::class, "index");
$router->get("/Admin/Users/ManageUsers/{id}/{option}",UserController::class, "SuspendactiveUser");
$router->get("/Admin/Events",EventController::class, "index");
$router->get("/Admin/Events/ManageEvent/{id}/{option}",EventController::class, "ApproveRejectEvent");

$router->get("/checkRole",UserController::class, "checkRole");

//Tag
$router->get("/Tags",TagController::class, "index");
$router->post("/DeleteTag/{id}",TagController::class, "deleteTag");
$router->get("/GetTags",TagController::class, "GetTags");
$router->post("/AddTag",TagController::class, "addTag");

//Categories
$router->get("/Categories",CategorieController::class, "index");
$router->post("/DeleteCategorie/{id}",CategorieController::class, "deleteCategorie");
$router->get("/GetCategories",CategorieController::class, "GetCategories");
$router->post("/AddCategorie",CategorieController::class, "addCategorie");

$router->get("/checkRole",UserController::class, "checkRole");



$router->get("/SendWelcome",Mail::class, "Send");

$router->get("/payment",PaymentController::class, "index");

$router->get("/payment/checkout/{event_id}/{pricePerTicket}/{quantity}", PaymentController::class, "checkout");

$router->get("/payment/success", PaymentController::class, "success");
$router->get("/payment/finished", PaymentController::class, "finishPayment");

$router->get("/payment/cancel", PaymentController::class, "cancel");


$router->post("/Support/SendMessage",SupportController::class,'sendMessage');

//Comments
$router->post("/comments/add/{event_id}",CommentController::class,'addComment');
$router->get('/comments/delete/{event_id}/{comment_id}', CommentController::class, 'delete_comment');



//$TESTS
$router->get("/TEST",EventController::class, "testEvent");







$router->get("/Download/participants/{event_id}/{type}",UserController::class, "DownloadParticipantList");











$router->dispatch();
