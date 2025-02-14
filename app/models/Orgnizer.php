<?php
namespace App\models;

use App\core\Database;
use App\core\Model;
use App\models\User;
use PDO;
use Vendor\setasign\fpdf\FPDF;


class Organizer extends User {

    private $pdo;
    private $model;

    public function __construct() {
        $DB = new Database();
        $this->pdo = $DB->getConnection();
        $this->model = new Model($this->pdo);
    }

    public function switch_role($user_id) {
        $data = ['role' => '1'];
        $table = 'users';
        return $this->model->Edit($user_id, $table, $data);
    }
    

    public function download_participants_list_csv($event_id) {
        $query = "SELECT tickets.*, users.name as participant_name, users.email as participant_email, events.event_title, 
                  FROM tickets
                  LEFT JOIN users ON users.user_id = tickets.user_id
                  LEFT JOIN events ON events.event_id = tickets.event_id
                  WHERE tickets.event_id = ?";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$event_id]);
        $participants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // this is to create the content will be shown in the csv file 
        $csvContent = "Ticket ID,Participant Name,Participant Email,Event Title\n";
        foreach ($participants as $participant) {
            $csvContent .= "{$participant['event_id']},{$participant['participant_name']},{$participant['participant_email']},{$participant['event_title']}\n";
        }

        // to donlad the csv file
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="participants_list.csv"');
        echo $csvContent;
        exit();
    }

    public function download_participants_list_pdf($event_id) {
        $query = "SELECT tickets.*, users.name as participant_name, users.email as participant_email, events.event_title
                  FROM tickets
                  LEFT JOIN users ON users.user_id = tickets.user_id
                  LEFT JOIN events ON events.event_id = tickets.event_id
                  WHERE tickets.event_id = ?";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$event_id]);
        $participants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Initialize FPDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);

        // Add title
        $pdf->Cell(0, 10, 'Participants List for " '. $participants[0]['event_title'].'"', 0, 1, 'C');
        $pdf->Ln(10);

        // Add table headings
        $pdf->Cell(50, 10, 'Ticket ID', 1);
        $pdf->Cell(60, 10, 'Participant Name', 1);
        $pdf->Cell(80, 10, 'Participant Email', 1);
        $pdf->Ln();

        // Add data to table
        $pdf->SetFont('Arial', '', 10);
        foreach ($participants as $participant) {
            $pdf->Cell(50, 6, $participant['ticket_id'], 1);
            $pdf->Cell(60, 6, $participant['participant_name'], 1);
            $pdf->Cell(80, 6, $participant['participant_email'], 1);
            $pdf->Ln();
        }

        // Output the PDF
        $pdf->Output('D', 'participants_list.pdf');
        }
}
