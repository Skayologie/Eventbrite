<?php

namespace App\models;

use App\core\Auth;
use App\core\Database;
use App\core\Validator;
use DateTime;
use Exception;
use PDO;

abstract class User
{
    private int $user_id;
    private string $lastName;
    private string $firstName;
    private string $email;
    private string $status;
    private string $gender;
    protected string $role;
    private string $password;
    private string $photo;
    private string $birthdate;
    private string $bio;
    private DateTime $joined_at;
    private PDO $db;
    private Auth $Auth;


    public function __construct(string $firstName,string $lastName, string $email,  string $gender, string $role, string $password, string $photo, string $birthdate, string $bio)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->gender = $gender;
        $this->role = $role;
        $this->password = $password;
        $this->birthdate = $birthdate;
        $this->bio = $bio;
        $this->photo = $photo;
        $UserDatabase = new Database();
        $this->Auth = new Auth();
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function setEmail(string $email): void
    {
        $result = Validator::validate_email($email);
        if (!$result){
            throw new Exception("Invalid email format.");
        }
        $this->email = htmlspecialchars(strip_tags($email));
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }



    public function register(){
        $hashedPassword = password_hash($this->password,PASSWORD_BCRYPT);
        return $this->Auth->register($this->firstName,$this->lastName,$this->email,$this->gender,$hashedPassword,$this->photo,$this->birthdate,$this->bio);
    }

    public function login(){
        $result = $this->Auth->login($this->email,$this->password);
        return $result;
    }

    public function update_profile(){

    }

    public function show_user_info(){

    }

    public function contact_support(){

    }

    public function logout(){
        $this->Auth->logout();
    }


}