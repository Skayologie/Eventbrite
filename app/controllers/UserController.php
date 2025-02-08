<?php

namespace App\controllers;

use App\core\Auth;
use App\core\Database;

class UserController
{
    private $db;
    private $Auth;
    public function __construct(){
        $UserDatabase = new Database();
        $this->Auth = new Auth();
    }
    public function registerUser(){
        $this->Auth->register();
    }
}