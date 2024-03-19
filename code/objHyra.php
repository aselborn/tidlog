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
    public $fakturaDatum;
    public $specifikation;
    public $fakturaId;
    public $adress;
    public $fakturaNummer;
    public $moms;
    public $orgNr;
    public $fskatt ;
    public $fastighet_epost;
    public $bankgiro;
    public $ftgnamn;

    public function __construct($hyresgastId, $fakturaId) {
        $this->hyresgastId = $hyresgastId;
        $this->fakturaId = $fakturaId;
        $this->setInformation();
    }

    function setInformation()
    {
        $db = new DbManager();

        $hyra = $db->query("select fa.fastighet_namn, fa.fastighet_address, fa.post_adress, fa.epost , fa.orgnr , fa.bankgiro, l.fskatt, fa.foretag_namn,
            h.fnamn, h.enamn, h.adress, l.hyra, l.lagenhet_nr, p.avgift, 
            f.faktura_id, f.fakturanummer, f.fakturadatum, f.ocr, f.duedate, f.specifikation, 
            tm.moms_procent, tm.moms
        
        from tidlog_faktura f
            inner join tidlog_hyresgaster h on h.hyresgast_id = f.hyresgast_id
            inner join tidlog_lagenhet l on l.hyresgast_id = h.hyresgast_id 
            inner join tidlog_fastighet fa on fa.fastighet_id = l.fastighet_id 
            left outer join tidlog_parkering p on p.park_id = l.park_id 
            left outer join tidlog_moms tm on tm.lagenhet_id = l.lagenhet_id
        where 
            h.hyresgast_id = ? and f.faktura_id = ? order by tm.sparad  desc limit 1 ", array($this->hyresgastId, $this->fakturaId))->fetchAll();

        foreach($hyra as $row)
        {
            $dtdat = date_create($row["duedate"]);
            //$this->fakturaId = $row["faktura_id"];
            $this->dueDate = date_format($dtdat, "Y-m-d");
            $this->fullname = $row["fnamn"] . " " . $row["enamn"];
            $this->ocrNr = $row["ocr"];
            $this->lagenhetNo = $row["lagenhet_nr"];
            $this->fastighetNamn =$row["fastighet_namn"];
            $this->fastighetAddress =$row["fastighet_address"];
            $this->adress = $row["adress"] == null ? "?" : $row["adress"] ;
            $this->fastighet_postadress = $row["post_adress"] == null ? "" :  $row["post_adress"];
            $this->hyra =$row["hyra"];
            $this->parkering = $row["avgift"] == null ? 0 : $row["avgift"] ;
            $this->fakturaNummer = $row["fakturanummer"];
            //$this->fakturaDatum = $row["fakturadatum"];
            $this->moms = round($row["moms"], 0);
            $this->specifikation = $row["specifikation"];
            $dtdat = date_create($row["fakturadatum"]);
            $dt = date_format($dtdat, "Y-m-d");
            $this->fakturaDatum = $dt;
            $this->fastighet_epost = $row["epost"];
            $this->orgNr = $row["orgnr"];
            $this->fskatt = $row["fskatt"] == null ? null : ( intval( $row["fskatt"] / 12));
            $this->bankgiro = $row["bankgiro"];
            $this->ftgnamn = $row["foretag_namn"];
        }
            
    }
}

?>