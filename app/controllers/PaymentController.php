<?php
namespace App\controllers;

require_once __DIR__ . '/../../vendor/autoload.php';


use App\core\Qr;
use App\mail\Mail;
use App\Models\TicketModel;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\core\View;

class PaymentController
{
    private $ticketModel;
private $event_id;
    public function __construct(){
        
        $this->ticketModel=new TicketModel();

    }
      public function index($price,$quantity,$event_id){
        View::render("front/events",[
            "title"=>"Home",
            "event"=>[
                "id"=>$event_id,
                "price"=>$price,
            ],
            "id"=>2,
            "quantity"=>$quantity
        ]);
      }

    public function checkout($eventId,$pricePerTicket,$quantity){
        function generateRandomString($length = 10) {
            return substr(bin2hex(random_bytes($length)), 0, $length);
        }
        Stripe::setApikey('sk_test_51QqwsCKabufyYHDhhkwGsNPRFcskyaFR2FcAQGvRkzhzeaf7nCmzSX9RM43aIuRlkCgUmeYbk9mVw9slhMoNRWJP00dU51vbNx');

        $_SESSION["UniqueCode"] = [];
        for($i = 1 ; $i<=$quantity;$i++){
            $UniqueCode = generateRandomString();
            $_SESSION["UniqueCode"][] = $UniqueCode;
        }

        $totalPrice = $pricePerTicket * $quantity * 100; // Stripe utilise les centimes
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'mad',
                    'product_data' => [
                        'name' => "Billet pour l'événement #$eventId",
                    ],
                    'unit_amount' => $pricePerTicket * 100,
                ],
                'quantity' => $quantity,
            ]],
            'mode' => 'payment',
            'success_url' => 'http://localhost:4444/payment/success',
            'cancel_url' => 'http://localhost:4444/payment/cancel',
        ]);

        function get_string_between($string, $start, $end){
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) return '';
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
        }

        $data = get_string_between($session->url,"pay/","#");
        $_SESSION['SessionPayment'] = $data;

        \App\core\Session::set("event_ID",$eventId);
        \App\core\Session::set("quantity",$quantity);
        header("Location: " . $session->url);
        exit();
    }

    public function success(){
        Stripe::setApiKey('sk_test_51QqwsCKabufyYHDhhkwGsNPRFcskyaFR2FcAQGvRkzhzeaf7nCmzSX9RM43aIuRlkCgUmeYbk9mVw9slhMoNRWJP00dU51vbNx');
        $session_id= $_SESSION['SessionPayment']  ?? '' ;
        $email= $_SESSION['email']  ?? '' ;
        $eventId = \App\core\Session::get("event_ID") ;
        $userId = \App\core\Session::get("userID") ?? '';
//        $quantity = 2;
//        $totalPrice = $totalPrice ?? '';
        $session = Session::retrieve($session_id);


        if ($session && $session['payment_status'] === 'paid') {
            $ciphering = "AES-128-CTR";
            $iv_length = openssl_cipher_iv_length($ciphering);
            $encryption_iv = random_bytes($iv_length); // Secure IV
            $encryption_key = "EventBrite";
            // Enregistrer le ticket dans la base de données après paiement réussi
            $promocode = 1;
            $TicketUniqueCodes = $_SESSION["UniqueCode"];
            $Atachmment = [];
            $Ticket = new TicketController();
            $qr = new Qr();
            foreach ($TicketUniqueCodes as $uniqueCode){
                $result = $this->ticketModel->createTicket($eventId, $userId, $promocode, null);
                if($result){
                    $ticketId = $this->ticketModel->getLastInsertedId();
                    $Data = "ticket_id = ". $ticketId ." , user_id = " . $userId . " , event_id = ". $eventId . " UniqueCode = ".$uniqueCode;
                    $DataQrCode = openssl_encrypt($Data,$ciphering,$encryption_key,0, $encryption_iv);
                    $image = $qr->Generate($DataQrCode);
                    $Ticket->adapteTemplateHTML($eventId,$image,$uniqueCode);
                    $this->ticketModel->updateTicketQrCode($ticketId, $DataQrCode , $uniqueCode ,$image);
                    $Atachmment[] = $uniqueCode;
                }
            }

            $mail = new Mail("dojaoualla@gmail.com");
            $mail->sendTicket($Atachmment);
        } else {
            echo "Erreur de paiement .";
        }
//        $qr = new Qr();
//        $image = $qr->Generate($Data);
//        echo '<img width="100" src="'. $image .'" alt="">';
    }
        public function cancel(){
            echo "Failed";
        }
    }
    
