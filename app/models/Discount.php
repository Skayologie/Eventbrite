<?php
namespace App\models;

use App\core\Auth;
use App\core\Database;
use App\core\Model;
use PDO;
use PDOException;

class Discount{
    private $discount_id;
    private $discount_name;
    private $discount_code;
    private $discount_percentage;
    private $expiring_date;
    private $pdo;

    public function __construct()
    {
        
    }

    public function addDiscount($code,$percentage,$expiring_date){
        $query="INSERT into promo_codes(code,discount,expiring_date)
                VALUES (:code,:percentage,:expiring_date)";

        $stmt= $this->pdo->prepare($query);
        $stmt->bindparam(":code",$code,PDO::PARAM_STR);

        $stmt->execute();

        $stmt->fetchAll(PDO::FETCH_ASSOC);
        return true;
    }

    public function updateDiscount($discountId){
        $query="UPDATE promo_codes
                SET code = 'Alfred Schmidt', discount = 'Frankfurt', expiring_date= :
                WHERE code_id = :code_id;";

        $stmt= $this->pdo->prepare($query);

        $stmt->execute();

        return true;
    }
        

}














?>