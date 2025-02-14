<?php

namespace App\controllers;
use App\core\Model;
use Dompdf\Dompdf;

class TicketController
{
    public function adapteTemplateHTML($event_id){
        $Event = new Model();
        $Ticket = new Model();
        $eventinfo = $Event->GetCheck("events","event_id",$event_id)[0];
        $tickets = $Ticket->GetCheck("tickets","event_id",$event_id);
        // Replace these values dynamically from your database
        $AttachPdfs = [];
        for($i = 0 ; $i < count($tickets) ; $i++){
            if($tickets[$i]["buyer_id"] === $_SESSION["userID"]){
                $eventId = "#".$eventinfo["event_id"];
                $titleId = $eventinfo["event_title"];
                $ticketId = $tickets[$i]["TicketUnique"];
                $price = $eventinfo["event_price"];
                $startDate = $eventinfo["event_date"];
                $QrCode = $tickets[$i]["QR_code"];
                $details = $eventinfo["event_type"];

// Load the HTML template
                $html = file_get_contents('./assets/template/ticket_template.html');

// Replace placeholders with actual values
                $html = str_replace("{{eventId}}", $eventId, $html);
                $html = str_replace("{{titleId}}", $titleId, $html);
                $html = str_replace("{{ticketId}}", $ticketId, $html);
                $html = str_replace("{{price}}", $price, $html);
                $html = str_replace("{{startDate}}", $startDate, $html);
                $html = str_replace("{{QrCode}}", $QrCode, $html);
                $html = str_replace("{{details}}", $details, $html);
                $html = str_replace("{{ticketId}}", urlencode($ticketId), $html); // QR Code URL

// Generate PDF
                $dompdf = new Dompdf();
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();

// Save PDF to file
                $SinglePath = "ticket_$ticketId.pdf";
                $pdfPath = "./assets/tickets/ticket_$ticketId.pdf";
                $AttachPdfs[]=$SinglePath;
                file_put_contents($pdfPath, $dompdf->output());
            }

        }
        return $AttachPdfs;
    }
}