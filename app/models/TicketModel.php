<?php
namespace App\Models;

require_once __DIR__. '/../vendor/autoload.php';
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;

use PDOException;
use App\core\Database;
class TicketModel
{
    private $db;

    public function __construct()
    {
        $db = new Database();
        $this->db = $db->getConnection();
    }

    public function generateTicket($eventId,$buyerId,$buyerEmail,$buyerName,$promoCodeId){
        try
        {
            //verifie event existant
            $eventCheck=$this->db->prepare("SELECT * FROM events WHERE event_id=?");
            $eventCheck->execute([$eventId]);
            if ($eventCheck->rowCount() == 0) return ['success' => false, 'message' => "L'événement n'existe pas."];
           
            $buyerCheck=$this->db->prepare("SELECT * FROM user WHERE user_id=?");
            $buyerCheck->execute([$buyerId]);
            if ($eventCheck->rowCount() == 0) return ['success' => false, 'message' => "L'utilisateur  n'existe pas."];
           // virifie est deja user achte un tickes 

             $buyerCheck=$this->db->prepare("SELECT * FROM tickets WHERE ticket_id=?");
            $buyerCheck->execute([$eventId,$buyerId]);
            if ($eventCheck->rowCount() == 0) return ['success' => false, 'message' => "Vous avez déjà un ticket pour cet événement."];
         
              // Inserer le ticket 
              $stmt = $this->db->prepare("INSERT INTO tickets (event_id, buyer_id, promo_code_id) VALUES (?, ?, ?)");
              $stmt->execute([$eventId, $buyerId, $promoCodeId]);
              $ticketId = $this->db->lastInsertId();

              // genere Qr Code 

              $data="http://localhost/eventbrite-clone/verification.php?ticket_id=$ticketId";
              $qrCode=QrCode::create($data)
              ->setEncoding(new Encoding('UTF-8'))
              ->setErrorCorrectionLevel(ErrorCorrectionLevel::High)
              ->setSize(300)
              ->setMargin(10)
              ->setWriter(new PngWriter());

              // sauvegarder l'image de Qr code

              $qrCodePath ="qrcodes/ticket_$ticketId.png";
              file_put_contents($qrCodePath,$qrCode->writeString());
                 // Mettre à jour le ticket avec le QR Code
            $stmt = $this->db->prepare("UPDATE tickets SET QR_code = ? WHERE ticket_id = ?");
            $stmt->execute([$qrCodePath, $ticketId]);

        }
    catch (PDOException $e){
        return ['success' => false, 'message' => "Erreur : " . $e->getMessage()];
    
    }

}}