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
                View::render("front/AuthPage",["message"=>"googx"]);
            }else{
                View::render("front/AuthPage",["message"=>"goodddgx"]);
            }
        }catch (\Exception $e){
            Session::set("Error",$e->getMessage());
            $message = Session::get("Error");
            View::render("front/AuthPage",["message"=>$message]);
        }
    }
//    public function loginUser()
//    {
//        $user = new Participant("jawad","jawadboulmal@gmail.com","man","hellow rodl","2003","hello");
//        echo $user->login();
//    }
}