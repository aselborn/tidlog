
<?php 


if (!isset($_SESSION)) { session_start(); }
    
include_once "config.php";
include_once "objHyra.php";
include_once "dbmanager.php";
include_once "fpdfnormalize.php";

require "managesession.php";

if (!isset($_POST['faktura_id']))
{
    echo "FakturaId saknas!";
    return;
}

if (!isset($_POST['hyresgast_id']))
{
    echo "HyresgästId saknas.!";
    return;
}


$db = new DbManager();

  $fakturaId = $_POST['faktura_id'];
  $hyresgastId = $_POST["hyresgast_id"];

//    $fakturaId = 15;
//    $hyresgastId = 16;


//$betalaText = iconv('UTF-8', 'windows-1252', 'Följande belopp skall vara oss tillhanda senast :');
$hyresInfo = new HyresAvisering($hyresgastId, $fakturaId);

if ($hyresInfo ->fakturaId == null){
    echo "<h1><i>Hyresgästen saknar fakturerings data!</i></h1>";
    return;
}

$pdf = new TextNormalizerFPDF($hyresInfo);

$attBetala = $hyresInfo->hyra + $hyresInfo->parkering + $hyresInfo->fskatt + $hyresInfo->moms;

$fontOcrb = 'ocrb regular';
$fontToUse = 'ARIAL';

$sizeOcrb = "7";
$sizeOcrbRubrik = "6";

$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont($fontToUse,'B',10);


/*********************************SKRIVER TALONG********************************* */

$pdf->SetLineWidth(0.3);
$pdf->Line(0,210,250,210); // en rak linje. ÖVERSTA LINJEN PÅ TALONGEN!

$pdf->Text(122, 208, 'INBETALNING GIRERING / AVI');
$pdf->SetFont($fontToUse,'',10);
$pdf->Text(20, 215, 'Följande belopp skall vara oss tillhanda senast : ' . $hyresInfo->dueDate);

$pdf->Line(135,218,135,210); //vertikal linje Första vertikala i mellan översta linjerna
$pdf->Line(165,218,165,210); //vertikal linje

$pdf->SetFont($fontToUse,'',$sizeOcrbRubrik);
$pdf->Text(136, 212, 'Inbet avgvift (fylls av banken)');

$pdf->SetFont($fontToUse,'B',14);
$pdf->Text(180, 216, 'OCR');
$pdf->Line(0,218,250,218); // en rak linje. Andra övre linjen

$pdf->SetFont($fontToUse,'',10);
if ($hyresInfo->moms > 0 ){
    $pdf->Text(20, 230, 'Betalning gäller lokal');
} else {
    $pdf->Text(20, 230, 'Betalning gäller lägenheten ');
}

$pdf->SetFont($fontToUse,'B',10);

if ($hyresInfo->moms > 0){
    $pdf->Text(20, 235,  $hyresInfo->specifikation . " " . $hyresInfo->fastighetNamn);
} else {
    $pdf->Text(20, 235, "Lägenhet " . $hyresInfo->lagenhetNo . " " . $hyresInfo->fastighetNamn);
}


$pdf->Text(20, 250, $hyresInfo->fakturaNummer);

$pdf->Text(120, 230, 'Betalningsavsändare');
$pdf->SetFont($fontToUse,'',9);
$pdf->Text(120, 235, $hyresInfo->fullname);

//Info för bankgiro och betalningsmottagare!
$pdf->Line(105,255,105,265); //vertikal linje

$pdf->Line(105,255,210,255); // horizontell linje

$pdf->SetFont($fontOcrb,'',$sizeOcrbRubrik);
$pdf->Text(107, 257, 'Till bankgironr');
$pdf->SetFont($fontToUse,'',10);
$pdf->Text(109, 262, $hyresInfo->bankgiro);

// $pdf->SetFont($fontOcrb,'',$sizeOcrbRubrik);
$pdf->Line(135,255,135,257); //liten vertikal linje

$pdf->SetFont($fontOcrb,'',$sizeOcrbRubrik);
$pdf->Text(136,257, 'Betalningsmottagare');
$pdf->SetFont($fontToUse,'B',10);
$pdf->Text(136, 262, $hyresInfo->ftgnamn);

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

$pdf->Text(107, 278, $attBetala); //BELOPP

$pdf->text(118, 278, '00');

$pdf->Text(203, 278, '#'); //17 mm upp från nederkant!


