<?php
namespace App\core;



use PDO;

class Auth
{
    private Model $CRUD;
    public function __construct(){

    }

    public function index(){
        View::render("front/AuthPage",[]);
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
    }
}


