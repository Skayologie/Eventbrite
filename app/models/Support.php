<?php
namespace App\models;

use App\core\Database;
use App\core\Model;
use App\models\User;
use PDO;
use PDOException;

class Support {
    private $message_id;
    private $user_id;
    private $message_content;
    private PDO $pdo;
    private Model $model;

    public function __construct() {
        $DB = new Database();
        $this->pdo = $DB->getConnection();
        $this->model = new Model();
    }
    

    public function getInTouch($user_id, $message_content , $fullname , $sender_email){
        try {
            $query = "INSERT INTO support (user_id, message_content,fullname,sender_email) VALUES (?,?,?,?)";
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute([$user_id,$message_content, $fullname , $sender_email]);
            return $result;
        }catch(\Exception $e){
            echo $e->getMessage();
        }
    }



}