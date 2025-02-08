<?php
namespace App\core;



use PDO;

class Auth
{
    private PDO $db;
    public function __construct(){
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function index(){
        View::render("front/AuthPage",[]);
    }
    public function register($name , $email , $password)
    {

    }
    public function login($email , $password)
    {

    }
    public function logout(){
        session_destroy();
    }
}


