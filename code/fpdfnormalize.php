<?php 

require '../fpdf/fpdf.php';

class TextNormalizerFPDF extends FPDF
	{
		public $hyresInfo;
		public $attBetala;
		
        // Page header
    function Header()
    {
		

		$rubrik = 'arial';
		$fontToUse = 'arial';
		$startPosRight = 130;
		$nextPosRight = 155;

		$this->AddFont('OCRB', '', 'OCRB Regular.php');

        // Logo AVKOMMENTERAD FÖR NU, VÄNTAR PÅ BOLAG!
		if ($this->hyresInfo->fastighetNamn == "TRYCKAREN 7"){
			$this->Image('../bilder/t7_logo_3.0.png',10,10,35);
		} else{
			$this->Image('../bilder/u9_logo_2.0.png',10,10,35);
		}
        
        
		// Arial bold 15
        $this->SetFont($rubrik,'B',12);
        // Move to the right
        //$this->Cell(120);
        // Title
		if ($this->hyresInfo->adress == 'Lokal')
			$this->Text($startPosRight, 15, 'Faktura');
		else
			$this->Text($startPosRight, 15, 'Hyresavi');

		$this->SetFont($fontToUse, '', 8);
		//$this->Text(130, 20, 'Nisse hult');

		//ATT BETALA:
		$this->SetFont($fontToUse, 'B', 8);
		$this->Text($startPosRight, 20, 'Att betala:');  $this->SetFont($fontToUse, '', 8); $this->Text($nextPosRight, 20, 
		number_format($this->attBetala, 2, ',', ' ') . " kr"); 

		$this->SetFont($fontToUse, 'B', 8);
		$this->Text($startPosRight, 24, 'Referensnummer:'); $this->SetFont($fontToUse, '', 8); $this->Text($nextPosRight, 24,  $this->hyresInfo->fakturaNummer);
		
		$this->SetFont($fontToUse, 'B', 8);
		$this->Text($startPosRight, 27, 'Bankgiro:'); $this->SetFont($fontToUse, '', 8); $this->Text($nextPosRight, 27, $this->hyresInfo->bankgiro);

		$this->SetFont($fontToUse, 'B', 8);
		$this->Text($startPosRight, 30, 'Förfallodatum:'); $this->SetFont($fontToUse, '', 8); $this->Text($nextPosRight, 30, $this->hyresInfo->dueDate);
		
		$this->SetFont('Arial', 'B', 10);
		$this->Text($startPosRight, 50, $this->hyresInfo->fullname);

		$this->SetFont('Arial', '', 8);

		if ($this->hyresInfo->adress == 'Lokal'){
			$this->Text($startPosRight, 54, $this->hyresInfo->fastighetAddress 
			. " " . $this->hyresInfo->adress);

		} else {
			$this->Text($startPosRight, 54, $this->hyresInfo->fastighetAddress 
			// . " lgh "
			. " " . $this->hyresInfo->adress
			. " lgh " . $this->hyresInfo->lagenhetNo);

		}
       	
		$this->Text($startPosRight, 57, $this->hyresInfo->fastighet_postadress);
			

    }

    // Page footer
    // function Footer()
    // {
    //     // Position at 1.5 cm from bottom
    //     $this->SetY(-15);
    //     // Arial italic 8
    //     $this->SetFont('Arial','I',8);
    //     // Page number
    //     $this->Cell(0,23,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    // }
		function __construct($hyresInfo, $attBetala)
		{
			$this->hyresInfo = $hyresInfo;
			$this->attBetala = $attBetala;
			parent::__construct();
		}

		function MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false)
		{
			parent::MultiCell($w, $h, $this->normalize($txt), $border, $align, $fill);
		}

		function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
		{
			parent::Cell($w, $h, $this->normalize($txt), $border, $ln, $align, $fill, $link);
		}

		function Write($h, $txt, $link='')
		{
			parent::Write($h, $this->normalize($txt), $link);
		}

		function Text($x, $y, $txt)
		{
			parent::Text($x, $y, $this->normalize($txt));
		}

		protected function normalize($word)
		{
			// Thanks to: http://stackoverflow.com/questions/3514076/special-characters-in-fpdf-with-php
			
			$word = str_replace("@","%40",$word);
			$word = str_replace("`","%60",$word);
			$word = str_replace("¢","%A2",$word);
			$word = str_replace("£","%A3",$word);
			$word = str_replace("¥","%A5",$word);
			$word = str_replace("|","%A6",$word);
			$word = str_replace("«","%AB",$word);
			$word = str_replace("¬","%AC",$word);
			$word = str_replace("¯","%AD",$word);
			$word = str_replace("º","%B0",$word);
			$word = str_replace("±","%B1",$word);
			$word = str_replace("ª","%B2",$word);
			$word = str_replace("µ","%B5",$word);
			$word = str_replace("»","%BB",$word);
			$word = str_replace("¼","%BC",$word);
			$word = str_replace("½","%BD",$word);
			$word = str_replace("¿","%BF",$word);
			$word = str_replace("À","%C0",$word);
			$word = str_replace("Á","%C1",$word);
			$word = str_replace("Â","%C2",$word);
			$word = str_replace("Ã","%C3",$word);
			$word = str_replace("Ä","%C4",$word);
			$word = str_replace("Å","%C5",$word);
			$word = str_replace("Æ","%C6",$word);
			$word = str_replace("Ç","%C7",$word);
			$word = str_replace("È","%C8",$word);
			$word = str_replace("É","%C9",$word);
			$word = str_replace("Ê","%CA",$word);
			$word = str_replace("Ë","%CB",$word);
			$word = str_replace("Ì","%CC",$word);
			$word = str_replace("Í","%CD",$word);
			$word = str_replace("Î","%CE",$word);
			$word = str_replace("Ï","%CF",$word);
			$word = str_replace("Ð","%D0",$word);
			$word = str_replace("Ñ","%D1",$word);
			$word = str_replace("Ò","%D2",$word);
			$word = str_replace("Ó","%D3",$word);
			$word = str_replace("Ô","%D4",$word);
			$word = str_replace("Õ","%D5",$word);
			$word = str_replace("Ö","%D6",$word);
			$word = str_replace("Ø","%D8",$word);
			$word = str_replace("Ù","%D9",$word);
			$word = str_replace("Ú","%DA",$word);
			$word = str_replace("Û","%DB",$word);
			$word = str_replace("Ü","%DC",$word);
			$word = str_replace("Ý","%DD",$word);
			$word = str_replace("Þ","%DE",$word);
			$word = str_replace("ß","%DF",$word);
			$word = str_replace("à","%E0",$word);
			$word = str_replace("á","%E1",$word);
			$word = str_replace("â","%E2",$word);
			$word = str_replace("ã","%E3",$word);
			$word = str_replace("ä","%E4",$word);
			$word = str_replace("å","%E5",$word);
			$word = str_replace("æ","%E6",$word);
			$word = str_replace("ç","%E7",$word);
			$word = str_replace("è","%E8",$word);
			$word = str_replace("é","%E9",$word);
			$word = str_replace("ê","%EA",$word);
			$word = str_replace("ë","%EB",$word);
			$word = str_replace("ì","%EC",$word);
			$word = str_replace("í","%ED",$word);
			$word = str_replace("î","%EE",$word);
			$word = str_replace("ï","%EF",$word);
			$word = str_replace("ð","%F0",$word);
			$word = str_replace("ñ","%F1",$word);
			$word = str_replace("ò","%F2",$word);
			$word = str_replace("ó","%F3",$word);
			$word = str_replace("ô","%F4",$word);
			$word = str_replace("õ","%F5",$word);
			$word = str_replace("ö","%F6",$word);
			$word = str_replace("÷","%F7",$word);
			$word = str_replace("ø","%F8",$word);
			$word = str_replace("ù","%F9",$word);
			$word = str_replace("ú","%FA",$word);
			$word = str_replace("û","%FB",$word);
			$word = str_replace("ü","%FC",$word);
			$word = str_replace("ý","%FD",$word);
			$word = str_replace("þ","%FE",$word);
			$word = str_replace("ÿ","%FF",$word);

			return urldecode($word);
		}

	}
