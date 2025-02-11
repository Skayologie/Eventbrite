<?php
namespace App\models;

use App\core\Auth;
use App\core\Database;
use App\core\Model;
use PDO;
use PDOException;

class Discount {
    private $discount_id;
    private $discount_name;
    private $discount_code;
    private $discount_percentage;
    private $expiring_date;
    private $pdo;
    private $model;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->model = new Model($pdo);
    }


    public function addDiscount($code, $percentage, $expiring_date) {
        $table = 'promo_codes';
        $columns = ['code', 'discount', 'expiring_date'];
        $values = [$code, $percentage, $expiring_date];

        return $this->model->Add($table, $columns, $values);
    }

    
    public function updateDiscount($discountId, $code, $percentage, $expiring_date) {
        $table = 'promo_codes';
        $data = [
            'code' => $code,
            'discount' => $percentage,
            'expiring_date' => $expiring_date
        ];

        return $this->model->Edit($discountId, $table, $data);
    }

    
    public function deleteDiscount($discountId) {
        $conn = $this->pdo;
        $sql = "DELETE FROM promo_codes WHERE code_id = :code_id";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':code_id' => $discountId]);
    }

    
    public function getDiscounts() {
        return $this->model->Get('promo_codes');
    }

    
    public function getDiscountById($discountId) {
        $conn = $this->pdo;
        $sql = "SELECT * FROM promo_codes WHERE code_id = :code_id";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute([':code_id' => $discountId])) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function applyDiscount($price, $discountCode) {
        
        $discount = $this->model->GetCheck('promo_codes', 'code', $discountCode);
        if (!$discount) {
            return false;
        }

        $discountPercentage = $discount[0]['discount'];

        $discountedPrice = $price - ($price * ($discountPercentage / 100));
        return $discountedPrice;
    }
}
?>
