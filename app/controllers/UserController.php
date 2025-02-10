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
    public function register(){
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
                header("Location:Auth/Login");
            }else{
                header("Location:Auth/Register");
            }
        }catch (\Exception $e){
            Session::set("Error",$e->getMessage());
            $message = Session::get("Error");
            View::render("front/AuthPage",["message"=>$message]);
        }
    }

    public function login(){
        try {
            extract($_POST);

            $user = new RegisteredUser();
            $user->setEmail($Loginemail);

            $userModel = new UserModel();
            if ($userModel->check($user , $Loginpassword)){
                $result = $userModel->check($user , $Loginpassword);
                Session::set("userID",$result["id"]);
                Session::set("roleID",$result["role_id"]);
                Session::set("email",$result["email"]);
                Session::set("avatar",$result["photo"]);
                Session::set("isAuth",true);
                header("Location:../../");
            }else{
                Session::set("isAuth",false);
                header("Location:Auth/Login");
            }
        }catch (\Exception $e){
            Session::set("isAuth",false);
            Session::set("Error",$e->getMessage());
            $message = Session::get("Error");
          View::render("front/AuthPage",["message"=>$message]);
            header("Location:Auth/Login");
        }
    }
}