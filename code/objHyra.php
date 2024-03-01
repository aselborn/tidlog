<?php 

class HyresAvisering
{
    public $hyresgastId ;
    public $dueDate;
    public $fullname;
    public $ocrNr;
    public $lagenhetNo;
    public $fastighetNamn;
    public $fastighetAddress;
    public $fastighet_postadress;
    public $hyra;
    public $parkering;

    public $fakutaId;
    public $adress;

    public function __construct($hyresgastId) {
        $this->hyresgastId = $hyresgastId;

        $this->setInformation();
    }

    function setInformation()
    {
        $db = new DbManager();

        $hyra = $db->query("select fa.fastighet_namn, fa.fastighet_address, fa.post_adress, 
            h.fnamn, h.enamn, h.adress, l.hyra, l.lagenhet_nr, p.avgift, 
            f.faktura_id, f.fakturanummer, f.fakturadatum, f.ocr, f.duedate, f.specifikation
        
        from tidlog_fakutra f
            inner join tidlog_hyresgaster h on h.hyresgast_id = f.hyresgast_id
            inner join tidlog_lagenhet l on l.lagenhet_id = h.lagenhet_id
            inner join tidlog_fastighet fa on fa.fastighet_id = l.fastighet_id 
            left outer join tidlog_parkering p on p.park_id = l.park_id 
        where 
            h.hyresgast_id = ?", array($this->hyresgastId))->fetchAll();

        foreach($hyra as $row)
        {
            $dtdat = date_create($row["duedate"]);
            $this->dueDate = date_format($dtdat, "Y-m-d");
            $this->fullname = $row["fnamn"] . " " . $row["enamn"];
            $this->ocrNr = $row["ocr"];
            $this->lagenhetNo = $row["lagenhet_nr"];
            $this->fastighetNamn =$row["fastighet_namn"];
            $this->fastighetAddress =$row["fastighet_address"];
            $this->fakutaId = $row["faktura_id"];
            $this->adress = $row["adress"] == null ? "?" : $row["adress"] ;
            $this->fastighet_postadress = $row["post_adress"] == null ? "" :  $row["post_adress"];
            $this->hyra =$row["hyra"];
            $this->parkering = $row["avgift"] == null ? 0 : $row["avgift"] ;
        }
            
    }
}

?>