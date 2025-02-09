<?php

namespace App\models;

use App\core\Auth;
use App\core\Database;
use App\core\Model;

class RegisteredUser extends User
{
    private $Auth;
    private Model $CRUD;

    public function __construct()
    {
        $this->Auth = new Auth();
        $database = new Database();
        $this->CRUD = new Model($database->getConnection());
    }
    public function register()
    {
        // TODO: Implement register() method.
        $hashedPassword = password_hash($this->password,PASSWORD_BCRYPT);
    }
}