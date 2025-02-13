<?php

namespace App\Models;

use PDO;
use App\core\Database;
class comments {
    private $db;

    public function __construct() {
        $db = new Database();
        $this->db = $db->getConnection();
    }

    // Ajouter un commentaire
    public function addComment($eventId, $userId, $comment_content) {
        $sql = "INSERT INTO comments (event_id, user_id, comment_content, commented_at) VALUES (:event_id, :user_id, :comment_content, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':event_id' => $eventId,
            ':user_id' => $userId,
            ':comment_content' => htmlspecialchars($comment_content)
        ]);
    }

    
    // get les commentaire  
    public function getCommentsByEvent($eventId) {
        $sql = "SELECT c.comment_id, c.comment_content, c.commented_at, u.fname as author FROM comments c 
                JOIN users u ON c.user_id = u.id WHERE c.event_id = :event_id ORDER BY c.commented_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':event_id' => $eventId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


 // Modifier un commentaire 
 public function updateComment($commentId, $userId, $content) {
    $sql = "UPDATE comments SET comment_content = :comment_content WHERE comment_id = :comment_id AND user_id = :user_id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        ':comment_content' => htmlspecialchars($content),
        ':comment_id' => $commentId,
        ':user_id' => $userId
    ]);
}

   // Supprimer un commentaire 
   public function deleteComment($commentId, $userId, $isAdmin) {
    $sql = $isAdmin ? "DELETE FROM comments WHERE comment_id = :comment_id" : "DELETE FROM comments WHERE comment_id = :comment_id AND user_id = :user_id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute($isAdmin ? [':comment_id' => $commentId] : [':comment_id' => $commentId, ':user_id' => $userId]);
}

}

// CREATE TABLE `comments` (
//     `comment_id` int(11) NOT NULL,
//     `user_id` int(11) DEFAULT NULL,
//     `event_id` int(11) DEFAULT NULL,
//     `comment_content` varchar(255) DEFAULT NULL,
//     `commented_at` datetime DEFAULT current_timestamp()
//   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
// CREATE TABLE `users` (
//     `user_id` int(11) NOT NULL,
//     `fname` varchar(255) DEFAULT NULL,
//     `lname` varchar(255) DEFAULT NULL,
//     `email` varchar(255) NOT NULL,
//     `password` varchar(255) NOT NULL,
//     `status` enum('active','suspend') DEFAULT 'active',
//     `role_id` int(11) DEFAULT NULL,
//     `photo` varchar(255) DEFAULT NULL,
//     `birthdate` date DEFAULT NULL,
//     `bio` varchar(255) DEFAULT NULL,
//     `joined_at` timestamp NOT NULL DEFAULT current_timestamp()
//   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
  