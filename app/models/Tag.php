<?php
namespace App\models;


use App\core\Database;
use App\core\Model;

class Tag extends Model {
    private $table = 'Tag';

    public function __construct() {
        parent::__construct();
    }

   
    public function showTag() {
        return parent::Get($this->table);
    }

    public function addTag($data) {
        return parent::Add($this->table, ["tag_name"] , $data);
    }

    public function updateTags($id, $data) {
        return parent::Edit($id,$this->table , $data); // Appel de la méthode update du modèle parent
    }

    public function deleteTag($id) {
        return parent::delete($this->table, $id);
    }

    public function deleteCourseTags($coursId) {
        $stmt = parent::$conn->prepare("DELETE FROM courstag WHERE cours_id = ?");
        return $stmt = $stmt->execute([$coursId]);
    }

    public function findTagById($id) {
        return parent::find($this->table, $id);
    }

    public function findTagBy($conditions) {
        return parent::findBy($this->table, $conditions);
    }

    public function findAllTagsBy($conditions) {
        return parent::findAllBy($this->table, $conditions);
    }

    public function countTags() {
        return parent::count($this->table);
    }

    public function tagExists($conditions) {
        return parent::exists($this->table, $conditions);
    }
}

