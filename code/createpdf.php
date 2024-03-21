<?php 
if (!isset($_SESSION)) { session_start(); }

include_once "config.php";
include_once "objHyra.php";
include_once "objArtikel.php";
include_once "dbmanager.php";
include_once "fpdfnormalize.php";
include_once "pdflayout.php";

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

    //   $fakturaId = 35;
    //   $hyresgastId = 48;




$useArtikelData = false;
$useOnlyArtikelData = false;

$artikel = new Artikel($hyresgastId);

if ($artikel->artikel != null)
{
    $useArtikelData = true;
    $useOnlyArtikelData = $artikel->med_hyra == true ? false :true;
}

$hyresInfo = new HyresAvisering($hyresgastId, $fakturaId);
if ($hyresInfo->fakturaId == null){
    echo "<h1><i>Hyresgästen saknar fakturerings data!</i></h1>";
    return;
}


$pdf = new TextNormalizerFPDF($hyresInfo, $artikel);

$attBetala = $hyresInfo->hyra + $hyresInfo->parkering + $hyresInfo->fskatt + $hyresInfo->moms;
$thousandLength = strlen($attBetala);

$fontOcrb = 'ocrb regular';
$fontToUse = 'ARIAL';

$sizeOcrb = "7";
$sizeOcrbRubrik = "6";

$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont($fontToUse,'B',10);

$pdfLayout = new Pdflayout($pdf, $fontToUse, $hyresInfo);

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



if ($useOnlyArtikelData)
{
    $pdfLayout->talongSpecifikationArtikel($artikel);
} else {
    $pdfLayout->talongSpecifikation();
}

// $pdf->SetFont($fontToUse,'B',10);

// if ($hyresInfo->moms > 0){
//     $pdf->Text(20, 235,  $hyresInfo->specifikation . " " . $hyresInfo->fastighetNamn);
// } else {
//     $pdf->Text(20, 235, "Lägenhet " . $hyresInfo->lagenhetNo . " " . $hyresInfo->fastighetNamn);
// }

$pdf->Text(20, 246, 'Vänligen ange fakturanummer:');
$pdf->SetFont($fontToUse,'B',10);
$pdf->Text(20, 250, $hyresInfo->fakturaNummer);

$pdf->SetFont($fontToUse,'',10);
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

if ($artikel->artikelTotalBelopp != null && $useOnlyArtikelData){

    if (strlen($artikel->artikelTotalBelopp) == 5)
    {
        $pdf->Text(103, 278, number_format($artikel->artikelTotalBelopp , 2, ' ', ' ')); //BELOPP LÄNGST NER PÅ TALONG!
    } else 
    {
        $pdf->Text(105, 278, number_format($artikel->artikelTotalBelopp , 2, ' ', ' ')); //BELOPP LÄNGST NER PÅ TALONG!
    }

} else {
    
    if ($thousandLength == 5)
    {
        $pdf->Text(103, 278, number_format($attBetala, 2, ' ', ' ')); //BELOPP LÄNGST NER PÅ TALONG!
    } else 
    {
        $pdf->Text(105, 278, number_format($attBetala, 2, ' ', ' ')); //BELOPP LÄNGST NER PÅ TALONG!
    }
}



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

/*********************************SKRIVER SPECIFIKATION FÖR HYRA********************************* */


if ($useOnlyArtikelData){

    //Endast en artikel
    $pdfLayout->printEndastArtikel($artikel);
    $pdfLayout->printEndastArtikelNettoMoms($artikel);
    
} else {

    //Skriv ut hyresspec.
    $pdfLayout->printHyresSpecifikation();
    if ($useArtikelData)
    {
        //skriv också ut artikel.
    }
}

/********************************************************************************************* */

/********************************spec moms ej moms att betala ****************************************** */
$pdfLayout->printNettoMomsAttbetala($attBetala);


/********************************************************************************************* */


$fileName = "faktura.pdf";
$pdf->Output($fileName, 'F');

$db->spara_faktura($fileName, $fakturaId);

//$pdf->Output();
?>