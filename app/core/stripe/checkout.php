<?php


require __DIR__ ."/vendor/autoload.php";

$stripe_secret_key ="sk_test_51QqwsCKabufyYHDhhkwGsNPRFcskyaFR2FcAQGvRkzhzeaf7nCmzSX9RM43aIuRlkCgUmeYbk9mVw9slhMoNRWJP00dU51vbNx";

\Stripe\Stripe::setApiKey($stripe_secret_key);

$checkout_session= \Stripe\Checkout\Session::create(
    [
        "mode"=>"payment",
        "success_url"=>"http://localhost/STRIPT/success.php",
        "line_items"=> [
            [
                "quantity"=> 3,
                "price_data"=>[
                    "currency"=> "mad",
                    "unit_amount" => 2000,
                    "product_data"=> [
                        "name"=>"T_shirt"
                    ]
                ]
            ]

        ]
    ]
);
http_response_code(303);
header("Location: " . $checkout_session->url);
?>