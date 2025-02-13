<?php

namespace App\controllers;
use App\core\Database;
use App\core\Session;
use App\core\View;
use App\models\Category;
use App\models\Event;
use App\models\Tag;

class HomeController
{
    public function index(){
        $db = new Database();
        $event = new Event();
        $categories = new Category();


        $isAuth = Session::get("isAuth");
        $role = Session::get("roleID");
        $email = Session::get("email");
        if ($role === 1){//user
            View::render("front/home",[
                "title"=>"Home",
                "isAuth"=>$isAuth,
                "events"=>$event->show_events(),
                "Categories"=>$categories->showCategorie(),
                "role"=>$role,
                "email"=>$email
            ]);
        }elseif($role === 3){//admin
            View::render("back/Dashboard",[
                "title"=>"Home",
                "isAuth"=>$isAuth,
                "role"=>$role,
                "email"=>$email

            ]);
        }elseif($role === 2){//organizer
            View::render("front/home",[
                "title"=>"Home",
                "isAuth"=>$isAuth,
                "role"=>$role,
                "email"=>$email

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