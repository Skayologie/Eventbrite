<?php
namespace App\models;

use App\core\Database;
use App\core\Model;
use App\models\User;
use PDO;
use PDOException;

class Admin extends User {

    private $pdo;
    private $model;

    public function __construct() {
        $DB = new Database();
        $this->pdo = $DB->getConnection();
        $this->model = new Model($this->pdo);
    }


    public function ban_user($user_id){
        $query = "UPDATE users
                  SET status= 'suspend'
                  WHERE user_id = ?";

        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute([$user_id]);
        return $result;
        
    }

    public function delete_user($user_id){
        $query= "DELETE FROM users
                WHERE user_id= ? ";

        $stmt= $this->pdo->prepare($query);
        $result= $stmt->execute([$user_id]);
        return $result;

    }

    public function validate_event($id){
        
        $table="events";
        $data =["event_status"=>"accepted"];

        $this->model->Edit($id,$table,$data);
    }

    public function reject_event($id){
        
        $table="events";
        $data =["event_status"=>"rejected"];

        $this->model->Edit($id,$table,$data);
    }

    
}