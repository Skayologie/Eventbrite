<?php

namespace App\models;

use App\core\Auth;
use App\core\Database;
use App\core\Model;
use App\core\Session;
use App\core\Validator;
use DateTime;
use Exception;
use PDO;

class UserModel
{
    private PDO $db;
    private $CRUD;


    public function __construct()
    {
        $DB = new Database();
        $this->CRUD = new Model($DB->getConnection());
        $this->db = $DB->getConnection();
    }


    public function save(RegisteredUser $user)
    {
        $CRUD       = $this->CRUD;
        $fname      = $user->getFirstName();
        $lname      = $user->getLastName();
        $email      = $user->getEmail();
        $password   = $user->getPassword();
        $birthdate  = $user->getBirthdate();
        $bio        = $user->getBio();
        $roleID     = $user->getRoleid();
        return $CRUD->Add("users",["fname","lname","email","password","role_id","birthdate","bio"],[$fname,$lname,$email,$password,$roleID,$birthdate,$bio]);
    }

    public function check(RegisteredUser $user , $pass){
        $CRUD       = $this->CRUD;
        $result = $CRUD->GetCheck("users","email",$user->getEmail());
        if (count($result) > 0){
            $passwordGetted = $result[0]["password"];
            $passRes = password_verify($pass,$passwordGetted);
            if ($passRes){
                return $result[0];
            }else{
                Session::set("Error","Password incorrect !");
                return false;
            }
        }else{
            throw new Exception("Email incorecct");
        }
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