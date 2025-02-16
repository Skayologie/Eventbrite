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

    // google

    public function findOrCreateByGoogleId($googleId, $userInfo)
    {
        $user = $this->findByGoogleId($googleId);

        if (!$user) {
            $user = new RegisteredUser();
            $user->setGoogleId($googleId);
            $user->setFirstName($userInfo['given_name']);
            $user->setLastName($userInfo['family_name']);
            $user->setEmail($userInfo['email']);
            $user->setProvider('google');
            $user->setIsVerified(1);
            $this->save($user);
        }

        return $user;
    }

    public function findByGoogleId($googleId)
    {
        $sql = "SELECT * FROM users WHERE google_id = :google_id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':google_id', $googleId, PDO::PARAM_STR);
        $stmt->execute();

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            $user = new RegisteredUser();
            $user->setUserId($userData['user_id']);
            $user->setFirstName($userData['first_name']);
            $user->setLastName($userData['last_name']);
            $user->setEmail($userData['email']);
            $user->setGoogleId($userData['google_id']);
            $user->setProvider($userData['provider']);
            $user->setIsVerified($userData['is_verified']);
            $user->setRoleId($userData['role_id']);

            return $user;
        }

        return null;
    }


}
