<?php 

class Artikel
{
    public $hyresgastId ;
    public $fakturaMonth;

    public $artikel;
    public $artikelNettoBelopp;
    public $artikelTotalBelopp;
    public $artikelMomsBelopp;
    public $artikelMomsProcent;
    public $kommentar;
    public $meddelande;
    public $giltlig_from;
    public $giltlig_tom;
    public $med_hyra;
    public $resultSet = array();


    public function __construct($hyresgastId, $fakturaMonth) {
        $this->hyresgastId = $hyresgastId;
        $this->fakturaMonth = $fakturaMonth;
        $this->setInformation();
    }

    function setInformation()
    {
        $db = new DbManager();

        $hyra = $db->query(
            "
                select ti.artikel, ti.kommentar , ta.kommentar as meddelande,
                ta.totalbelopp , ta.nettobelopp, ta.momsbelopp, ta.giltlig_from , ta.giltlig_tom , ta.med_hyra 
                    from tidlog_item ti 
                    inner join tidlog_artikel ta on ti.item_id =ta.item_id 
                where
                ta.hyresgast_id = ? and month(giltlig_from) = ? and month(giltlig_tom) = ?
        
            ", array($this->hyresgastId, $this->fakturaMonth, $this->fakturaMonth))->fetchAll();

        foreach($hyra as $row)
        {
            $this->artikel = $row["artikel"];
            $this->giltlig_from = date_create($row["giltlig_from"]);
            $this->giltlig_tom = date_create($row["giltlig_tom"]);
            $this->kommentar = $row["kommentar"];
            $this->meddelande = $row["meddelande"];
            $this->med_hyra = $row["med_hyra"];
            $this->artikelTotalBelopp = $row["totalbelopp"];
            $this->artikelNettoBelopp = $row['nettobelopp'];
            $this->artikelMomsBelopp = $row['momsbelopp'];
            //$this->artikelMomsProcent = $row['moms'];
            
            $this->resultSet[] = $row;
            
        }
        
    }
}

?>