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
    protected string $lastName = "";
    protected string $firstName;
    protected string $email ;
    private string $status;
    private string $gender;
    protected int $roleid;
    protected string $password= "";
    private string $photo;
    private $birthdate ;
    private string $bio= "" ;
    private $joined_at;


    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @throws Exception
     */
    public function setEmail(string $email)
    {
        $result = Validator::validate_email($email);
        if (!$result){
            throw new Exception("Invalid email format.");
        }else{
            $this->email = htmlspecialchars(strip_tags($email));
        }
    }

    public function setPassword(string $password): void
    {
        $result = Validator::validate_password($password);
        if (!$result){
            throw new Exception("Invalid Password");
        }
        $hashedPassword = password_hash($password,PASSWORD_BCRYPT);
        $this->password = $hashedPassword;
    }

    public function getBirthdate()
    {
        return $this->birthdate;
    }

    public function setBirthdate($birthdate): void
    {
        $this->birthdate = $birthdate;
    }

    public function getBio(): string
    {
        return $this->bio;
    }

    public function setBio(string $bio): void
    {
        $this->bio = $bio;
    }


    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getEmail(): string
    {
        return htmlspecialchars(strip_tags($this->email));
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoleid()
    {
        return $this->roleid;
    }
    public function setRoleid($id)
    {
        $this->roleid = $id;
    }



    abstract public function register();



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