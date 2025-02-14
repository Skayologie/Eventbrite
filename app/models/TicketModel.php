<?php
namespace App\models    ;

use PDO;
use App\core\Database;
class TicketModel
{
    private $db;

    public function __construct()
    {
        $db = new Database();
        $this->db = $db->getConnection();
    }

    public function createTicket($eventId, $userId, $quantity, $totalPrice, $stripeSessionId)
    {
        $sql = "INSERT INTO tickets (event_id, buyer_id,promo_code_id,QR_code) 
                VALUES (:event_id, :buyer_id, :promo_code_id, :QR_code)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':event_id' => $eventId,
            ':user_id' => $userId,
            ':quantity' => $quantity,
            ':total_price' => $totalPrice,
            ':stripe_session_id' => $stripeSessionId
        ]);

        return $this->db->lastInsertId();
    }

    public function updateTicketStatus($stripeSessionId, $status)
    {
        $sql = "UPDATE tickets SET status = :status WHERE stripe_session_id = :stripe_session_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':status' => $status,
            ':stripe_session_id' => $stripeSessionId
        ]);
    }
}
