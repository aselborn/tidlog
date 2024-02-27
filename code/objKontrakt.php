<?php 

class InfoKontrakt
{
    public $hyresgastId;
    public $kontraktNamn;
    public $kontrakt;
    public $kontraktId;
    public $datumKontrakt;
    public $datumUppsagd;

    function __construct($hyresgastId){
        $this->hyresgastId = $hyresgastId;
        $this->setInformation();

    }

    function setInformation(){
        $db = new DbManager();

        $sql = "SELECT k.datum , k.kontrakt_namn , k.kontrakt_id, 
        k.kontrakt, k.datum_uppsagd

            FROM tidlog_hyresgaster h left outer join tidlog_kontrakt k on k.hyresgast_id = h.hyresgast_id
                where h.hyresgast_id = ?";

        $info = $db->query($sql, array($this->hyresgastId))->fetchAll();
        $array_data = array();
        foreach ($info as $row) {

            $this->kontraktNamn= $row["kontrakt_namn"] ;
            $this->kontrakt = $row["kontrakt"] ;
            $this->kontraktId = $row["kontrakt_id"];
            $this->datumKontrakt = $row["datum"];
            $this->datumUppsagd = $row["datum_uppsagd"];

            if ($row["datum"] != null){

                $dtdat = date_create($row["datum"]);
                $this->datumKontrakt  = date_format($dtdat, "Y-m-d");
            } else {
                $this->datumKontrakt = $row["datum"] ;
            }

            //Lägg till i array
            $array_data["kontrakt_id"][] = $this->kontraktId;
            $array_data["kontraktNamn"][] = $this->kontraktNamn;
            $array_data["kontrakt"][] = $this->kontrakt;
            $array_data["datum"][] = $this->datumKontrakt;
            $array_data["datum_uppsagd"][] = $this->datumUppsagd;
            
        }

    }
}


?>