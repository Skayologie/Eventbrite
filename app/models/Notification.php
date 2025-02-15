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

    public function addNotification($message,$type='site'){
        $notification_time = date("F j, Y, g:i a");;
        $user_id = Session::get("userID");
        $query= "INSERT INTO notification(notification_message, notification_time, is_read,receiver_id) VALUES (?,?,0,?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$message,$notification_time,$user_id]);
        return $this->db->lastInsertId();
    }

    public function getNotifications($userId){
        $query="SELECT * FROM notification WHERE receiver_id = ? ORDER BY notification_time DESC Limit 5";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
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