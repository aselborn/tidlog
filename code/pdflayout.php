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
            Skriver ut artiklar. RETRO HYRA, ÖVRIGT ETC.
        */
        function printArtikelSpecifikation($artikelData)
        {
            $startPos = 0;
            $this->hyresInfo->parkering != 0 ? $startPos = 107 : $startPos = 103;
            
            foreach($artikelData->resultSet as $row){
                
                $artikel = $row["artikel"];
                $meddelande = $row["meddelande"];
                $artikelNettoBelopp = $row["nettobelopp"];
                $artikelTotalBelopp = $row['totalbelopp'];

                $this->pdf->Text(22, $startPos, " -" . $artikel . ", " . $meddelande . ":");

                if (strlen($artikelNettoBelopp) >= 4){
                    $this->pdf->Text(180, $startPos, number_format($artikelNettoBelopp, 2, ',', ' ') . " kr"); 
                } else {
                    $this->pdf->Text(183, $startPos, number_format($artikelNettoBelopp, 2, ',', ' ') . " kr"); 
                }
                

                $startPos = $startPos + 4;

            }

           

        }

        /*
            Skriver rader om netto och moms och belopp
        */
        function printNettoMomsAttbetala($nettoBelopp, $momsBelopp)
        {
            
            $this->pdf->SetFont($this->fontToUse, 'B', 10);
            $this->pdf->Text(20, 140, 'Netto'); 
            $this->pdf->SetFont($this->fontToUse, '', 9);

            if ($this->hyresInfo->moms > 0 )
            {
                $this->pdf ->Text(20, 145, number_format($this->hyresInfo->hyra + $this->hyresInfo->fskatt + $this->hyresInfo->parkering, 2, ',', ' ') . " kr");
            } else {
                $this->pdf ->Text(20, 145, number_format($nettoBelopp, 2, ',', ' ') . " kr");
            }

            $this->pdf->SetFont($this->fontToUse, 'B', 10);
            $this->pdf->Text(50, 140, 'Moms');

            $this->pdf->SetFont($this->fontToUse, '', 9);
            if ($momsBelopp> 0){
                $this->pdf ->Text(50, 145, number_format($momsBelopp, 2, ',', ' ')  .  " kr");
            } else{
                $this->pdf ->Text(50, 145, "0,00 kr");
            }


            $this->pdf->SetFont($this->fontToUse, 'B', 10);
            $this->pdf->Text(180, 140, 'Att betala');
            $this->pdf->SetFont($this->fontToUse, '', 9);
            $this->pdf ->Text(180, 145, number_format($nettoBelopp + $momsBelopp, 2, ',', ' ') . " kr");     
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
                $momsbelopp = round($momsbelopp, 0);
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