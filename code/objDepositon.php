<?php

class InfoDeposition
{
    public $depositionId;
    public $hyresgastId;
    public $belopp;
    public $datum_deposition;
    public $datum_ater;
    public $deposition_kommentar;
    public $belopp_ater;
    public $lagenhetId;

    function __construct($hyresgastId){
        $this->hyresgastId = $hyresgastId;
        $this->setInformation();
    }

    protected function setInformation()
    {
        $db = new DbManager();

        $sql = "select * from tidlog_hyresgaster h inner join tidlog_deposition d on h.deposition_id  = d.deposition_id where h.hyresgast_id =  ?";
        $info = $db->query($sql, array($this->hyresgastId))->fetchAll();

        foreach($info as $row){
            $this->depositionId = $row["deposition_id"];
            $this->datum_deposition = $row["datum_deposition"];
            $this->belopp = $row["belopp"];
            $this->datum_ater = $row["datum_aterbetalt"];
            $this->belopp_ater = $row["belopp_ater"]  == null ? 0 : $row["belopp_ater"];
            $this->deposition_kommentar = $row["kommentar"] == null ?  "" : $row["kommentar"];
        }

    }
    
}

?>