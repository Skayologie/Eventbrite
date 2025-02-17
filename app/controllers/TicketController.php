<?php

namespace App\controllers;
use App\core\Model;
use App\core\Session;
use Dompdf\Dompdf;

class TicketController
{
    public function adapteTemplateHTML($event_id,$image,$ticketid){
        $Event = new Model();
        $Ticket = new Model();
        $eventinfo = $Event->GetCheck("events","event_id",$event_id)[0];
        // Replace these values dynamically from your database
        $AttachPdfs = [];
        $eventId = "#".$eventinfo["event_id"];
        $titleId = $eventinfo["event_title"];
        $ticketId = $ticketid;
        $price = $eventinfo["event_price"];
        $startDate = $eventinfo["event_date"];
        $startTime = $eventinfo["event_start_at"];
        $details = $eventinfo["event_type"];
        $venue = $eventinfo["event_address"];

        $html = file_get_contents('./assets/template/ticket_template.html');

        $html = str_replace("{{eventId}}", $eventId, $html);
        $html = str_replace("{{titleId}}", $titleId, $html);
        $html = str_replace("{{ticketId}}", $ticketId, $html);
        $html = str_replace("{{price}}", $price, $html);
        $html = str_replace("{{startDate}}", $startDate .' '. $startTime, $html);
        $html = str_replace("{{QrCode}}", $image, $html);
        $html = str_replace("{{details}}", $details, $html);
        $html = str_replace("{{venue}}", $venue, $html);
        $html = str_replace("{{Attendee}}", Session::get("email"), $html);
        $html = str_replace("{{ticketId}}", urlencode($ticketId), $html); // QR Code URL

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $SinglePath = "ticket_$ticketId.pdf";
        $pdfPath = "./assets/tickets/ticket_$ticketId.pdf";
        $AttachPdfs[]=$ticketId;
        file_put_contents($pdfPath, $dompdf->output());

        return $AttachPdfs;
    }
}