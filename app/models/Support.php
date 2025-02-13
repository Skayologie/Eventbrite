<?php
namespace App\models;

use App\core\Database;
use App\core\Model;
use App\models\User;
use PDO;
use PDOException;

class Support extends User {
    private $message_id;
    private $user_id;
    private $message_content;
    private $pdo;
    private $model;

    public function __construct() {
        $DB = new Database();
        $this->pdo = $DB->getConnection();
        $this->model = new Model($this->pdo);
    }
    

    public function contactSupport($user_id, $message_content){
        $query = "INSERT INTO support (user_id, message_content)
                  VALUES (?,?)";
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute([$user_id,$message_content]);
        return $result;
        
    }


}