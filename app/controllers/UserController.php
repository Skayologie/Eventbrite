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

class UserController
{
    private $db;
    private $Auth;
    public function __construct(){
        $UserDatabase = new Database();
    }
    public function index(){
        View::render("back/users",[]);
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
                $result = $userModel->check($user , $Loginpassword);
                Session::set("userID",$result["id"]??"");
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
                    "message"=>"Failed , Informations incorrect !"
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
}