<?php

namespace App\Controllers;

require_once __DIR__ . '/../../vendor/autoload.php'; // Charge Stripe via Composer


use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController
{
    public function Checkout(){
        stripe::setApiKey('sk_test_51QqwsCKabufyYHDhhkwGsNPRFcskyaFR2FcAQGvRkzhzeaf7nCmzSX9RM43aIuRlkCgUmeYbk9mVw9slhMoNRWJP00dU51vbNx');
    
    $session =Session::create([
       'payment_method_types'=>['card'],
       'line_items'=> [[
        'currency'=>'usd',
        'product_data'=>[
            'name'=>
        ]
       ]]

    ]);
    
    }
}