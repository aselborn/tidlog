<?php 
    //include "dbmanager.php";
    
    class InfoLagenhet {

        public $lagenhetNo;
        public $innehavare;
        public $hyra;
        public $parkering;
        public $andrahand;
        public $datumKontrakt;
        public $lagenhetId ;
        public $hyresgastId;
        public $kontraktNamn ;
        public $kontrakt;
        public $kontraktId;
        public $datumNyckelKvitto;

        public function __construct($lghNo){
            $this->lagenhetNo = $lghNo;
            $this->set_information();
        }
        
        function set_information(){
            $db = new DbManager();
            
            $sql ="select h.fnamn , h.enamn, l.hyra , k.kontrakt_id, k.datum, k.kontrakt_namn, k.kontrakt, h.andrahand , p.avgift, l.lagenhet_id , h.hyresgast_id  from tidlog_hyresgaster h inner join tidlog_lagenhet l on h.lagenhet_id = l.lagenhet_id 
                    left outer join tidlog_kontrakt k on k.lagenhet_id = l.lagenhet_id
                    left outer join tidlog_parkering p on p.park_id = l.park_id
                    where l.lagenhet_nr =?";

            $info = $db->query($sql, array($this->lagenhetNo))->fetchAll();

            foreach ($info as $row) {
                $this->innehavare = $row["fnamn"] . " " . $row["enamn"];
                $this->hyra = $row["hyra"] == null ? 0 : $row["hyra"];
                $this->andrahand = $row["andrahand"] == null ? "0" : $row["andrahand"];
                if ($row["datum"] != null){
                    $dtdat = date_create($row["datum"]);
                    $this->datumKontrakt  = date_format($dtdat, "Y-m-d");
                } else {
                    $this->datumKontrakt = $row["datum"] ;
                }
                
                $this->parkering = $row["avgift"] == null ? 0 : $row["avgift"];
                $this->lagenhetId = $row["lagenhet_id"];
                $this->hyresgastId = $row["hyresgast_id"];
                $this->kontrakt = $row["kontrakt"];
                $this->kontraktNamn = $row["kontrakt_namn"];
                $this->kontraktId= $row["kontrakt_id"];
            }


        }

    }
?>