<?php
namespace App\core;

use App\core\Database;

use PDO;

require realpath(__DIR__ . "/../../vendor/autoload.php");


class Model
{
    protected PDO $conn;

    public function __construct(){
        $db = new Database();
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
            return $result;

        }catch(\PDOException $e){
            echo  $e->getMessage();
        }
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
    public function delete($table,$id ,$column="id"){
        $conn = $this->conn;
        $sql = "DELETE FROM $table WHERE $column = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
    public function exists($table, $conditions) {
        $conn = $this->conn;
        $where = [];
        foreach ($conditions as $key => $value) {
            $where[] = "$key = :$key";
        }
        $sql = "SELECT COUNT(*) AS total FROM $table WHERE " . implode(" AND ", $where);
        $stmt = $conn->prepare($sql);

        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC)['total'] > 0;
    }

    public function findBy($table, $conditions) {
        $conn = $this->conn;

        $where = [];
        foreach ($conditions as $key => $value) {
            $where[] = "$key = :$key";
        }
        $sql = "SELECT * FROM $table WHERE " . implode(" AND ", $where);
        $stmt = $conn->prepare($sql);

        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function find($table, $id){
        $conn = $this->conn;
        $sql="SELECT * FROM $table WHERE id= :id" ;
        try {
            $stmt = $conn->prepare($sql);
            // $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            $stmt->execute([':id' => $id]);
            $result =  $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            echo "Erreur SQL: " . $e->getMessage();
            return null;
        }
    }
    public function GetCheck($table , $Column , $Value){
        $conn = $this->conn;
        $sql = "SELECT * FROM $table WHERE $Column = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute([$Value])) {
            return $stmt->fetchAll();
        } else {
            return false;
        }
    }
}