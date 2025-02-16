<?php

namespace App\models;

use App\core\Auth;
use App\core\Database;
use App\core\Model;
use PDO;
use PDOException;

class Comment{

    private $comment_id;
    private $user_id;
    private $event_id;
    private $comment_content;
    private $commented_at;

    private $pdo;
    private $model;

    public function __construct(){
        $DB = new Database();
        $this->pdo = $DB->getConnection();
        $this->model = new Model($this->pdo);
    }

    public function add_comment($event_id, $comment_content, $user_id){
        $table = 'comments';
        $columns= ['user_id','event_id','comment_content','commented_at'];
        $values= [$user_id,$event_id,$comment_content,date('Y-m-d H:i:s')];

        return $this->model->Add($table, $columns, $values);

    }

    public function get_comments($event_id){
        $query="SELECT *, CONCAT(users.fname, ' ', users.lname) AS username from comments
                JOIN users ON comments.user_id = users.user_id
                WHERE comments.event_id = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(["$event_id"]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }





}