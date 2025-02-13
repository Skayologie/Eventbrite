<?php

namespace app\models;
require_once __DIR__. '/../vendor/autoload.php';

use PDO;


class Notification{
    private $db;



// ajoute une notification 

public function addNotification($userId,$message,$type='site'){
    $query= "INSERT INTO notifications(user_id, message,type) VALUES (:user_id,message,type)";
    $stmt = $this->db->prepare($query);
    $stmt->execute([
        ':user_id' => $userId,
        ':message' => $message,
        ':type' => $type
    ]);
    return $this->db->lastInsertId();

}
// recupere notification

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
   // Récupérer l'email de l'utilisateur
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