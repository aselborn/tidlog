<?php 

class Artikel
{
    public $hyresgastId ;
    public $artikel;
    public $artikelBelopp;
    public $artikelTotalBelopp;
    public $artikelMoms;
    public $kommentar;
    public $giltlig_from;
    public $giltlig_tom;
    public $med_hyra;
    
    public function __construct($hyresgastId) {
        $this->hyresgastId = $hyresgastId;
        $this->setInformation();
    }

    function setInformation()
    {
        $db = new DbManager();

        $hyra = $db->query(
            "SELECT * from tidlog_artikel ta
                WHERE ta.hyresgast_id = ? AND current_date() 
                BETWEEN giltlig_from and giltlig_tom
            ", array($this->hyresgastId))->fetchAll();

        foreach($hyra as $row)
        {
            $this->artikel = $row["artikel"];
            $this->giltlig_from = date_create($row["giltlig_from"]);
            $this->giltlig_tom = date_create($row["giltlig_tom"]);
            $this->kommentar = $row["kommentar"];
            $this->artikelBelopp = $row["belopp"];
            $this->artikelMoms = $row["moms"];
            $this->med_hyra = $row["med_hyra"];
            $this->artikelTotalBelopp = $row["totalbelopp"];
        }
            
    }
}

?>