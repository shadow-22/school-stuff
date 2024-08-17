<?php
require('functions/fpdf.php');
require_once 'core/init.php';
$user = new User();

class PDF extends FPDF
{
  // Page header
  function Header()
  {
      // Logo
      $this->Image('assets/img/logo.png',10,15,45);
      // Arial bold 15
      $this->SetFont('Arial','B',15);
      // Move to the right
      $this->Cell(80);
      // Title
      $this->Cell(30,10,'Ticket',0,1,'C');
      // Line break
      $this->Ln(20);
  }
}

if (isset($_GET['id'])) {
  $id = escape($_GET['id']);
  $dbh = new PDO('mysql:host='.Config::get('mysql/host').';'.
              'dbname='.Config::get('mysql/db'),
              Config::get('mysql/username'),
              Config::get('mysql/password'));
  $myusername = $user->data()->username;
  $stmt = $dbh->prepare("SELECT t.valid, t.number, a.price, a.eventname, a.start_date, a.end_date, a.description FROM `tickets` AS t INNER JOIN `activity` AS a ON t.activity_id = a.activity_id WHERE t.username = '$myusername' AND t.id = '$id'");
  $stmt->execute();
  $arrValues = $stmt->fetchAll(PDO::FETCH_ASSOC);
  // Instanciation of inherited class
  $pdf = new PDF();
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetFont('Times','',12);
  foreach ($arrValues as $row) {
    $pdf->Cell(0,10,'Event: '. $row["eventname"],0,1);
    $pdf->Cell(0,10,'Description: '. $row["description"],0,1);
    $pdf->Cell(0,10,'Ticket Number: '. $row["number"],0,1);
    $pdf->Cell(0,10,'Valid from: '. $row["start_date"],0,1);
    $pdf->Cell(0,10,'Valid until: '. $row["end_date"],0,1);
    $pdf->Cell(0,10,'---------------------------------------------------------------------------------------------------------------------------------------',0,1);
    $pdf->Cell(0,10,'Please print this ticket and show it at the entrance of the event. ',0,1);
  }

  $pdf->Output();
} else {
  Redirect::to('index.php');
}

?>
