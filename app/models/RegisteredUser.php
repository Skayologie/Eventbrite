<?php

namespace App\models;

use App\core\Auth;
use App\core\Database;
use App\core\Model;

class RegisteredUser extends User
{
    private $Auth;
    private Model $CRUD;
    // google
    private int $user_id;
    private $googleId;
    private $provider;
    private $isVerified;

    public function __construct()
    {
        $this->Auth = new Auth();
        $database = new Database();
        $this->CRUD = new Model($database->getConnection());
    }
    public function register()
    {
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);
    }

    //  google
    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;
    }

    public function getGoogleId()
    {
        return $this->googleId;
    }

    public function setProvider($provider)
    {
        $this->provider = $provider;
    }

    public function getProvider()
    {
        return $this->provider;
    }

    public function setIsVerified($isVerified)
    {
        $this->isVerified = $isVerified;
    }

    public function getIsVerified()
    {
        return $this->isVerified;
    }
}
