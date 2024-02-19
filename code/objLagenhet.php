<?php 
    //include "dbmanager.php";
    
    class InfoLagenhet {

        public $lagenhetNo;
        public $innehavare;
        public function __construct($lghNo){
            $this->lagenhetNo = $lghNo;
            $this->set_information();
        }
        
        function set_information(){
            $db = new DbManager();
            //$info = DbManager()->query("select * from tidlog_hyresgaster h inner join tidlog_lagenhet l on h.lagenhet_id = l.lagenhet_id")->fetchAll();
            $info = $db->query("select * from tidlog_hyresgaster h inner join tidlog_lagenhet l on h.lagenhet_id = l.lagenhet_id where l.lagenhet_nr = ?", array($this->lagenhetNo))->fetchAll();

            //$info =  $this->$db->query ("select * from tidlog_hyresgaster h inner join tidlog_lagenhet l on h.lagenhet_id = l.lagenhet_id")->fetchAll();

            foreach ($info as $row) {
                $this->innehavare = $row["fnamn"] . " " . $row["enamn"];
            }


        }

    }
?>