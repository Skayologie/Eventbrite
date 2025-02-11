<?php

namespace App\mail;

use App\models\RegisteredUser;
use Dotenv\Dotenv;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
$dotenv = Dotenv::createImmutable(__DIR__."/../../");
$dotenv->load();
class WelcomeMail
{
    private PHPMailer $mail;


    public function __construct()
    {
        $this->mail = new PHPMailer();
    }
    public function Send(RegisteredUser $user){

        try {

            //Server settings
//            $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $this->mail->isSMTP();                                            //Send using SMTP
            $this->mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $this->mail->Username   = $_ENV["EMAIL_USERNAME"] ;                     //SMTP username
            $this->mail->Password   = $_ENV["EMAIL_PASSWORD"] ;                               //SMTP password
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $this->mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $this->mail->setFrom('Eventbrite@gmail.com', 'EventBrite');
            $this->mail->addAddress($user->getEmail());               //Name is optional

            //Content
            $this->mail->isHTML(true);                                  //Set email format to HTML
            $this->mail->Subject = 'Hello ' . $user->getFirstName() . ' , Welcome with us !';
            $this->mail->Body    = 'Welcme in our platform <b>With all respect !</b>';
            $this->mail->AltBody = 'This is the test';

            $this->mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }

}