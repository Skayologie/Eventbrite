<?php
namespace App\Models;
require_once __DIR__.'/../../vendor/autoload.php';
use Config\Database;
use App\Core\Model;

class Category extends Model {
    protected $table = 'Categorie';
    protected $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

   
    public function showCategorie() {
        return parent::all($this->table);
    }

    public function addCategorie($data) {
        return parent::add($this->table, $data);
    }

    public function updateCategorie($id, $data) {
        return parent::update($this->table, $id, $data);
    }

    public function deleteCategory($id) {
        return parent::delete($this->table, $id);
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
?>
