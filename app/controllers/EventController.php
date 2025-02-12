<?php

namespace App\controllers;

use App\core\Auth;
use App\core\Database;
use App\core\Session;
use App\core\View;
use App\models\Event;
use App\models\Participant;
use App\models\RegisteredUser;
use App\models\User;
use App\models\UserModel;

class EventController
{
    private $db;
    private $Auth;
    private Event $event;
    public function __construct(){
        $UserDatabase = new Database();
        $this->event = new Event();
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

    public function AddEvent(){
        extract($_POST);
        $EventCreator = Session::get("userID");
        $result = $this->event->addEvent($EventCreator,$event_title,$event_description,$event_city,$eventlink,$event_price,$event_address,$event_capacity,$event_category,$event_type,"pending",$event_date,$event_seats,$event_cover,$promo_code);
        if ($result){
            $return = [
                "status"=>true,
                "message"=>"Event Added Successfully",
            ];
        }else{
            $return = [
                "status"=>false,
                "message"=>"Failed , Event  Successfully",
            ];
        }
        echo json_encode($return);
    }
    public function testEvent(){
        View::render("front/test",[
            "title"=>"Home",
            "data"=>$this->event->show_events(),
        ]);
    }

}