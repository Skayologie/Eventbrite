<?php

namespace App\models;

use App\core\Database;
use App\core\Session;
use Cassandra\Date;
use PDO;


class Notification{
    private $db;

    public function __construct() {
        $db = new Database();
        $this->db = $db->getConnection();
    }

    public function addNotification($message,$reciever_id,$type='site'){
        $notification_time = date(DATE_RFC2822);;
        $user_id = Session::get("userID");
        $query= "INSERT INTO notifications(user_id, notification_message, notification_time, is_read,reciever_id) VALUES (?,?,?,0,?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$user_id,$message,$notification_time,$reciever_id]);
        return $this->db->lastInsertId();
    }

    public function getNotification($userId,$limit=10){
        $query="SELECT * FROM notifications  WHERE user_id = :user_id ORDER BY created_at  DESC LIMIT :limit ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':user_id' => $userId,
            ':limit' => $limit
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    //Marque une notification comme lue
    public function markAsRead($notificationId) {
        $query = "UPDATE notifications SET is_read = TRUE WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $notificationId]);
    }

    public function sendEmailNotification($userId, $message) {
        $userQuery = "SELECT email FROM users WHERE id = :id";
        $userStmt = $this->db->prepare($userQuery);
        $userStmt->execute([':id' => $userId]);
        $user = $userStmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $to = $user['email'];
            $subject = "Nouvelle notification";
            $headers = "From: no-reply@eventbrite-clone.com\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            // Envoyer l'email
            mail($to, $subject, $message, $headers);

            // Enregistrer la notification dans la base de données
            $this->addNotification($userId, $message, 'email');
        }
    }
}