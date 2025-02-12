<?php
namespace App\controllers;

require_once __DIR__ . '/../../vendor/autoload.php';


use App\Models\TicketModel;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\core\View;

class PaymentController
{
    private $ticketModel;
    public function __construct(){
        
        $this->ticketModel=new TicketModel();

    }
      public function index(){
        View::render("front/events",[
            "title"=>"Home",
            "event"=>[
                "id"=>"1",
                "price"=>"22",
            ],
            "id"=>2
        ]);
      }

    public function checkout($eventId,$userId,$quantity,$pricePerTicket){
        Stripe::setApikey('sk_test_51QqwsCKabufyYHDhhkwGsNPRFcskyaFR2FcAQGvRkzhzeaf7nCmzSX9RM43aIuRlkCgUmeYbk9mVw9slhMoNRWJP00dU51vbNx');


        $totalPrice = $pricePerTicket * $quantity * 100; // Stripe utilise les centimes
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
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
        header("Location: " . $session->url);
        exit();
    }

    public function success(){
        Stripe::setApiKey('sk_test_51QqwsCKabufyYHDhhkwGsNPRFcskyaFR2FcAQGvRkzhzeaf7nCmzSX9RM43aIuRlkCgUmeYbk9mVw9slhMoNRWJP00dU51vbNx');
        $session_id= $_SESSION['SessionPayment']  ?? '' ;
        $eventId = $eventId ?? '';
        $userId = $user_id ?? '';
        $quantity = $quantity ?? '';
        $totalPrice = $totalPrice ?? '';
        $session = Session::retrieve($session_id);
        var_dump($session);
        if ($session && $session->payment_status === 'paid') {
            // Enregistrer le ticket dans la base de données après paiement réussi
            $this->ticketModel->createTicket($eventId, $userId, $quantity, $totalPrice / 100, $session_id);
            echo "Paiement réussi !  Votre billet est confirmé.";
        } else {
            echo "Erreur de paiement .";
        }
    }
        public function cancel(){
            echo "Failed";
        }
    }
    
