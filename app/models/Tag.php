<?php
namespace App\Models;
require_once __DIR__.'/../../vendor/autoload.php';
use Config\Database;
use App\Core\Model;

class Tag extends Model {
    private $table = 'Tag';
    private $conn; 

    public function __construct() {
        $this->conn = Database::getConnection();
    }

   
    public function showTag():array {
        return parent::all($this->table);
    }

    public function addTag($data) {
        return parent::add($this->table, $data);
    }

    public function updateTags($id, $data) {
        return parent::update($this->table, $id, $data); // Appel de la méthode update du modèle parent
    }

    public function deleteTag($id) {
        return parent::delete($this->table, $id);
    }

    public function deleteCourseTags($coursId) {
        $stmt = $this->conn->prepare("DELETE FROM courstag WHERE cours_id = ?");
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
?>
