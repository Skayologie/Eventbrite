<?php

namespace App\controllers;

use App\core\Auth;
use App\core\Database;
use App\core\Model;
use App\core\Session;
use App\core\View;
use App\mail\Mail;
use App\models\Organizer;
use App\models\Participant;
use App\models\RegisteredUser;
use App\models\User;
use App\models\UserModel;

class UserController
{
    private $db;
    private $Auth;
    public function __construct(){
        $UserDatabase = new Database();
    }
    public function index(){
        $Users = new UserModel();
        View::render(
            "back/users",
            [
                "Users"=>$Users->getAllUsers(),
            ]
        );
    }


    public function SuspendactiveUser($user_id,$option){
        $User = new UserModel();
        $User->suspendactiveUser($user_id,$option);
        header("Location:../../../../Admin/Users");
    }

    public function register(){
        header('Content-Type: application/json');
        try {
            extract($_POST);

            $user = new RegisteredUser();
            $user->setFirstName($Registerfname);
            $user->setLastName($Registerlname);
            $user->setEmail($Registeremail);
            $user->setPassword($Registerpassword);
            $user->setBirthdate($Registerbirthdate);
            $user->setBio($Registerbio);
            $user->setRoleid(1);

            $userModel = new UserModel();
            if ($userModel->save($user)){
                $WelcomeMail = new Mail("jawadboulmal@gmail.com");
                $WelcomeMail->Send($user);
                $resultQ = [
                    "status"=>true,
                    "role" => "admin",
                    "message"=>"Account Created Successfully !"
                ];

            }else{
                $resultQ = [
                    "status"=>false,
                    "message"=>"Failed , Account not created !"
                ];
            }
            echo json_encode($resultQ);

        }catch (\Exception $e){
            Session::set("Error",$e->getMessage());
            $message = Session::get("Error");
            $resultQ = [
                "status"=>false,
                "message"=>$e->getMessage()
            ];
            echo json_encode($resultQ);
        }
    }

    public function login(){
        header('Content-Type: application/json');
        try {
            extract($_POST);

            $user = new RegisteredUser();
            $user->setEmail($Loginemail);

            $userModel = new UserModel();
            if ($userModel->check($user , $Loginpassword)){
                $Crud = new Model();
                $result = $Crud->GetCheck("users" , "email",$Loginemail)[0];
                if($result['status']==="suspend"){
                    $resultQ = [
                        "status"=>false,
                        "message"=>"Your Account Has Been Suspended By Admin , Contact The Support @JawadBoulmal !",
                        "durationTime"=>5000
                    ];
                    echo json_encode($resultQ);
                    return ;
                }
                Session::set("userID",$result["user_id"]??"");
                Session::set("roleID",$result["role_id"]);
                Session::set("email",$result["email"]);
                Session::set("avatar",$result["photo"]);
                Session::set("isAuth",true);
                $role = Session::get("roleID");
                if ($role === 3){
                    $resultQ = [
                        "status"=>true,
                        "role" => "admin",
                        "message"=>"Logged Successfully"
                    ];
                }elseif ($role === 1){
                    $resultQ = [
                        "status"=>true,
                        "role" => "user",
                        "message"=>"Logged Successfully"
                    ];
                }
            }else{
                Session::set("isAuth",false);
                $resultQ = [
                    "status"=>false,
                    "role" => "notLogged",
                    "message"=>"Failed , Informations incorrect !",
                ];

            }
            echo json_encode($resultQ);


        }catch (\Exception $e){
            Session::set("isAuth",false);
            Session::set("Error",$e->getMessage());
            $message = Session::get("Error");
            $resultQ = [
                "status"=>false,
                "role" => "notLogged",
                "message"=>$e->getMessage()
            ];
            echo json_encode($resultQ);

        }
    }
    public function checkRole(){
        $role = Session::get("roleID");
        if ($role === 3){
            header("Location:/Admin/Dashboard");
        }elseif ($role === 1){
            header("Location:/");
        }
    }

    public function switch_role(){
        $role = Session::get("roleID");
        if ($role === 1){//to be organizer
            $participant = new Participant();
            $participant->switch_role();
            Session::set("roleID",2);
            header('location:/');
        }elseif ($role === 2){
//            $organizer = new Orgnizer();
//            $organizer->switch_role();
            Session::set("roleID",1);
            header('location:/');
        }else{
            echo "You dont have permission";

        }
    }

    public function DownloadParticipantList($event_id,$type){
        $organizer = new Organizer();
        if ($type === "CSV"){
            $organizer->download_participants_list_csv($event_id);
            header('Location:/');
        }elseif ($type === "PDF"){
            $organizer->download_participants_list_pdf($event_id);
        }else{
            header('Location:/Auth/Login');
        }
    }


}