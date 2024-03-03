
<?php 


if (!isset($_SESSION)) { session_start(); }
    
include_once "config.php";
include_once "objHyra.php";
include_once "dbmanager.php";
include_once "fpdfnormalize.php";

require "managesession.php";


$db = new DbManager();

$hyresgastId = 9;
//$betalaText = iconv('UTF-8', 'windows-1252', 'Följande belopp skall vara oss tillhanda senast :');
$hyresInfo = new HyresAvisering($hyresgastId);

if ($hyresInfo ->fakturaId == null){
    echo "<h1><i>Hyresgästen saknar fakturerings data!</i></h1>";
    return;
}

$pdf = new TextNormalizerFPDF($hyresInfo);

$attBetala = $hyresInfo->hyra + $hyresInfo->parkering;

$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('ARIAL','B',10);


/*********************************SKRIVER TALONG********************************* */

$pdf->SetLineWidth(0.3);
$pdf->Line(0,210,250,210); // en rak linje. Översta

$pdf->Text(119, 208, 'INBETALNING GIRERING / AVI');
$pdf->SetFont('ARIAL','',8);
$pdf->Text(20, 217, 'Följande belopp skall vara oss tillhanda senast : ' . $hyresInfo->dueDate);

$pdf->Line(135,220,135,210); //vertikal linje Första vertikala i mellan översta linjerna
$pdf->Line(165,220,165,210); //vertikal linje

$pdf->SetFont('ARIAL','',4);
$pdf->Text(136, 212, 'Inbet avgvift (fylls av banken)');

$pdf->SetFont('ARIAL','B',14);
$pdf->Text(180, 217, 'OCR');
$pdf->Line(0,220,250,220); // en rak linje. Andra övre linjen

$pdf->SetFont('ARIAL','',10);
$pdf->Text(20, 230, 'Betalning gäller lägenheten ');
$pdf->SetFont('ARIAL','B',10);
$pdf->Text(20, 235, "Lägenhet " . $hyresInfo->lagenhetNo . " " . $hyresInfo->fastighetNamn);

$pdf->Text(119, 230, 'Betalningsavsändare');
$pdf->SetFont('ARIAL','',8);
$pdf->Text(120, 235, $hyresInfo->fullname);

//Info för bankgiro och betalningsmottagare!
$pdf->Line(110,264,110,270); //vertikal linje
$pdf->Line(110,264,210,264); // horizontell linje

$pdf->SetFont('ARIAL','',4);
$pdf->Text(111, 266, 'Till bankgironr');
$pdf->SetFont('ARIAL','B',8);
$pdf->Text(111, 269, '5804-9156');

$pdf->SetFont('ARIAL','',4);
$pdf->Line(135,264,135,266); //liten vertikal linje
$pdf->Text(136,266, 'Betalningsmottagare');
$pdf->SetFont('ARIAL','B',8);
$pdf->Text(136, 269, 'Anders Olof Selborn AB');

$pdf->Line(0,270,250,270); // en rak linje.
$pdf->SetFont('ARIAL','',8);
$pdf->Text(20, 273, 'VAR GOD GÖR INGA ÄNDRINGAR');
$pdf->Text(80, 273, 'MEDDELANDE KAN INTE LÄMNAS PÅ AVIN');
$pdf->Text(155, 273, 'DEN AVLÄSES MASKINELLT');
$pdf->Line(0,274,250,274); // en rak linje. (Understa linjen)

$pdf->SetFont('ARIAL','',4);
$pdf->Text(40, 276, 'OCR-referensnummer');

$pdf->Line(95,274,95,276); //liten vertikal linje under nedersta linjen 1
$pdf->Text(96, 276, 'Kronor');

$pdf->Line(117,274,117,276); //liten vertikal linje under nedersta linjen 2

$pdf->Line(128,274,128,276); //liten vertikal linje under nedersta linjen 3
$pdf->Text(118, 276, 'Öre');

$pdf->SetFont('ARIAL','',8);
$pdf->Text(38, 280, '#');

$pdf->Text(70, 280, '123456789123456');

$pdf->Text(95, 280, '#');

$pdf->Text(110, 280, $attBetala); //BELOPP

$pdf->text(117, 280, '00');

/*********************************SKRIVER AB INFO ************************************** */
$pdf->SetFont('ARIAL', 'B', 8);
$pdf->Text(15, 50, 'Fakturanummer:'); $pdf->Text(39, 50, '1234');
$pdf->Text(15, 54, 'Fakturadatum:'); $pdf->Text(39, 54, '2023-03-03');
$pdf->Text(15, 58, 'Avsändare:'); $pdf->Text(39, 58, 'Tryckaren 7 AB');
$pdf->Text(15, 62, 'Org.nr:'); $pdf->Text(39, 62, '559470-1939');
$pdf->Text(15, 66, 'Telefon:'); $pdf->Text(39, 66, '0707-954165');
$pdf->Text(15, 70, 'Epost:'); $pdf->Text(39, 70, 'fastighet@selborn.se');

/*********************************SKRIVER VALFRITT MEDDELANDE********************************* */

$pdf->Text(20, 120, 'Här kan Anders och Carolina skriva meddelanden till hyresgästerna');

/*********************************SKRIVER SPECIFIKATION********************************* */
$pdf->SetFont('ARIAL', 'B', 10);
$pdf->Text(20, 90, 'SPECIFIKATION');
$pdf->Text(180, 90, 'BELOPP');
$pdf->SetFont('ARIAL', '', 9);

$pdf->Text(20, 95, $hyresInfo->fastighetAddress . " ".  $hyresInfo->adress . " hyra för februari 2024");
$pdf->Text(22, 99, " -Hyra bostad: ");
$pdf->Text(180, 99, $hyresInfo->hyra . ",00" ); $pdf->Text(192, 99, "kr");



if ($hyresInfo->parkering != 0 ){
    $pdf->Text(22, 103, " -Hyra parkering:");
    $pdf->Text(180, 103, $hyresInfo->parkering . ",00" ); $pdf->Text(192, 103, "kr");
    $pdf->SetFont('ARIAL', 'B', 9);
    $pdf->Text(22, 110, " -Att betala:"); 
    $pdf->Text(180, 110, $attBetala . ",00"); $pdf->Text(192, 110, "kr");
} else {
    $pdf->SetFont('ARIAL', 'B', 9);
    $pdf->Text(22, 106, " -Att betala:"); 
    $pdf->Text(180, 106, $attBetala . ",00"); $pdf->Text(192, 106, "kr");
}

$fileName = "c:/temp/test.pdf";
$pdf->Output($fileName, 'F');

$db->spara_faktura($fileName, $hyresInfo->hyresgastId);

$pdf->Output();
?>