/*********************************SKRIVER AB INFO ************************************** */
$pdf->SetFont($fontToUse, 'B', 8);
$pdf->Text(15, 50, 'Fakturanummer:'); $pdf->Text(39, 50, $hyresInfo->fakturaNummer);
$pdf->Text(15, 54, 'Fakturadatum:'); $pdf->Text(39, 54, $hyresInfo->fakturaDatum);
$pdf->Text(15, 58, 'Avsändare:'); $pdf->Text(39, 58, $hyresInfo->ftgnamn);
$pdf->Text(15, 62, 'Org.nr:'); $pdf->Text(39, 62, $hyresInfo->orgNr);
$pdf->Text(15, 66, 'Telefon:'); $pdf->Text(39, 66, '0707-954165');
$pdf->Text(15, 70, 'Epost:'); $pdf->Text(39, 70, $hyresInfo->fastighet_epost);

/*********************************SKRIVER VALFRITT MEDDELANDE********************************* */

//$pdf->Text(20, 120, 'Här kan Anders och Carolina skriva meddelanden till hyresgästerna');

/********************************spec moms ej moms ****************************************** */

$pdf->SetFont($fontToUse, 'B', 10);
$pdf->Text(20, 140, 'Netto'); 
$pdf->SetFont($fontToUse, '', 9);

if ($hyresInfo->moms > 0 )
{
    $pdf ->Text(20, 145, ($attBetala - $hyresInfo->moms - $hyresInfo->fskatt) . ",00 kr");
} else {
    $pdf ->Text(20, 145, $attBetala . ",00 kr");
}


$pdf->SetFont($fontToUse, 'B', 10);
$pdf->Text(50, 140, 'Moms');

$pdf->SetFont($fontToUse, '', 9);
if ($hyresInfo->moms > 0){
    $pdf ->Text(50, 145, $hyresInfo->moms .  " kr");
} else{
    $pdf ->Text(50, 145, "0,00 kr");
}


$pdf->SetFont($fontToUse, 'B', 10);
$pdf->Text(180, 140, 'Att betala');
$pdf->SetFont($fontToUse, '', 9);
$pdf ->Text(180, 145, $attBetala . ",00 kr");    

/********************************************************************************************* */

/*********************************SKRIVER SPECIFIKATION********************************* */
$pdf->SetFont($fontToUse, 'B', 10);
$pdf->Text(20, 90, 'SPECIFIKATION');
$pdf->Text(180, 90, 'BELOPP');
$pdf->SetFont($fontToUse, '', 9);

$pdf->Text(20, 95, $hyresInfo->fastighetAddress . " ".  $hyresInfo->adress . " " . $hyresInfo->specifikation);
if ($hyresInfo->moms > 0){
    $pdf->Text(22, 99, " -Hyra lokal: ");
} else {
    $pdf->Text(22, 99, " -Hyra bostad: ");
}

$pdf->Text(180, 99, $hyresInfo->hyra . ",00" ); $pdf->Text(194, 99, "kr");

if ($hyresInfo->fskatt > 0 )
{
    //OM Fastighetskatt!
    $pdf->Text(22, 103, " -Fastighetskatt:");
    $pdf->Text(180, 103, $hyresInfo->fskatt . ",00" ); $pdf->Text(194, 103, "kr");

    if ($hyresInfo->parkering != 0){
        $pdf->Text(22, 107, " -Parkering:");
        $pdf->Text(180, 107, $hyresInfo->parkering . ",00" ); $pdf->Text(194, 107, "kr");    
    }
} else {
    //OM inte fastighetskatt
    if ($hyresInfo->parkering != 0 ){
        $pdf->Text(22, 103, " -Hyra parkering:");
        $pdf->Text(180, 103, $hyresInfo->parkering . ",00" ); $pdf->Text(194, 103, "kr");
        $pdf->SetFont($fontToUse, 'B', 9);
        $pdf->Text(22, 110, " -Att betala:"); 
        $pdf->Text(180, 110, $attBetala . ",00"); $pdf->Text(194, 110, "kr");
    } else {
        $pdf->SetFont($fontToUse, 'B', 9);
        $pdf->Text(22, 106, " -Att betala:"); 
        $pdf->Text(180, 106, $attBetala . ",00"); $pdf->Text(194, 106, "kr");
    }
}



$fileName = "faktura.pdf";
$pdf->Output($fileName, 'F');

$db->spara_faktura($fileName, $fakturaId);

//$pdf->Output();
?>