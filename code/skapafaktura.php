<?php 
if (!isset($_SESSION)) { session_start(); }

include_once "config.php";
include_once "objHyra.php";
include_once "dbmanager.php";
include_once "fpdfnormalize.php";

require "managesession.php";


$pdf = new FPDF();

$fontOcrb = 'ocrb regular';
$fontToUse = 'ARIAL';

$sizeOcrb = "7";
$sizeOcrbRubrik = "6";
$attBetala = 1001;

$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont($fontToUse,'B',10);


/*********************************SKRIVER TALONG********************************* */

$pdf->SetLineWidth(0.3);
$pdf->Line(0,210,250,210); // en rak linje. ÖVERSTA LINJEN PÅ TALONGEN!

$pdf->Text(122, 208, 'INBETALNING GIRERING / AVI');
$pdf->SetFont($fontToUse,'',10);
$pdf->Text(20, 215, 'Följande belopp skall vara oss tillhanda senast : ' . "DUE DATE");

$pdf->Line(135,218,135,210); //vertikal linje Första vertikala i mellan översta linjerna
$pdf->Line(165,218,165,210); //vertikal linje

$pdf->SetFont($fontToUse,'',$sizeOcrbRubrik);
$pdf->Text(136, 212, 'Inbet avgvift (fylls av banken)');

$pdf->SetFont($fontToUse,'B',14);
$pdf->Text(180, 216, 'OCR');
$pdf->Line(0,218,250,218); // en rak linje. Andra övre linjen

$pdf->SetFont($fontToUse,'',10);

$pdf->Text(20, 230, 'Betalning gäller lokal');

$pdf->SetFont($fontToUse,'B',10);

$pdf->Text(20, 235,  "Specifikation text");



$pdf->Text(20, 250, "faktura nr");

$pdf->Text(120, 230, 'Betalningsavsändare');
$pdf->SetFont($fontToUse,'',9);
$pdf->Text(120, 235, "Kalle anka och knattarna");

//Info för bankgiro och betalningsmottagare!
$pdf->Line(105,255,105,265); //vertikal linje

$pdf->Line(105,255,210,255); // horizontell linje

$pdf->SetFont($fontOcrb,'',$sizeOcrbRubrik);
$pdf->Text(107, 257, 'Till bankgironr');
$pdf->SetFont($fontToUse,'',10);
$pdf->Text(109, 262, "Bankgiro");

// $pdf->SetFont($fontOcrb,'',$sizeOcrbRubrik);
$pdf->Line(135,255,135,257); //liten vertikal linje

$pdf->SetFont($fontOcrb,'',$sizeOcrbRubrik);
$pdf->Text(136,257, 'Betalningsmottagare');
$pdf->SetFont($fontToUse,'B',10);
$pdf->Text(136, 262, "Företagsnamn");

$pdf->Line(0,265,250,265); // en rak linje.
$pdf->SetFont($fontOcrb,'B',7);
$pdf->Text(20, 267, 'VAR GOD GÖR INGA ÄNDRINGAR');
$pdf->Text(80, 267, 'MEDDELANDE KAN INTE LÄMNAS PÅ AVIN');
$pdf->Text(155, 267, 'DEN AVLÄSES MASKINELLT');
$pdf->Line(0,268,250,268); // en rak linje. (Understa linjen)

$pdf->SetFont($fontOcrb,'',$sizeOcrb);
$pdf->Text(40, 270, 'OCR-referensnummer');

$pdf->Line(95,268,95,271); //liten vertikal linje under nedersta linjen 1
$pdf->Text(96, 270, 'Kronor');

$pdf->Line(117,268,117,271); //liten vertikal linje under nedersta linjen 2

$pdf->Line(128,268,128,271); //liten vertikal linje under nedersta linjen 3
$pdf->Text(118, 270, 'Öre');

$pdf->SetFont($fontOcrb,'',10);
$pdf->Text(38, 278, '#');

$pdf->Text(95, 278, '#');

$pdf->Text(103, 278, number_format($attBetala, 2, ' ', ' ')); //BELOPP LÄNGST NER PÅ TALONG!



//$pdf->text(118, 278, '00');

$pdf->Text(203, 278, '#'); //17 mm upp från nederkant!


/*********************************SKRIVER AB INFO ************************************** */
$pdf->SetFont($fontToUse, 'B', 8);
$pdf->Text(15, 50, 'Fakturanummer:'); $pdf->Text(39, 50, "fakturanr");
$pdf->Text(15, 54, 'Fakturadatum:'); $pdf->Text(39, 54, "Faktura datum");
$pdf->Text(15, 58, 'Avsändare:'); $pdf->Text(39, 58, "avsändare");
$pdf->Text(15, 62, 'Org.nr:'); $pdf->Text(39, 62, "orgNr");
$pdf->Text(15, 66, 'Telefon:'); $pdf->Text(39, 66, '0707-954165');
$pdf->Text(15, 70, 'Epost:'); $pdf->Text(39, 70, "epost");

/*********************************SKRIVER VALFRITT MEDDELANDE********************************* */

$pdf->Text(20, 120, 'Här kan Anders och Carolina skriva meddelanden till hyresgästerna');

/********************************spec moms ej moms ****************************************** */

$pdf->SetFont($fontToUse, 'B', 10);
$pdf->Text(20, 140, 'Netto'); 
$pdf->SetFont($fontToUse, '', 9);

$pdf ->Text(20, 145, number_format("10000", 2, ',', ' ') . " kr");


$pdf->SetFont($fontToUse, 'B', 10);
$pdf->Text(50, 140, 'Moms');

$pdf->SetFont($fontToUse, '', 9);

$pdf ->Text(50, 145, number_format(900, 2, ',', ' ')  .  " kr");


$pdf->SetFont($fontToUse, 'B', 10);
$pdf->Text(180, 140, 'Att betala');
$pdf->SetFont($fontToUse, '', 9);
$pdf ->Text(180, 145, number_format($attBetala, 2, ',', ' ') . " kr");     

/********************************************************************************************* */

/*********************************SKRIVER SPECIFIKATION********************************* */
$pdf->SetFont($fontToUse, 'B', 10);
$pdf->Text(20, 90, 'SPECIFIKATION');
$pdf->Text(180, 90, 'BELOPP');
$pdf->SetFont($fontToUse, '', 9);


$pdf->Text(22, 99, " -Hyra lokal: ");

//BELOPP kolumnen.
$pdf->Text(180, 99, "100 " . " kr"); 


$pdf->Text(22, 103, " -Fastighetskatt:");



//$fileName = "faktura.pdf";
//$pdf->Output($fileName, 'F');

//$db->spara_faktura($fileName, $fakturaId);

$pdf->Output();
?>