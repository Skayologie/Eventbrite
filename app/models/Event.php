<?php 
namespace App\models;

use App\core\Auth;
use App\core\Database;
use App\core\Model;
use PDO;
use PDOException;

class Event{

    private $evetn_id;
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

    public function addEvent($event_id,$event_creator,$event_title,$event_description,$event_city,$event_link,$event_price,$event_address,$event_capacity,$event_category,$event_type,$event_status,$event_date,$created_at,$promo_code,$available_seats,$thumbnail){
        $table = 'events';
        $columns = ["event_id","event_creator","event_title","event_description","event_city","event_link","event_price","event_address","event_capacity","event_category","event_type","event_status","event_date","created_at","promo_code","available_seats","thumbnail"];
        $values = [$event_id,$event_creator,$event_title,$event_description,$event_city,$event_link,$event_price,$event_address,$event_capacity,$event_category,$event_type,$event_status,$event_date,$created_at,$promo_code,$available_seats,$thumbnail];

        return $this->model->Add($table, $columns, $values);
    }

    public function updateEvent(){
        
    }

}