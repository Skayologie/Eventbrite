<?php 
namespace App\models;

use App\core\Auth;
use App\core\Database;
use App\core\Model;
use PDO;
use PDOException;

class Event{

    private $event_id;
    private $user_id;
    private $title;
    private $thumbnail;
    private $category_id;
    private $region;
    private $city;
    private $address;
    private $link;
    private $description;
    private $date_and_time;
    private $event_type;
    private $status;
    private $price;
    private $dicount_code;
    private $event_places;
    private $available_places;
    private $created_at;

    private $pdo;
    private $model;

    public function __construct() {
        $DB = new Database();
        $this->pdo = $DB->getConnection();
        $this->model = new Model($this->pdo);
    }

    public function addEvent($event_creator,$event_title,$event_description,$event_city,$event_link,$event_price,$event_address,$event_capacity,$event_category,$event_type,$event_status,$event_date,$available_seats,$thumbnail,$promo_code){
        $table = 'events';
        $date = $event_date[0];
        $columns = ["event_creator","event_title","event_description","event_city","event_link","event_price","event_address","event_capacity","event_category","event_type","event_status","event_date","available_seats","thumbnail","promo_code"];
        $values  = [$event_creator,$event_title,$event_description,$event_city,$event_link,$event_price,$event_address,$event_capacity,$event_category,$event_type,$event_status,$date,$available_seats,$thumbnail,$promo_code];

        return $this->model->Add($table, $columns, $values);
    }

    public function updateEvent($event_id,$event_creator,$event_title,$event_description,$event_city,$event_region,$event_link,$event_price,$event_address,$event_capacity,$event_category,$event_type,$event_status,$event_date,$created_at,$promo_code,$available_seats,$thumbnail){
        $table = 'events';
        $data = [
            "event_id"=>$event_id,
            "event_creator"=>$event_creator,
            "event_title"=>$event_title,
            "event_description"=>$event_description,
            "event_region"=>$event_region,
            "event_city"=>$event_city,
            "event_address"=>$event_address,
            "event_link"=>$event_link,
            "event_price"=>$event_price,
            "event_capacity"=>$event_capacity,
            "event_category"=>$event_category,
            "event_type"=>$event_type,
            "event_status"=>$event_status,
            "event_date"=>$event_date,
            "created_at"=>$created_at,
            "promocode"=>$promo_code,
            "available_seats"=>$available_seats,
            "thumbnail"=>$thumbnail
        ];

        return $this->model->Edit($event_id, $table, $data);
    }

    
    public function deleteEvent($event_id) {
        $conn = $this->pdo;
        $sql = "DELETE FROM events WHERE event_id = :event_id";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':event_id' => $event_id]);
    }


    public function show_events($conditions = []) {
        $query = "SELECT events.*, users.fname as creator_name, categories.categorie_name as category_name, users.photo FROM events INNER JOIN users ON users.user_id = events.event_creator LEFT JOIN categories ON categories.categorie_id = events.event_category LEFT JOIN ville ON events.event_city = ville.id";
        if (!empty($conditions)) {
            $whereConditions = [];
            foreach ($conditions as $key => $val) {
                $whereConditions[] = "$key = ?";
            }
            $query .= " WHERE " . implode(" AND ", $whereConditions);
        }
    
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array_values($conditions));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function search_events($searchTerm) {
        $query = "SELECT events.*, users.fname as event_creator, categories.categorie_name as category_name, users.photo
            FROM events
            LEFT JOIN users ON users.user_id = events.event_creator
            LEFT JOIN categories ON categories.categorie_id = events.event_category
            LEFT JOIN ville ON events.event_city = ville.id
            WHERE events.event_title LIKE ?";
        
        $searchTermWithWildcards = "%" . $searchTerm . "%";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$searchTermWithWildcards]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    


    public function report_event($event_id, $user_id, $report_description) {
        $query = "INSERT INTO reports (event_id, user_id, report_reason, report_description, created_at)
                  VALUES (?, ?, ?, NOW())";
        
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute([$event_id, $user_id,$report_description]);
        
        return $result;
    }


    
    

}

