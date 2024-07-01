<?php

    class InfoHyresgast
    {
        public $hyresgastId;
        public $adress;
        public $fnamn;
        public $enamn;
        public $telefon;
        public $epost;
        public $hyra;
        public $datumKontrakt;
        public $kontraktNamn;
        public $kontrakt;
        public $andrahand;
        public $avgift;
        public $lagenhetId;
        public $lagenhetNo;
        public $parkering;
        public $kontraktId ;
        public $datumNyckelKvitto;
        public $datumKontraktUppsagt;
        public $moms ;
        public $momsprocent;
        public $fskatt;
        public $fastighetid;
        
        

        public array $kontrakts;

        function __construct($hyresgastId){
            $this->hyresgastId = $hyresgastId;
            $this->setInformation();
        }

        function setInformation(){
            $db = new DbManager();

            $sql = "select h.adress, h.fnamn , h.enamn, l.hyra , k.datum , k.kontrakt_namn , k.kontrakt_id, 
            k.kontrakt, k.datum_uppsagd, h.andrahand , tf.fastighet_id ,
            p.avgift, 
            l.lagenhet_id , l.lagenhet_nr, l.fskatt,
            h.hyresgast_id, h.epost, h.telefon,
            tn.datum_ut as datumNyckelKvitto,
            tm.moms_procent , tm.moms
            from tidlog_hyresgaster h inner join tidlog_lagenhet l on h.hyresgast_id = l.hyresgast_id
            		inner join tidlog_fastighet tf on tf.fastighet_id =l.fastighet_id 
                    left outer join tidlog_kontrakt k on k.lagenhet_id = l.lagenhet_id
                    left outer join tidlog_parkering p on p.park_id = l.park_id
                    left outer join tidlog_nycklar tn on tn.hyresgast_id = h.hyresgast_id 
                    left outer join tidlog_moms tm on tm.lagenhet_id  = l.lagenhet_id
                    where h.hyresgast_id = ?";

            $info = $db->query($sql, array($this->hyresgastId))->fetchAll();

            foreach ($info as $row) {

                $this->adress = $row["adress"];
                $this->fnamn = $row["fnamn"] ;
                $this->enamn = $row["enamn"] ;
                $this->telefon = $row["telefon"] ;
                $this->epost = $row["epost"] ;
                $this->hyra = $row["hyra"] ;
                $this->kontraktNamn= $row["kontrakt_namn"] ;
                $this->kontrakt = $row["kontrakt"] ;
                $this->andrahand = $row["andrahand"] ;
                $this->avgift = $row["avgift"] ;
                $this->lagenhetId = $row["lagenhet_id"] ;
                $this->lagenhetNo = $row["lagenhet_nr"] ;
                $this->parkering = $row["avgift"];
                $this->kontraktId = $row["kontrakt_id"];
                $this->datumNyckelKvitto = $row["datumNyckelKvitto"];
                $this->datumKontraktUppsagt = $row["datum_uppsagd"];
                $this->moms = $row["moms"];
                $this->momsprocent = $row["moms_procent"];
                $this->fskatt = $row["fskatt"];
                if ($row["datum"] != null){

                    $dtdat = date_create($row["datum"]);
                    $this->datumKontrakt  = date_format($dtdat, "Y-m-d");
                } else {
                    $this->datumKontrakt = $row["datum"] ;
                }
                $this->fastighetid= $row["fastighet_id"];
            }

        }
    }

?>