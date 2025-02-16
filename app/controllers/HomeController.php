<?php

namespace App\controllers;
use App\core\Database;
use App\core\Session;
use App\core\View;
use App\models\Category;
use App\models\Event;
use App\models\Notification;
use App\models\Tag;

class HomeController
{
    private $event;

    public function __construct(){
        $UserDatabase = new Database();
        $this->event = new Event();
    }
    public function index(){
        $db = new Database();
        $event = new Event();
        $categories = new Category();
        $notifications = new Notification();


        $isAuth = Session::get("isAuth");
        $role = Session::get("roleID");
        $email = Session::get("email");
        $User_id = Session::get("userID");;
        if ($role === 1){//user
            View::render("front/home",[
                "title"=>"Home",
                "isAuth"=>$isAuth,
                "events"=>$event->show_events(),
                "Categories"=>$categories->showCategorie(),
                "role"=>$role,
                "email"=>$email,
                "Notifications"=>$notifications->getNotifications($User_id)
            ]);
        }elseif($role === 3){//admin
            View::render("back/Dashboard",[
                "title"=>"Home",
                "isAuth"=>$isAuth,
                "role"=>$role,
                "email"=>$email

            ]);
        }elseif($role === 2){//organizer
            $id = Session::get("userID");
            $result = $this->event->GetEventForOrganizer($id);
            View::render("front/manager_events",[
                "title"=>"Home",
                "isAuth"=>$isAuth,
                "role"=>$role,
                "email"=>$email,
                "Notifications"=>$notifications->getNotifications($User_id),
                "data"=>$result,
            ]);
        }else{
            View::render("front/home",[
                "title"=>"Home",
                "isAuth"=>$isAuth,
                "role"=>$role,
                "email"=>$email

            ]);
        }

    }
    public function getEventByCategorie($category){
        $event = new EventController();
        $categories = new Category();
        $isAuth = Session::get("isAuth");
        View::render("front/home",[
            "title"=>"Home",
            "isAuth"=>$isAuth,
            "category"=>$category,
            "events"=>$event->getEventByCategorie($category),
            "Categories"=>$categories->showCategorie(),
        ]);
    }
}