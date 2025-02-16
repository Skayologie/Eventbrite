<?php
namespace App\models;
require_once __DIR__.'/../../vendor/autoload.php';

use App\core\Database;
use App\Core\Model;
use PDO;

class Category extends Model {
    protected $table = 'categories';

    public function __construct() {
        parent::__construct();
    }



    public function showCategorie() {
        $sql = "SELECT categories.categorie_id , categories.categorie_name ,COUNT(*) AS Categorie_Count FROM events JOIN categories ON categories.categorie_id = events.event_category GROUP BY categories.categorie_name";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function showAllCategories() {
        $sql = "SELECT * FROM categories";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function addCategorie($data) {
        return parent::add($this->table , ["categorie_name"] , $data);
    }

    public function updateCategorie($id, $data) {
        return parent::update($this->table, $id, $data);
    }

    public function deleteCategory($id) {
        return parent::delete($this->table, $id,"categorie_id");
    }
    public function findCategoryById($id) {
        return parent::find($this->table, $id);
    }

    public function findCategoryBy($conditions) {
        return parent::findBy($this->table, $conditions);
    }

    public function findAllCategoriesBy($conditions) {
        return parent::findAllBy($this->table, $conditions);
    }

    public function countCategories() {
        return parent::count($this->table);
    }

    public function categoryExists($conditions) {
        return parent::exists($this->table, $conditions);
    }
}

