<?php 

    class Pdflayout
    {
        public $pdf;
        public $fontToUse;
        public $hyresInfo;
        public function __construct($pdf, $fontToUse, $hyresInfo){
            $this->pdf = $pdf;
            $this->fontToUse = $fontToUse;
            $this->hyresInfo = $hyresInfo;
        }


        function printEndastArtikel($artikelData)
        {
            $this->pdf->SetFont($this->fontToUse, 'B', 10);
            $this->pdf->Text(20, 90, 'SPECIFIKATION');
            $this->pdf->Text(180, 90, 'BELOPP');
            
            $this->pdf->SetFont($this->fontToUse, '', 9);
            
            $this->pdf->Text(20, 95, $artikelData->artikel);
            $this->pdf->Text(22, 99, " -" . $artikelData->kommentar . ":");

             //BELOPP kolumnen.
             $this->pdf->Text(180, 99, number_format($artikelData->artikelBelopp, 2, ',', ' ') . " kr"); 
            
            
        }

        function talongSpecifikation()
        {
            $this->pdf->SetFont($this->fontToUse,'',10);
             if ($this->hyresInfo->moms > 0 ){
                $this->pdf->Text(20, 230, 'Betalning gäller lokal');
             } else {
                $this->pdf->Text(20, 230, 'Betalning gäller lägenheten ');
                if ($this->hyresInfo->moms > 0){
                    $this->pdf->Text(20, 235,  $this->hyresInfo->specifikation . " " . $this->hyresInfo->fastighetNamn);
                } else {
                    $this->pdf->Text(20, 235, "Lägenhet " . $this->hyresInfo->lagenhetNo . " " . $this->hyresInfo->fastighetNamn);
                }

             }

        }
        function talongSpecifikationArtikel($artikelData)
        {
            $this->pdf->SetFont($this->fontToUse,'',10);
            $this->pdf->Text(20, 230, 'Betalning avser :' . $artikelData->artikel);
        }

        function printHyresSpecifikation ()
        {    
            $this->pdf->SetFont($this->fontToUse, 'B', 10);
            $this->pdf->Text(20, 90, 'SPECIFIKATION');
            $this->pdf->Text(180, 90, 'BELOPP');
            $this->pdf->SetFont($this->fontToUse, '', 9);
            $this->pdf->Text(20, 95, $this->hyresInfo->fastighetAddress . " ".  $this->hyresInfo->adress . " " . $this->hyresInfo->specifikation);
            if ($this->hyresInfo->moms > 0){
                $this->pdf->Text(22, 99, " -Hyra lokal: ");
            } else {
                $this->pdf->Text(22, 99, " -Hyra bostad: ");
            }
            
            //BELOPP kolumnen.
            $this->pdf->Text(180, 99, number_format($this->hyresInfo->hyra, 2, ',', ' ') . " kr"); 
            
            if ($this->hyresInfo->fskatt > 0 )
            {
                //OM Fastighetskatt!
                $this->pdf->Text(22, 103, " -Fastighetskatt:");
                $this->pdf->Text(185, 103, number_format($this->hyresInfo->fskatt, 2, ',', ' ') . " kr"); 
            
                if ($this->hyresInfo->parkering != 0){
                    $this->pdf->Text(22, 107, " -Parkering:");
                    $this->pdf->Text(185, 107, number_format($this->hyresInfo->parkering, 2, ',', ' ') . " kr"); 
                }
            } else {
                //OM inte fastighetskatt
                if ($this->hyresInfo->parkering != 0 ){
                    $this->pdf->Text(22, 103, " -Avgift parkering:");
                    $this->pdf->Text(183, 103, number_format($this->hyresInfo->parkering, 2, ',', ' ') . " kr"); 
                }
            }
        }

        /*
            Skriver rader om netto och moms och belopp
        */
        function printNettoMomsAttbetala($attBetala)
        {
            
            $this->pdf->SetFont($this->fontToUse, 'B', 10);
            $this->pdf->Text(20, 140, 'Netto'); 
            $this->pdf->SetFont($this->fontToUse, '', 9);

            if ($this->hyresInfo->moms > 0 )
            {
                $this->pdf ->Text(20, 145, number_format($this->hyresInfo->hyra + $this->hyresInfo->fskatt + $this->hyresInfo->parkering, 2, ',', ' ') . " kr");
            } else {
                $this->pdf ->Text(20, 145, number_format($attBetala, 2, ',', ' ') . " kr");
            }

            $this->pdf->SetFont($this->fontToUse, 'B', 10);
            $this->pdf->Text(50, 140, 'Moms');

            $this->pdf->SetFont($this->fontToUse, '', 9);
            if ($this->hyresInfo->moms > 0){
                $this->pdf ->Text(50, 145, number_format($this->hyresInfo->moms, 2, ',', ' ')  .  " kr");
            } else{
                $this->pdf ->Text(50, 145, "0,00 kr");
            }


            $this->pdf->SetFont($this->fontToUse, 'B', 10);
            $this->pdf->Text(180, 140, 'Att betala');
            $this->pdf->SetFont($this->fontToUse, '', 9);
            $this->pdf ->Text(180, 145, number_format($attBetala, 2, ',', ' ') . " kr");     
        }

        function printEndastArtikelNettoMoms($artikelData)
        {
            
            $this->pdf->SetFont($this->fontToUse, 'B', 10);
            $this->pdf->Text(20, 140, 'Netto'); 
            $this->pdf->SetFont($this->fontToUse, '', 9);

            $this->pdf ->Text(20, 145, number_format($artikelData->artikelBelopp, 2, ',', ' ') . " kr");
            
            $this->pdf->SetFont($this->fontToUse, 'B', 10);
            $this->pdf->Text(50, 140, 'Moms');

            $this->pdf->SetFont($this->fontToUse, '', 9);
            if ($this->hyresInfo->moms > 0){
                $momsbelopp = ((($artikelData->artikelMoms) / 100) * ($artikelData->artikelBelopp)) ;
                $this->pdf ->Text(50, 145, number_format($momsbelopp, 2, ',', ' ')  .  " kr");
            } else{
                $this->pdf ->Text(50, 145, "0,00 kr");
            }


            $this->pdf->SetFont($this->fontToUse, 'B', 10);
            $this->pdf->Text(180, 140, 'Att betala');
            $this->pdf->SetFont($this->fontToUse, '', 9);
            $this->pdf ->Text(180, 145, number_format($artikelData->artikelTotalBelopp, 2, ',', ' ') . " kr");     
        }

    }

?>