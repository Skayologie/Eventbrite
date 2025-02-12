<?php
namespace App\models;
require_once __DIR__.'/../../vendor/autoload.php';

use App\core\Database;
use App\Core\Model;

class Category extends Model {
    protected $table = 'categories';

    public function __construct() {
        parent::__construct();
    }

   
    public function showCategorie() {
        return parent::Get($this->table);
    }

    public function addCategorie($data) {
        return parent::add($this->table, $data);
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

