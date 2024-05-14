<?php 
    //include "dbmanager.php";
    
    class InfoLagenhet {

        public $lagenhetNo;
        public $hyra;
        public $parkering;
        public $lagenhetId ;
        public $parkNr;
        public $fastighetId;
        public $kallareId;
        public $kallareNr ;
        public $vindId;
        public $VindNr;

        public function __construct($lghNo){
            $this->lagenhetNo = $lghNo;
            $this->set_information();
        }
        
        function set_information(){
            $db = new DbManager();
            
            $sql =
            "
                select 
                l.lagenhet_nr , l.hyra , p.park_id , p.avgift, p.parknr, l.lagenhet_id, tf.fastighet_id, tv.vind_id, tk.kallare_id,
                    tv.nummer as vindNr, tk.nummer as kallareNr
                    from tidlog_lagenhet l
                    left outer join tidlog_parkering p on p.park_id = l.park_id
                    
                    left outer join tidlog_vind tv on tv.vind_id = l.vind_id
                    left outer join tidlog_kallare tk on tk.kallare_id = l.kallare_id

                    inner join tidlog_fastighet tf on tf.fastighet_id =l.fastighet_id 
                    
                where l.lagenhet_nr = ?
            ";

            $info = $db->query($sql, array($this->lagenhetNo))->fetchAll();

            foreach ($info as $row) {
               
                $this->hyra = $row["hyra"] == null ? 0 : $row["hyra"];
                $this->lagenhetNo = $row["lagenhet_nr"];
                $this->parkering = $row["avgift"] == null ? 0 : $row["avgift"];
                $this->lagenhetId = $row["lagenhet_id"];
                $this->parkNr = $row["parknr"];
                $this->fastighetId = $row['fastighet_id'];
                $this->vindId = $row["vind_id"];
                $this->kallareId = $row["kallare_id"];

                $this->VindNr = $row["vindNr"] == null ? 0 : $row["vindNr"];
                $this->kallareNr = $row["kallareNr"] == null ? 0 : $row["kallareNr"];
                
            }

        }

    }
?>