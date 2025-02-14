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

    public function createTicket($eventId, $userId, $promocode , $DataQrCode)
    {
        $sql = "INSERT INTO tickets (event_id, buyer_id , promo_code_id,QR_code) 
                VALUES (?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$eventId,$userId, $promocode,$DataQrCode]);
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

    public function getLastInsertedId()
    {
        return $this->db->lastInsertId();
    }


    public function updateTicketQrCode($ticketId, $qrCode , $uniqueCode , $QrCodeImg) {
        $sql = "UPDATE tickets SET QR_code = ? , TicketUnique = ? , QrCodeImg = ?  WHERE ticket_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$qrCode,$uniqueCode,$QrCodeImg,$ticketId]);
    }
}
