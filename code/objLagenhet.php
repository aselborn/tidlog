<?php 
    //include "dbmanager.php";
    
    class InfoLagenhet {

        public $lagenhetNo;
        public $innehavare;
        public $hyra;
        public $parkering;
        public $andrahand;
        public $datumKontrakt;

        public function __construct($lghNo){
            $this->lagenhetNo = $lghNo;
            $this->set_information();
        }
        
        function set_information(){
            $db = new DbManager();
            //$info = DbManager()->query("select * from tidlog_hyresgaster h inner join tidlog_lagenhet l on h.lagenhet_id = l.lagenhet_id")->fetchAll();
            $info = $db->query("select * from tidlog_hyresgaster h inner join tidlog_lagenhet l on h.lagenhet_id = l.lagenhet_id 
                left outer join tidlog_kontrakt k on k.lagenhet_id = l.lagenhet_id
                left outer join tidlog_parkering p on p.park_id = l.park_id
                where l.lagenhet_nr = ?", array($this->lagenhetNo))->fetchAll();

            //$info =  $this->$db->query ("select * from tidlog_hyresgaster h inner join tidlog_lagenhet l on h.lagenhet_id = l.lagenhet_id")->fetchAll();

            foreach ($info as $row) {
                $this->innehavare = $row["fnamn"] . " " . $row["enamn"];
                $this->hyra = $row["hyra"] == null ? 0 : $row["hyra"];
                $this->andrahand = $row["andrahand"] == null ? "0" : $row["andrahand"];
                $this->datumKontrakt = $row["datum"] == null ? "inte angivet."  : $row["datum"];
                $this->parkering = $row["avgift"] == null ? 0 : $row["avgift"];
            }


        }

    }
?>