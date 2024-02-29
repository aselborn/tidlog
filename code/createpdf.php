
<?php 


if (!isset($_SESSION)) { session_start(); }
    
include_once "config.php";
include_once "dbmanager.php";
include_once "fpdfnormalize.php";

require "managesession.php";


$db = new DbManager();
$hyresgastId = 1;
//$betalaText = iconv('UTF-8', 'windows-1252', 'Följande belopp skall vara oss tillhanda senast :');

$hyra = $db->query("select h.fnamn, h.enamn, l.hyra, p.avgift, f.fakturanummer, f.fakturadatum, f.ocr, f.duedate, f.specifikation
	
from tidlog_fakutra f
	inner join tidlog_hyresgaster h on h.hyresgast_id = f.hyresgast_id
	inner join tidlog_lagenhet l on l.lagenhet_id = h.lagenhet_id 
	left outer join tidlog_parkering p on p.park_id = l.park_id 
where 
	h.hyresgast_id = ?", array($hyresgastId))->fetchAll();

foreach($hyra as $row)
{
    
    $dtdat = date_create($row["duedate"]);
    $dueDate = date_format($dtdat, "Y-m-d");
}

// Instanciation of inherited class
$pdf = new TextNormalizerFPDF('P', 'mm', 'A4');

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('ARIAL','',12);


$pdf->Line(0,210,250,210); // en rak linje.

// $pdf->SetX(10);
// $pdf->SetY(200);
$pdf->Text(120, 208, 'INBETALNING GIRERING / AVI');
$pdf->SetFont('ARIAL','',8);
$pdf->Text(20, 215, 'Följande belopp skall vara oss tillhanda senast : ' . $dueDate);

$pdf->Line(135,220,135,210);
$pdf->Line(165,220,165,210);

$pdf->SetFont('ARIAL','B',15);
$pdf->Text(180, 217, 'OCR');
$pdf->Line(0,220,250,220); // en rak linje.




$pdf->Line(0,270,250,270); // en rak linje.
$pdf->SetFont('ARIAL','',8);
$pdf->Text(20, 273, 'VAR GOD GÖR INGA ÄNDRINGAR');
$pdf->Text(80, 273, 'MEDDELANDE KAN INTE LÄMNAS PÅ AVIN');
$pdf->Text(155, 273, 'DEN AVLÄSES MASKINELLT');
$pdf->Line(0,274,250,274); // en rak linje.


$pdf->Output();
?>