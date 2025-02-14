<?php

namespace App\core;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;


// Generate the QR code and output as an image
class Qr
{
    public function Generate($data)
    {
        return (new QRCode)->render($data);
    }
    public function QrCompare($data , ){

    }
}