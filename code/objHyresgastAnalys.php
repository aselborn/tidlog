<?php 

    class HyresgastAnalys
    {
        protected $hyresgastId;
        protected $FakturaNummer;
        public $enamn;
        public $fnamn;
        protected $FFDat;
        protected $Belopp;
        protected $BetDat;
        protected $DiffBelopp;
        protected $diff_datum_days;
        protected $extra_belopp;
        protected $extra_datum;

        public $resultSet = array();

        public function __construct($hyresgastId) {
            $this->hyresgastId = $hyresgastId;

            $this->setInformation();

        }

        function setInformation()
        {
            $db = new DbManager();
            $data = $db->query("select th.fnamn, th.enamn, tf.fakturaNummer, tf.duedate as 'FF.dat',
	                ti.belopp as Belopp , ti.inbetald as 'Betdat', ti.diff_belopp as 'Diff.Belopp', ti.diff_datum_days,
	                tfe.extrabelopp , tfe.extradatum 
	                from tidlog_inbetalningar ti
		            inner join tidlog_faktura tf on tf.faktura_id =ti.faktura_id 
		            inner join tidlog_hyresgaster th on th.hyresgast_id =tf.hyresgast_id 
                    left outer join tidlog_faktura_extra tfe on tfe.faktura_id =tf.faktura_id 
                    WHERE th.hyresgast_id = ? Order by ti.inbetald desc",  array($this->hyresgastId))->fetchAll();
            
            $this->fnamn = $data[0]["fnamn"];
            $this->enamn = $data[0]["enamn"];

            foreach($data as $row)
            {
                

                $this->FakturaNummer = $row["fakturaNummer"];
                $this->FFDat = $row["FF.dat"];
                $this->Belopp = $row["Belopp"];
                $this->BetDat = $row["Betdat"];
                $this->DiffBelopp = $row["Diff.Belopp"];
                $this->diff_datum_days = $row["diff_datum_days"];
                $this->extra_belopp = $row["extrabelopp"] == null ? 0 : $row["extrabelopp"];
                $this->extra_datum = $row["extradatum"] == null ? 0 : $row["extradatum"];
                $this->resultSet[] = $row;
            }
            
        }   

    }

?>