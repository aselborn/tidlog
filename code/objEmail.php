<?php 
class EpostMeddelande
{
     public $fullname;
     public $fastighetNamn;
     public $fakturaId;
     public $faktura;
     public $specifikation;
     public $epost;
  

    public function __construct($fakturaId) {
    
        $this->fakturaId = $fakturaId;
        $this->setInformation();
    }

    function setInformation()
    {
        $db = new DbManager();

        $faktura = $db->query("select fa.fastighet_namn, fa.foretag_namn, fa.fastighet_address, fa.post_adress, fa.epost, 
            h.fnamn, h.enamn, h.adress, l.hyra, l.lagenhet_nr, p.avgift, f.faktura,
            f.faktura_id, f.fakturanummer, f.fakturadatum, f.ocr, f.duedate, f.specifikation
        
        from tidlog_faktura f
            inner join tidlog_hyresgaster h on h.hyresgast_id = f.hyresgast_id
            inner join tidlog_lagenhet l on l.hyresgast_id  = h.hyresgast_id 
            inner join tidlog_fastighet fa on fa.fastighet_id = l.fastighet_id 
            left outer join tidlog_parkering p on p.park_id = l.park_id 
        where 
            f.faktura_id = ?", array($this->fakturaId))->fetchAll();

        foreach($faktura as $row){
            $this->fakturaId = $row["faktura_id"];
            $this->faktura = $row["faktura"];
            $this->specifikation = $row["specifikation"];
            $this->epost = $row["epost"];
            $this->fullname = $row["fnamn"] . " " . $row["enamn"];
            $this->fastighetNamn = $row["foretag_namn"];
        }
            
    }
}

?>