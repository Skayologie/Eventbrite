<?php
namespace App\core;

use App\core\Database;
use PDO;

require realpath(__DIR__ . "/../../vendor/autoload.php");
class Model
{
    private PDO $conn;

    public function __construct(Database $db){
        $this->conn = $db->getConnection();
    }

    public function Add($table, $columns, $values){
        try {
            $conn = $this->conn;
            $placeholders = implode(',', array_fill(0, count($values), '?'));
            $sql = "INSERT INTO " . $table . " (" . implode(',', $columns) . ") VALUES (" . $placeholders . ")";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute($values)) {
                $result = true;
            } else {
                $result = false;
            }
        }catch(\PDOException $e){
            $result = false;
        }
        return $result;
    }

    public function Get($table){
        $conn = $this->conn;
        $sql = "SELECT * FROM $table";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            return false;
        }
    }

    public function Edit($id,$table,$data){
        try {
            $conn = $this->conn;
            $args = array();

            foreach ($data as $key => $value) {
                $args[] = "$key = ?";
            }
            $sql = "UPDATE $table SET " . implode(',', $args) . " WHERE id = $id";
            $stmt = $conn->prepare($sql);
            $result =  $stmt->execute(array_values($data));
        } catch (\PDOException $th) {
            $result = $th->getMessage();
        }
        return $result;
    }

}