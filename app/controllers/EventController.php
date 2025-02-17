<?php

namespace App\controllers;

use App\core\Auth;
use App\core\Database;
use App\core\Model;
use App\core\Session;
use App\core\View;
use App\models\Event;
use App\models\Participant;
use App\models\RegisteredUser;
use App\models\User;
use App\models\UserModel;
use App\models\Comment;

class EventController
{
    private $db;
    private $Auth;
    private Event $event;
    private Comment $comment;
    public function __construct(){
        $UserDatabase = new Database();
        $this->event = new Event();
        $this->comment = new Comment();
    }
    public function index($event_id){
        $event = new Event();
        $comment = new Comment();
        View::render("front/Event",[
            "title"=>"Home",
            "eventInfo"=>$event->show_events(["event_id"=>$event_id])[0],
            "comments" =>$comment->get_comments($event_id),
            "userID" => $_SESSION['userID']
        ]);

    }
    public function createEvent(){
        if (Session::has("isAuth") && Session::get("isAuth")){
            View::render("front/create_event",[
                "title"=>"Home",
                "Categories"=>CategorieController::getAllCategories(),
                "Tags"=>TagController::GetAllTags()
            ]);
        }else{
            header("Location:Auth/Login");
        }
    }

    public function getEventByCategorie($category){
        $eventsGettedByCategorie = [];
        foreach ($this->event->show_events() as $event){
            if ($event["category_name"]===$category){
                $eventsGettedByCategorie[]=$event;
            }
        }
        return $eventsGettedByCategorie;
    }

    public function AddEvent(){
        extract($_POST);
        $EventCreator = Session::get("userID");
        $promo_code = 3;
        $result = $this->event->addEvent($EventCreator,$event_title,$event_description,$event_city,$eventlink,$event_price,$event_address,$event_capacity,intval($event_category),$event_type,"pending",$event_date,$event_start_at,$event_end_at,$event_capacity,$event_cover="Cover",$promo_code);
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
        var_dump($return);
    }
    public function testEvent(){
        View::render("front/test",[
            "title"=>"Home",
            "data"=>$this->event->show_events(),
        ]);
    }

    public function EventDetails($id){
        View::render("front/Organizer_Single_Event",[
            "title"=>"Home",
            "data"=>$this->event->show_events(["event_id"=>$id])[0],
            "ticketInfo"=>$this->event->Tickets_Information($id)[0],
            "participants"=>$this->event->GetEventParticipants($id)
        ]);
    }
    public function GetMyEvents(){
        $id = Session::get("userID");
        $result = $this->event->GetEventForOrganizer($id);
        View::render("front/manager_events",[
            "title"=>"Home",
            "data"=>$result,
        ]);
    }


}