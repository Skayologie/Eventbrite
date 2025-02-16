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
        $this->CRUD = new Model();
        $this->db = $DB->getConnection();
    }


    public function suspendactiveUser($user_id,$option){
        return $this->CRUD->Edit($user_id, "users", ["status"=>$option],"user_id");
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

    public function getAllUsers(){
        $query = "SELECT * , CONCAT(fname,' ',lname) AS fullname , CONVERT(joined_at , time) AS TimeJoined ,CONVERT(joined_at , date) AS DateJoined FROM users;";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


}