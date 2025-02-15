<?php

namespace App\mail;

use App\models\RegisteredUser;
use Dotenv\Dotenv;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
$dotenv = Dotenv::createImmutable(__DIR__."/../../");
$dotenv->load();
class Mail
{
    private PHPMailer $mail;
    private $email;


    public function __construct($email)
    {
        $this->email = $email;
        $this->mail = new PHPMailer();
        try{
            $this->mail->isSMTP();                                            //Send using SMTP
            $this->mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $this->mail->Username   = $_ENV["EMAIL_USERNAME"] ;                     //SMTP username
            $this->mail->Password   = $_ENV["EMAIL_PASSWORD"] ;                               //SMTP password
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $this->mail->Port       = 465;
        }catch(Exception $e){
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
    public function Send(RegisteredUser $user){

        try {
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
    public function SupportRecieveMessage($email , $fullname){
        try {
            //Recipients
            $this->mail->setFrom('Eventbrite@gmail.com', 'EventBrite | Support');
            $this->mail->addAddress($email);               //Name is optional

            //Content
            $this->mail->isHTML(true);                                  //Set email format to HTML
            $this->mail->Subject = 'Hello ' . $fullname ;
            $this->mail->Body    = 'We recieved your message , We will respond within 24h .<br> <b>With all respect !</b>';
            $this->mail->AltBody = 'This is the test';

            $this->mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }


    public  function sendTicket($ArrayPDFS){

        try {
            // Sender & Recipient
            $this->mail->setFrom('Eventbrite@example.com', 'EventBrite | Get Your Tickets');
            $this->mail->addAddress($this->email); // Change recipient

            // Email Content
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Your Event Ticket';
            $this->mail->Body = 'Hello, <br> Please find your ticket attached.';

            foreach ($ArrayPDFS as $fileName) {
                $pdfPath = __DIR__ . "/../../public/assets/tickets/ticket_" . $fileName.".pdf";

                if (file_exists($pdfPath)) {
                    $this->mail->addAttachment($pdfPath);
                } else {
                    error_log("File not found: " . $pdfPath);
                }
            }

            if ($this->mail->send()){
                echo "Email sent successfully!";
            } else {
                echo "Mailer Error: " . $this->mail->ErrorInfo;
            }
        } catch (Exception $e) {
            echo "Email sending failed: {$this->mail->ErrorInfo}";
        }
    }

}