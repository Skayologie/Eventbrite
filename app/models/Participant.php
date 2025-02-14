<?php
namespace App\models;

use App\core\Database;
use App\core\Model;
use App\core\Session;
use App\models\User;
use App\core\interfaces\SwitchRole;
use PDO;
use PDOException;

class Participant extends User implements SwitchRole {

    private $pdo;
    private $model;

    public function __construct() {
        $DB = new Database();
        $this->pdo = $DB->getConnection();
        $this->model = new Model($this->pdo);
    }

    public function switch_role() {
        $user_id = Session::get("userID");
        $data = ['role' => 2];//to be organizer
        $table = 'users';
        return $this->model->Edit($user_id, $table, $data);
    }

    public function show_participants_list($event_id) {
        $query = "SELECT tickets.*, users.name as participant_name, events.event_title 
                  FROM tickets
                  LEFT JOIN users ON users.user_id = tickets.user_id
                  LEFT JOIN events ON events.event_id = tickets.event_id
                  WHERE tickets.event_id = ?";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$event_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}