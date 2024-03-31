<?php 
    //include "dbmanager.php";
    
    class InfoLagenhet {

        public $lagenhetNo;
        public $hyra;
        public $parkering;
        public $lagenhetId ;
        public $parkNr;

        public function __construct($lghNo){
            $this->lagenhetNo = $lghNo;
            $this->set_information();
        }
        
        function set_information(){
            $db = new DbManager();
            
            $sql =
            "
                select 
                l.lagenhet_nr , l.hyra , p.park_id , p.avgift, p.parknr, l.lagenhet_id   
                from tidlog_lagenhet l
                left outer join tidlog_parkering p on p.park_id = l.park_id
                where l.lagenhet_nr = ?
            ";

            $info = $db->query($sql, array($this->lagenhetNo))->fetchAll();

            foreach ($info as $row) {
               
                $this->hyra = $row["hyra"] == null ? 0 : $row["hyra"];
                $this->lagenhetNo = $row["lagenhet_nr"];
                $this->parkering = $row["avgift"] == null ? 0 : $row["avgift"];
                $this->lagenhetId = $row["lagenhet_id"];
                $this->parkNr = $row["parknr"];
               
            }

        }

    }
?>