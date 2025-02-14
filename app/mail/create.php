<?php

require 'vendor/autoload.php';

use Dompdf\Dompdf;

// Replace these values dynamically from your database
$eventId = "EVT-12345";
$titleId = "TIT-56789";
$ticketId = "TCK-98765";
$price = "50 USD";
$startDate = "2025-02-15";
$endDate = "2025-02-16";
$details = "VIP Access - Includes Free Drinks";

// Load the HTML template
$html = file_get_contents('ticket_template.html');

// Replace placeholders with actual values
$html = str_replace("{{eventId}}", $eventId, $html);
$html = str_replace("{{titleId}}", $titleId, $html);
$html = str_replace("{{ticketId}}", $ticketId, $html);
$html = str_replace("{{price}}", $price, $html);
$html = str_replace("{{startDate}}", $startDate, $html);
$html = str_replace("{{endDate}}", $endDate, $html);
$html = str_replace("{{details}}", $details, $html);
$html = str_replace("{{ticketId}}", urlencode($ticketId), $html); // QR Code URL

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Save PDF to file
$pdfPath = "tickets/ticket_$ticketId.pdf";
file_put_contents($pdfPath, $dompdf->output());

echo "PDF generated successfully: $pdfPath";
