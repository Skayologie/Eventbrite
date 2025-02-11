<?php

namespace App\controllers;

use App\core\Auth;
use App\core\Database;
use App\core\Session;
use App\core\View;
use App\models\Participant;
use App\models\RegisteredUser;
use App\models\User;
use App\models\UserModel;

class EventController
{
    private $db;
    private $Auth;
    public function __construct(){
        $UserDatabase = new Database();
    }
    public function index($event_id){
        View::render("front/Event",[
            "title"=>"Home",
        ]);
    }
    public function createEvent(){
        if (Session::has("isAuth") && Session::get("isAuth")){
            View::render("front/create_event",[
                "title"=>"Home",
            ]);
        }else{
            header("Location:Auth/Login");
        }

    }


}