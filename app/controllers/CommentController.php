<?php
namespace App\controllers;

use App\core\Auth;
use App\core\Database;
use App\core\Model;
use App\core\Session;
use App\core\View;
use App\models\Event;
use App\models\Participant;
use App\models\RegisteredUser;
use App\models\User;
use App\models\UserModel;
use App\models\Comment;

class CommentController{
    private $comment_model;
    public function __construct()
    {
        $this->comment_model= new Comment; 
    }

    public function addComment($event_id){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $comment_content = $_POST['comment_content'];
            $user_id = $_SESSION['userID']; 

            
            $result = $this->comment_model->add_comment($event_id, $comment_content, $user_id);

            if ($result) {
                
                header("Location:/Event/$event_id");
                exit;
            } else {
                echo "Failed to add comment.";
            }
        } else {
            echo "Invalid request method.";
        }
    }


    public function delete_comment($event_id,$comment_id) {
        $user_id = $_SESSION['userID']; 

        // Get the comment to check ownership
        $comment = $this->comment_model->getCommentById($comment_id);

        // Check if the logged-in user is the owner of the comment
        if ($comment && $comment['user_id'] == $user_id) {

            $this->comment_model->deleteComment($comment_id);

            header("Location:/Event/$event_id");
            exit;
        } else {
            echo "You do not have permission to delete this comment.";
        }
    }
    }

