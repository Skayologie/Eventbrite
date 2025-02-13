<?php

namespace App\controllers;

use App\core\Session;
use App\mail\Mail;
use App\mail\WelcomeMail;
use App\models\Support;

class SupportController
{
    private Support $support;

    public function __construct(){
        $this->support = new Support();
    }
    public function sendMessage(){
        header('Content-Type: application/json');
        extract($_POST);
        $userID = intval(Session::get("userID"));

        if (empty($message) || empty($fullname) || empty($senderMail)){
            $return = [
                "status"=>false,
                "message"=>"There is a problem with your inputs ."
            ];
        }else{
            $result = $this->support->getInTouch($userID,$message,$fullname,$senderMail);
            if ($result){
                $return = [
                    "status"=>true,
                    "message"=>"Your Message has been sent successfully"
                ];
                $Email = new Mail();
                $Email->SupportRecieveMessage($senderMail,$fullname);
            }else{
                $return = [
                    "status"=>false,
                    "message"=>"Failed To send your message to us , please try again !",
                ];
            }
        }
        echo json_encode($return);
    }
}