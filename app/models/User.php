<?php

namespace App\models;

use App\core\Auth;
use App\core\Database;
use DateTime;
use PDO;

abstract class User
{
    private int $user_id;
    private string $name;
    private string $email;
    private string $status;
    private string $gender;
    private string $role;
    private string $password;
    private string $photo;
    private string $birthdate;
    private string $bio;
    private DateTime $joined_at;
    private PDO $db;
    private Auth $Auth;

    public function __construct(){
        $UserDatabase = new Database();
        $this->Auth = new Auth();
    }
    public function registerUser(){
        $this->Auth->register();
    }


    public function register(){

    }

    public function login(){

    }

    public function update_profile(){

    }

    public function show_user_info(){

    }

    public function contact_support(){

    }

    public function logout(){

    }


}