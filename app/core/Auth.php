<?php
namespace App\core;



use PDO;

class Auth
{
    private Model $CRUD;
    public function __construct(){

    }

    public function index($type){
        $isAuth = Session::get("isAuth");
        if ($isAuth){
            header("Location:/");
            return;
        }
        if ($type === "Login"){
            View::render("front/AuthPage",["type"=>"false"]);
        }else if($type === "Register"){
            View::render("front/AuthPage",["type"=>"true"]);
        }else{
            View::render("layouts/404",["type"=>"true"]);
        }
    }
    public function register()
    {

    }
    public function login($email , $password)
    {
        $res = "hello this is your email, $email";
        return $res;
    }
    public function logout(){
        session_destroy();
        header("location:/Auth/Login");
    }
}


