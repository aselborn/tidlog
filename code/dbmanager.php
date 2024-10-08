<?php 
    
    require_once "config.php";
    class DbManager
    {
        protected $connection;
        protected $query;
        protected $table;
        protected $query_count = 0;
        protected $query_closed = TRUE;
        protected $show_errors = TRUE;
        public function __construct()
        {
            $this->connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

		    if ($this->connection->connect_error) {
			    die('Failed to connect to MySQL - ' . $this->connection->connect_error);
		    }
            
        }

        public function get_perioden_hyra($year, $month, $fastighetId)
        {
            $sql = "select sum(tf.belopp_hyra) as period_hyra, sum(tf.belopp_parkering) as period_parkering from tidlog_faktura tf 
                    inner join tidlog_lagenhet tl  on tl.lagenhet_id = tf.lagenhet_id 
                    inner join tidlog_fastighet tf2  on tf2.fastighet_id =tl.fastighet_id 
                    where 
                    tf2.fastighet_id = " . $fastighetId . " and tf.faktura_year = " . $year . " and tf.faktura_month = " . $month . "";

            $period_hyra = $this->query($sql) ->fetchAll();
            return $period_hyra;
        }

        public function GetInbetalningar($dtFom, $dtTom)
        {
            $sql = "
                select tf.faktura_id , ti.belopp , ti.diff_belopp , ti.inbetald , ti.diff_datum_days ,
                    th.fnamn , th.enamn , tl.lagenhet_nr 
                    from tidlog_inbetalningar ti 
                    inner join tidlog_faktura tf on ti.faktura_id = tf.faktura_id 
                    inner join tidlog_hyresgaster th on th.hyresgast_id = tf.hyresgast_id 
                    inner join tidlog_lagenhet tl on tl.hyresgast_id = tf.hyresgast_id 
                    where ti.inbetald between ? and ?
                    order by ti.inbetald desc 
                ";

            $data = $this->query($sql, array($dtFom, $dtTom))->fetchAll();
            return $data;

        }

        public function sok_extra_faktura($faktnr)
        {
            $sql = 
            "
                select 
                    ti.faktura_id,
                    tfe.extrabelopp,
                    tfe.extradatum ,
                    tf.fakturanummer , 
                    th.enamn , th.fnamn, tion.belopp, tion.diff_belopp , tion.inbetald, tl.lagenhet_nr
                from tidlog_inbetalningar ti 
	            inner join tidlog_faktura tf on tf.faktura_id =ti.faktura_id 
	            inner join tidlog_inbetalningar tion on tion.faktura_id =ti.faktura_id
                inner join tidlog_hyresgaster th on th.hyresgast_id =tf.hyresgast_id
                inner join tidlog_lagenhet tl on tl.hyresgast_id =th.hyresgast_id 
                left outer join tidlog_faktura_extra tfe on tfe.faktura_id =tf.faktura_id 
	            where tf.fakturanummer = ? and ti.diff_belopp != 0
	            order by tion.inbetald,  tfe.extradatum 
            ";

            $faktura = $this->query($sql, array($faktnr))->fetchAll();

            return $faktura;
        }

        public function registrera_extra_betalning($fakturaId, $datum, $belopp)
        {
            $sql = "insert into tidlog_faktura_extra(faktura_id, extrabelopp, extradatum) VALUES (?, ?, ?)";

            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("sss", $fakturaId, $belopp, $datum);
            $stmt->execute();

        }
        public function GetObetaldaFakturor()
        {
            $sql = "
                select tf.faktura_id, tf.fakturanummer, (tf.belopp_hyra + tf.belopp_parkering) as belopp,
                    th.fnamn as namn, th.enamn as efternamn, tl.lagenhet_nr,
                    tf.status_skickad as skickad, tf.duedate as ffdatum
                    from tidlog_faktura tf  
                    inner join tidlog_hyresgaster th on th.hyresgast_id = tf.hyresgast_id 
                    inner join tidlog_lagenhet tl on tl.hyresgast_id = tf.hyresgast_id 
                where tf.faktura_id not in (select faktura_id from tidlog_inbetalningar ti)
                and tf.faktura is not null and tf.status_skickad is not null 
                and duedate < now() 
                order by tf.duedate desc                  
                ";

            $data = $this->query($sql)->fetchAll();
            return $data;

        }

        //LOKALEN KOLLAS INTE!
        public function GetDiffBeloppFakturor()
        {
            $sql = 
            "
                select tf.fakturanummer,tf.faktura_id , ti.belopp , ti.diff_belopp , ti.inbetald , ti.diff_datum_days ,
                    th.fnamn , th.enamn , tl.lagenhet_nr, tf2.fastighet_namn , tf.duedate as ffdatum
                    from tidlog_inbetalningar ti 
                    inner join tidlog_faktura tf on ti.faktura_id = tf.faktura_id 
                    inner join tidlog_hyresgaster th on th.hyresgast_id = tf.hyresgast_id 
                    inner join tidlog_lagenhet tl on tl.hyresgast_id = tf.hyresgast_id 
                    inner join tidlog_fastighet tf2 on tf2.fastighet_id = tl.fastighet_id  
                where 
                    ti.diff_belopp != 0 and th.adress != 'Lokal'
                    order by tf2.foretag_namn , ti.inbetald desc 
                    
            ";

            $data = $this->query($sql)->fetchAll();
            return $data;
        }

        public function get_faktura_underlag($year, $month, $fastighetId, $page_first_result, $result_per_page)
        {
            $sql = "select             
            tf.faktura_id as faktura_id,
            tf.hyresgast_id as hyresgast_id, 
            tf.lagenhet_id as lagenhet_id, 
            tf.park_id as park_id, 
            tf.fakturanummer as fakturanummer, 
            tf.ocr as ocr, 
            tf.duedate as duedate, 
            tf.specifikation as specifikation, 
            case when tf.faktura is not null then 1 else 0 end as fakturaExists,
            tf.faktura_year as faktura_year, 
            tf.faktura_month as faktura_month,
            tf.status, 
            tf.status_skickad,
            case when tf.belopp_parkering = 0 then null else tf.belopp_parkering end as avgift ,
            tf.belopp_hyra as hyra, 
            th.fnamn, th.enamn, tl.lagenhet_nr,
            tfa.fastighet_id,
            ti.inbetald 
        from tidlog_faktura tf 
                inner join tidlog_hyresgaster th on tf.hyresgast_id = th.hyresgast_id 
                inner join tidlog_lagenhet tl on tl.lagenhet_id = tf.lagenhet_id 
                inner join tidlog_fastighet tfa on tfa.fastighet_id = tl.fastighet_id
                left outer join tidlog_parkering tp on tp.park_id = tl.park_id 
                left outer join tidlog_inbetalningar ti on ti.faktura_id =tf.faktura_id 
                where tfa.fastighet_id = " . $fastighetId . " and tf.faktura_year = " . $year ."
                and tf.faktura_month = " . $month . " 
                ORDER BY tl.lagenhet_nr 
                LIMIT " . $page_first_result . "," . $result_per_page;
                

            $fakturor = $this->query($sql) ->fetchAll();
            

            return $fakturor;
        }

        public function getRowCount()
        {
            $sql = "select count(*) as count from tidlog_jobs";
            $result = $this->connection->query($sql);
            $row = $result->fetch_assoc();
            return (int)$row["count"];
        }

        public function setEpostSkickad($fakturaId)
        {
            $currentDatetime = date('Y-m-d H:i:s');

            $sql = "UPDATE tidlog_faktura SET status = 1, status_skickad = ? WHERE faktura_id = ?";
            $stmt =$this->connection->prepare($sql);
            $stmt->bind_param("ss", $currentDatetime, $fakturaId);
            $stmt->execute();
        }

        public function getLagenhetCount($fastighetId)
        {
            $sql = "select count(*) as count from tidlog_lagenhet l inner join tidlog_fastighet tf on l.fastighet_id = tf.fastighet_id 
            where tf.fastighet_id =" .$fastighetId;
            
            $result = $this->connection->query($sql);
            $row = $result->fetch_assoc();
            return (int)$row["count"];
        }

        public function get_fastighet_namn($fastighetid)
        {
            $data = $this->query("Select fastighet_namn from tidlog_fastighet where fastighet_id = ?", array($fastighetid))->fetchAll();
            $fastighetNamn="";
            foreach ($data as $row){
                $fastighetNamn = $row["fastighet_namn"];
            }

            return $fastighetNamn;
        }

        public function getHyresgastCount($perFastighet)
        {
            $sql = "select count(*) as count from tidlog_lagenhet tl 
            inner join tidlog_fastighet tf on tf.fastighet_id =tl.fastighet_id 
            where tl.hyresgast_id is not null and tf.fastighet_id=" . $perFastighet ;
            $result = $this->connection->query($sql);
            $row = $result->fetch_assoc();
            return (int)$row["count"];
        }
        public function getContratCount($perFastighet)
        {
            $sql = "select count(*) as count from tidlog_kontrakt tk 
            inner join tidlog_lagenhet tl on tl.lagenhet_id =tk.lagenhet_id 
            inner join tidlog_fastighet tf on tf.fastighet_id =tl.fastighet_id 
            where tf.fastighet_id=" . $perFastighet ;

            $result = $this->connection->query($sql);
            $row = $result->fetch_assoc();
            return (int)$row["count"];
        }
        public function getfakturaCountPerFastighet($yr, $mn, $perFastighet)
        {
            $sql = "select count(*) as count from tidlog_faktura ta
			inner join tidlog_lagenhet tl  on tl.lagenhet_id = ta.lagenhet_id 
            inner join tidlog_fastighet tf on tf.fastighet_id = tl.fastighet_id 
            where tl.hyresgast_id is not null and tf.fastighet_id
            and ta.faktura_year = ? and ta.faktura_month = ? and tf.fastighet_id = ?";
        

            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("sss", $yr, $mn, $perFastighet);
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            $theResult = 0;
            
            

            $theResult = $result->fetch_assoc();
            $theResult = $theResult["count"];
            
            return $theResult;
            
        }

        public function registrera_inbetalning($faktId, $summa, $dtInbet)
        {

            // $sql = "INSERT INTO tidlog_inbetalningar(faktura_id, inbetald , belopp , diff_belopp , diff_datum_days) ";
            // $sql .= "select faktura_id, '$dtInbet', $summa, ($summa - (belopp_hyra + belopp_parkering)), DATEDIFF('$dtInbet', duedate) ";
            // $sql .= " from tidlog_faktura where faktura_id = ?";

            $sql = "INSERT INTO tidlog_inbetalningar(faktura_id, inbetald , belopp , diff_belopp , diff_datum_days) ";
            $sql .= " select faktura_id, '$dtInbet', $summa, ($summa - (belopp_hyra + belopp_parkering + case when ta.giltlig_tom between DATE_ADD(tf.duedate, interval 1 day) and DATE_ADD(tf.duedate, interval 32 day)  then ta.totalbelopp else 0 end )), DATEDIFF('$dtInbet', duedate)  ";
            $sql .= " from tidlog_faktura tf ";
            $sql .= " inner join tidlog_hyresgaster th on th.hyresgast_id =tf.hyresgast_id ";
            $sql .= " left outer join tidlog_artikel ta on ta.hyresgast_id = th.hyresgast_id ";
            $sql .= " where faktura_id = ?";

            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("s", $faktId);
            $stmt->execute();

        }

        function search_faktura($faktnr,  $belopp, $namn, $lagenhetNo)
        {
            

            $year = intval(substr($faktnr, 0, 4)); //"2024"
            $month = substr($faktnr, 4, 1); //"4"
           

            $firstday = 1;
            
            $startDate = date_create_from_format("j-m-Y", "$firstday-$month-$year");
            $startDateFrm = date_format($startDate, "Y-m-d");
            $endDateFmr = date("Y-m-t", strtotime($startDateFrm));
            

            $sql = " select tf.faktura_id, tf.fakturanummer , 
            case when m.moms is null then (tf.belopp_hyra + tf.belopp_parkering + case when ta.giltlig_tom between '$startDateFrm' and '$endDateFmr' then ta.totalbelopp else 0 end) else 
	        ROUND((tf.belopp_hyra + tf.belopp_parkering + m.moms + (tl.fskatt / 12) ), 0) end as belopp  , concat(th.fnamn , ' ',  + th.enamn) as namn ,
            tl.lagenhet_nr as lagenhetNo, tf.FakturaDatum as fakturadatum, tf.duedate, m.moms, tl.fskatt
                from tidlog_faktura tf 
                    inner join tidlog_hyresgaster th on th.hyresgast_id =tf.hyresgast_id 
                    inner join tidlog_lagenhet tl on tf.lagenhet_id = tl.lagenhet_id 
                    left outer join tidlog_moms m on m.lagenhet_id = tl.lagenhet_id
                    left outer join tidlog_artikel ta on ta.hyresgast_id = th.hyresgast_id
                    where tf.fakturanummer  like ? AND tf.Faktura is not null
                    and faktura_id not in (select faktura_id from tidlog_inbetalningar ti)
                    ";

            if (intval($belopp) > 0){
                $sql .= " and (tf.belopp_hyra + tf.belopp_parkering ) = ? ";
            } else {
                $belopp = 1;
                $sql .= " and 1 = ? ";
            }

            if (strval($namn) != ""){
                $sql .= " and concat(th.fnamn , ' ',  + th.enamn) like ? ";
            } else {
                $namn = "1";
                $sql .= " and 1 = ? ";
            }

            if (intval($lagenhetNo)>0){
                $sql .= " and tl.lagenhet_nr = ?";
            } else {
                $lagenhetNo = 1;
                $sql .= " and 1 = ? ";
            }


            $faktnr = "%$faktnr%";

            if ($namn != "1")
                $namn = "%$namn%";

            $stmt = $this->connection->prepare($sql);

            $stmt->bind_param("ssss", $faktnr, $belopp, $namn, $lagenhetNo);

            $stmt->execute();
            $result = $stmt->get_result();
            
            $rows = $result->fetch_all(MYSQLI_ASSOC);

            return $rows;
        }
        public function getRowCountForUser($user)
        {
            $sql = "select count(*) as count, sum(job_hour) from tidlog_jobs where job_username = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $rows = $result->fetch_assoc()["count"];

            return $rows ;
        }

        public function query($query) {
            if (!$this->query_closed) {
                $this->query->close();
            }
            if ($this->query = $this->connection->prepare($query)) {
                if (func_num_args() > 1) {
                    $x = func_get_args();
                    $args = array_slice($x, 1);
                    $types = '';
                    $args_ref = array();
                    foreach ($args as $k => &$arg) {
                        if (is_array($args[$k])) {
                            foreach ($args[$k] as $j => &$a) {
                                $types .= $this->_gettype($args[$k][$j]);
                                $args_ref[] = &$a;
                            }
                        } else {
                            $types .= $this->_gettype($args[$k]);
                            $args_ref[] = &$arg;
                        }
                    }
                    array_unshift($args_ref, $types);
                    call_user_func_array(array($this->query, 'bind_param'), $args_ref);
                }
                $this->query->execute();
                   if ($this->query->errno) {
                    $this->error('Unable to process MySQL query (check your params) - ' . $this->query->error);
                   }
                $this->query_closed = FALSE;
                $this->query_count++;
            } else {
                $this->error('Unable to prepare MySQL statement (check your syntax) - ' . $this->connection->error);
            }
            return $this;
        }


        public function delete_jobid($jobId){
            $sql = "delete from tidlog_jobs where jobId = ?";
            $stmt =$this->connection->prepare($sql);
            $stmt->bind_param("s", $jobId);
            $stmt->execute();
        }

        public function update_user_image($userName, $imageObject)
        {
            $sql = "UPDATE tidlog_users SET tidlog_userimage = ? WHERE username = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("ss",  $imageObject, $userName);
            $stmt->execute();

            return $stmt;
        }

        public function insert_new_kontrakt($lagenhetId, $hyresgastId, $datum, $kontraktBlob, $fnamn, $enamn)
        {
            $sql = "INSERT INTO tidlog_kontrakt (andra_hand, lagenhet_id, hyresgast_id, datum, kontrakt, fnamn, enamn) VALUES(?, ?, ?, ?, ?,?,?)";

            $andraHand = 0;

            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("sssssss", $andraHand, $lagenhetId, $hyresgastId, $datum, $kontraktBlob, $fnamn, $enamn);
            $stmt->execute();

            return $stmt;
        }

        public function GetLagenhetNoFromLagenhetId($lagenhetid){
            $sql = "SELECT lagenhet_nr FROM tidlog_lagenhet where lagenhet_id =  ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("s",  $lagenhetid);
            $stmt->execute();

            $result = $stmt->get_result();
            
            $theResult = 0;
            
            //$row = $result->fetch_column();

            $theResult = $result->fetch_assoc();
            $theResult = $theResult["lagenhet_nr"];
            // while ($row = $result->fetch_assoc()){
            //     $theResult =  $row;
            // }
            
            return $theResult;
            
        }
        public function insert_old_kontrakt($typAvKontrakt , $lagenhetId, $datum_from, $datum_tom, $kontraktBlob, $fnamn, $enamn)
        {
            $sql = "INSERT INTO tidlog_kontrakt (andra_hand, lagenhet_id, datum, datum_uppsagd, kontrakt, fnamn, enamn) VALUES(?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->connection->prepare($sql);
            
            $typAvKontrakt =(int)$typAvKontrakt;

            $stmt->bind_param("sssssss", $typAvKontrakt, $lagenhetId,  $datum_from, $datum_tom, $kontraktBlob, $fnamn, $enamn);
            $stmt->execute();

            return $stmt;
        }


        public function spara_hyreskoll($hyresgastId, $fakturaId, $dtKollad, $dtInbetald, $diff, $kolladav)
        {
            $sql = "INSERT INTO tidlog_fakturakoll(faktura_id, dt_inbetald, dt_kollad, kollad_av, diff, hyresgast_id) VALUES(?, ?, ?, ?, ?, ?)";

            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("ssssss",  $fakturaId, $dtInbetald, $dtKollad, $kolladav,$diff, $hyresgastId);
            $stmt->execute();

            return $stmt;
        }

        public function insert_new_user($param_username, $param_email, $param_password)
        {
            try{

                $sql = $sql = "INSERT INTO tidlog_users(username, email, password) VALUES (?, ?, ?)";
                $stmt = $this->connection->prepare($sql);
                $stmt->bind_param("sss",  $param_username, $param_email, $param_password);
                $stmt->execute();


                return true;
            } catch(Exception $exception){
                return false;
            }
            
        }


        public function get_user_image($username)
        {
            $sql = "SELECT tidlog_userimage FROM tidlog.tidlog_users where username =  ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("s",  $username);
            $stmt->execute();

            $result = $stmt->get_result();
            
            
            $row = $result->fetch_column();
            return $row;
        }

        public function update_parkering($parkId, $lagenhetId)
        {
            $sql = "UPDATE tidlog_lagenhet SET park_id = ? WHERE lagenhet_id = ?" ;
            
            try{
            
                $stmt = $this->connection->prepare($sql);
                
                $stmt->bind_param("ss",  $parkId, $lagenhetId);
                $stmt->execute();

                return true;
            } catch(Exception $th){
                throw $th;
            }
        }

        public function update_vind($vindId, $lagenhetId)
        {
            $sql = "UPDATE tidlog_lagenhet SET vind_id = ? WHERE lagenhet_id = ?" ;
            
            try{
            
                $stmt = $this->connection->prepare($sql);
                
                $stmt->bind_param("ss",  $vindId, $lagenhetId);
                $stmt->execute();

                return true;
            } catch(Exception $th){
                throw $th;
            }
        }

        public function update_kallare($kallareId, $lagenhetId)
        {
            $sql = "UPDATE tidlog_lagenhet SET kallare_id = ? WHERE lagenhet_id = ?" ;
            
            try{
            
                $stmt = $this->connection->prepare($sql);
                
                $stmt->bind_param("ss",  $kallareId, $lagenhetId);
                $stmt->execute();

                return true;
            } catch(Exception $th){
                throw $th;
            }
        }
        public function update_hyra($lagenhetId, $lagenhetNo, $hyra, $giltligFran){
            

            //Spara retro hyra
            $this->retro_hyra($lagenhetId, $lagenhetNo, $giltligFran);
            $sql = "UPDATE tidlog_lagenhet SET hyra = ? WHERE lagenhet_id = ?" ;
            
            try{
            
                $stmt = $this->connection->prepare($sql);
                
                $stmt->bind_param("ss",  $hyra, $lagenhetId);
                $stmt->execute();

                return true;
            } catch(Exception $th){
                throw $th;
            }
            
        }

        private function retro_hyra($lagenhetId, $lagenhetNo, $giltligDatum)
        {
            $sql = "insert into tidlog_retro_hyra (lagenhet_id, lagenhetNo, hyra_retro, giltlig_datum)";
            $sql .= "select ?, ?, hyra, ? from tidlog_lagenhet l where l.lagenhet_id =?";
            
            try{

                $stmt = $this->connection->prepare($sql);
                $stmt->bind_param("ssss",  $lagenhetId, $lagenhetNo,  $giltligDatum, $lagenhetId);
                $stmt->execute();

                
            } catch( Exception $e){
                throw $e;
            }

            

            
        }

        public function add_moms($lagenthetNo, $moms, $momsProcent){
            $val = 0;

            $sql = "insert into tidlog_moms(lagenhet_id, moms_procent, moms, sparad)
            (select l.lagenhet_id, ?, ?, current_timestamp()  from tidlog_lagenhet l  where l.lagenhet_nr = ?)" ;
            
            try{

                $stmt = $this->connection->prepare($sql);
                
                $stmt->bind_param("sss",  $momsProcent, $moms, $lagenthetNo);
                $stmt->execute();
                return true;

            } catch(Exception $th){
                throw $th;
            }
            
        }

        public function remove_parkering($lagenhetNo)
        {
            $sql = "UPDATE tidlog_lagenhet set park_id = NULL where lagenhet_nr = ?";
            try{
                $stmt = $this->connection->prepare($sql);
                $stmt->bind_param("s", $lagenhetNo);
            
                $stmt->execute();
                $stmt->close();
    
                return true;
            } catch(Exception $e){
                throw $e;
            }
        }

        
        public function remove_vind($lagenhetNo)
        {
            $sql = "UPDATE tidlog_lagenhet set vind_id = NULL where lagenhet_nr = ?";
            try{
                $stmt = $this->connection->prepare($sql);
                $stmt->bind_param("s", $lagenhetNo);
            
                $stmt->execute();
                $stmt->close();
    
                return true;
            } catch(Exception $e){
                throw $e;
            }
        }

        public function remove_kallare($lagenhetNo)
        {
            $sql = "UPDATE tidlog_lagenhet set kallare_id = NULL where lagenhet_nr = ?";
            try{
                $stmt = $this->connection->prepare($sql);
                $stmt->bind_param("s", $lagenhetNo);
            
                $stmt->execute();
                $stmt->close();
    
                return true;
            } catch(Exception $e){
                throw $e;
            }
        }

        public function sag_upp_kontrakt($hyresgastId, $datum)
        {
            $sql = "UPDATE tidlog_kontrakt set datum_uppsagd = ?, hyresgast_id = null where hyresgast_id = ?";
            try{
                $stmt = $this->connection->prepare($sql);
                $stmt->bind_param("ss", $datum, $hyresgastId);
            
                $stmt->execute();
                $stmt->close();
    
                return true;
            } catch(Exception $e){
                throw $e;
            }
        }

        /*
            Spara deposition: tabellerna deposition - hyresgäster. (Relation)
        */
        public function spara_deposition($hyresgast_id, $deposition_datum, $belopp, $lagenhet_id, $kommentar){


            $sql = "insert into tidlog_deposition (hyresgast_id, datum_deposition, belopp, lagenhet_id, kommentar) ";
            $sql = $sql . " VALUES (?, ?, ?, ?, ?)";
            
            try{
                
                $stmt = $this->connection->prepare($sql);
                $stmt->bind_param("sssss", $hyresgast_id, $deposition_datum, $belopp, $lagenhet_id, $kommentar);
            
                $stmt->execute();

                $depositionId = $this->connection->insert_id;
                $sql = "Update tidlog_hyresgaster SET deposition_id = ? WHERE hyresgast_id = ?";
                $stmt2 = $this->connection->prepare($sql);
                $stmt2->bind_param("ss", $depositionId, $hyresgast_id);
                $stmt2->execute();

                $stmt->close();
                $stmt2->close();
                return true;
            } catch(Exception $e){
                throw $e;
            }


        }
        
        /*
            Uppdatera en deposition.
        */  
        public function uppdatera_deposition($depositionId, $deposition_datum, $belopp, $kommentar_ater ){
            
            $sql = "update tidlog_deposition set datum_aterbetalt = ?, belopp_ater = ?, kommentar_ater = ?";
            $sql = $sql . " Where deposition_id = ?";

            try{
                
                $stmt = $this->connection->prepare($sql);
                $stmt->bind_param("ssss", $deposition_datum, $belopp, $kommentar_ater, $depositionId);
            
                $stmt->execute();
                $stmt->close();
    
                return true;
            } catch(Exception $e){
                throw $e;
            }

        }

        public function spara_artikel($artikel, $kommentar)
        {
            $sql = "INSERT INTO tidlog_item(artikel, kommentar) VALUES (?, ?)";
            try{
                $stmt = $this->connection->prepare($sql);
                $stmt->bind_param("ss", $artikel, $kommentar);
            
                $stmt->execute();
                $stmt->close();
    
                return true;
            } catch(Exception $e){
                throw $e;
            }
            
        }
        public function add_lagenhet($fastighetId, $lagenhetNo, $yta)
        {
            $sql = "INSERT INTO tidlog_lagenhet(fastighet_id, lagenhet_nr, yta) VALUES (?, ?, ?)";
            try{
                $stmt = $this->connection->prepare($sql);
                $stmt->bind_param("sss", $fastighetId, $lagenhetNo, $yta);
            
                $stmt->execute();
                $stmt->close();
    
                return true;
            } catch(Exception $e){
                throw $e;
            }
            
        }

        public function uppdatera_hyresgast($hyresgastId, $fnamn,$enamn, $adress, $telefon, $epost, $isandrahand)
        {
            $sql = "UPDATE tidlog_hyresgaster SET fnamn = ?, enamn = ?, adress=?, epost = ?, telefon = ?, andrahand = ? WHERE hyresgast_id = ?";
           
            
            try{
                $andraHand = $isandrahand == "true" ? 1 : 0;

                $stmt = $this->connection->prepare($sql);
                $stmt->bind_param("sssssss", $fnamn, $enamn,$adress, $epost, $telefon, $andraHand, $hyresgastId);
            
                $stmt->execute();
                $stmt->close();
    
                return true;
            } catch(Exception $e){
                throw $e;
            }
        }

        public function ny_hyresgast($lagenhetId, $fnamn,$enamn, $adress, $telefon, $epost, $isandrahand, $update = false)
        {
            
            $sql = "INSERT INTO tidlog_hyresgaster(fnamn, enamn, adress, epost, telefon, andrahand) VALUES (?, ?, ?, ?, ?, ?)";
            
            try{
                $andraHand = $isandrahand == "true" ? 1 : 0;

                $stmt = $this->connection->prepare($sql);
                $stmt->bind_param("ssssss", $fnamn, $enamn,$adress, $epost, $telefon, $andraHand);
            
                $stmt->execute();

                $hyresgastId = $this->connection->insert_id;
                $sql = "Update tidlog_lagenhet SET hyresgast_id = ? WHERE lagenhet_id = ?";
                $stmt2 = $this->connection->prepare($sql);
                $stmt2->bind_param("ss", $hyresgastId, $lagenhetId);
                $stmt2->execute();

                $sql = "UPDATE tidlog_hyresgaster SET LghNo = (select lagenhet_nr from tidlog_lagenhet where lagenhet_id = ?)";
                $stmt3 = $this->connection->prepare($sql);
                $stmt3->bind_param("s", $lagenhetId);
                $stmt3->execute();


                $stmt->close();
                $stmt2->close();
                $stmt3->close();
                return true;
            } catch(Exception $e){
                throw $e;
            }
        }

        public function update_jobid($jobId, $datum, $timmar, $fastighet, $beskrivning){

            $sql = "update tidlog_jobs SET job_date = ?, job_hour = ?, job_fastighet = ?, job_description = ?
                WHERE JobId = ?";
                
            $stmt =$this->connection->prepare($sql);
            
            $stmt->bind_param("sssss", $datum, $timmar, $fastighet, $beskrivning, $jobId);
            $stmt->execute();
        }

        public function update_password($userName, $newPwd)
        {
            $sql = "UPDATE tidlog_users SET password = ? where username = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("ss", $newPwd, $userName);
            $stmt->execute();
            $stmt->close();
        }

        public function spara_faktura($fil, $fakturaId)
        {
            $pfdContent = addslashes(file_get_contents($fil)); 

            $currentDatetime = date('Y-m-d H:i:s');

            $sql = "UPDATE tidlog_faktura SET faktura = ?, faktura_skapad = ? where faktura_id = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("sss", $pfdContent, $currentDatetime, $fakturaId);
            try{
                $stmt->execute();
                $stmt->close();
            } catch (Exception $ex){
                throw $ex;
            }
            
        }

        private function get_faktura_row_index()
        {
            $sql = "select count(*) as count from tidlog_faktura";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();

            $result = $stmt->get_result();
            
            $theResult = 0;
            
            //$row = $result->fetch_column();

            $theResult = $result->fetch_assoc();
            $theResult = $theResult["count"];
            // while ($row = $result->fetch_assoc()){
            //     $theResult =  $row;
            // }
            
            return $theResult;
        }
        /*
            Skapa alla fakturor för en viss månad.
        */
        public function skapa_fakturor($month, $monthNo, $year, $fastighetId)
        {
            $hyresGaster = $this->query("select th.hyresgast_id , tl.lagenhet_id , tp.park_id, tl.lagenhet_id, tl.lagenhet_nr, tf.fastighet_id, 
            tl.hyra, tp.avgift, tm.meddelande, tm.giltlig_fran , tm.giltlig_till
            from tidlog_hyresgaster th 
                inner join tidlog_lagenhet tl ON th.hyresgast_id = tl.hyresgast_id
                inner join tidlog_fastighet tf on tf.fastighet_id =tl.fastighet_id
                left outer join tidlog_parkering tp on tp.park_id =tl.park_id
                left outer join tidlog_meddelande tm on tm.hyresgast_id =th.hyresgast_id 
                where tf.fastighet_id = " . $fastighetId  )->fetchAll();
            
            $sql ="";

            $index_faktura = $this->get_faktura_row_index();

            foreach($hyresGaster as $row)
            {
                $index_faktura++;
                $hyresgastId = $row["hyresgast_id"];
                $lagenhetId = $row["lagenhet_id"];
                $parkId = $row["park_id"];

                //$fakturaNr = $row["lagenhet_nr"] . "-" . $month . "-" . $year;
                $fakturaNr = $year . $monthNo . $row["fastighet_id"] . "0000" . $index_faktura;
                $fakturaDatum = date('Y-m-d');
                $ocr = "ocr";
                $dueDate = date("Y-m-t");
                $spec = 'hyra för ' . $month . " " .$year;

                $beloppHyra = $row["hyra"];
                $beloppPark = $row["avgift"] == null ? 0 : $row["avgift"];

                $meddelande = $row['meddelande'];
                $monthMeddelandeFran = date('m', strtotime($row['giltlig_fran']));
                $monthMeddelandeTill = date('m', strtotime($row['giltlig_till']));

                if ( (intval($monthMeddelandeFran) - intval($monthNo)) != 0 )
                {
                    $meddelande = "";
                }
                if ( (intval($monthMeddelandeTill) - intval($monthNo)) != 0 )
                {
                    $meddelande = "";
                }

                $sql = "INSERT INTO tidlog_faktura(belopp_hyra, belopp_parkering, hyresgast_id, 
                    lagenhet_id, park_id, fakturanummer, 
                    FakturaDatum, ocr, duedate, specifikation, 
                        `faktura_year`, `faktura_month`, meddelande)
                
                VALUES(?,?,?,?,?,?,?,?,?,?,?,?, ?)";

                $stmt = $this->connection->prepare($sql);
                $stmt->bind_param("sssssssssssss", $beloppHyra, $beloppPark, $hyresgastId, $lagenhetId, $parkId, $fakturaNr, $fakturaDatum, $ocr, $dueDate, $spec, $year, $monthNo, $meddelande);

                $stmt->execute();
                $stmt->close();

                

            }
        }

        /*
        * Ta bort hyresgäst
        */

        public function tabort_hyresgast($hyresgastId, $lagenhetId)
        {
            $sql = "UPDATE tidlog_lagenhet SET hyresgast_id = NULL where lagenhet_id = ?";
            
            try{
                $stmt = $this->connection->prepare($sql);
                $stmt->bind_param("s", $lagenhetId);
    
                $stmt->execute();
                
            } catch (Exception $e){
                throw $e;
            }
            
        }

        /*
            Ta bort deposition
        */

        public function tabort_deposition($hyresgastId)
        {
            $sql = "UPDATE tidlog_hyresgaster SET deposition_id = NULL where hyresgast_id = ?";
            
            try{
                $stmt = $this->connection->prepare($sql);
                $stmt->bind_param("s", $hyresgastId);
    
                $stmt->execute();
                
            } catch (Exception $e){
                throw $e;
            }
            
        }

        /*
            Ta bort tidsregistering
        */

        function tabort_tidsregistrering($jobId)
        {
            $sql = "DELETE from tidlog_jobs where jobid = ?";
            
            try{
                $stmt = $this->connection->prepare($sql);
                $stmt->bind_param("s", $jobId);
    
                $stmt->execute();
                
            } catch (Exception $e){
                throw $e;
            }
        }

        /*
            ta bort extra faktura
        */
        function remove_extraartikel($artikelId)
        {
            $sql = "DELETE from tidlog_artikel where artikel_id = ?";
            
            try{
                $stmt = $this->connection->prepare($sql);
                $stmt->bind_param("s", $artikelId);
    
                $stmt->execute();
                
            } catch (Exception $e){
                throw $e;
            }
        }

        /*
            ta bort extra meddelande
        */
        function radera_avimeddelande($meddelandeId)
        {
            $sql = "DELETE from tidlog_meddelande where meddelande_id = ?";
            
            try{
                $stmt = $this->connection->prepare($sql);
                $stmt->bind_param("s", $meddelandeId);
    
                $stmt->execute();
                
            } catch (Exception $e){
                throw $e;
            }
        }

        
        public function total_hours (){
            
            $sql = "SELECT SUM(job_hour) AS total_hours FROM tidlog_jobs;";
            $result = $this->connection->query($sql);
            $row = $result->fetch_assoc();
            return (int)$row["total_hours"];
        }

        public function total_registrations_for_user($userName){
            $sql = "select count(*) as count from tidlog_jobs where job_username = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("s", $userName);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $rows = $result->fetch_assoc()["count"];

            return $rows ;
        }

        public function total_hours_for_month (){
            $sql = "select SUM(job_hour) AS total_hours from tidlog_jobs where (tidlog_jobs.job_date between  DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW() )";
            $result = $this->connection->query($sql);
            $row = $result->fetch_assoc();
            return (int)$row["total_hours"];
        }

        public function fetchAll($callback = null) {
            $params = array();
            $row = array();
            $meta = $this->query->result_metadata();
            while ($field = $meta->fetch_field()) {
                $params[] = &$row[$field->name];
            }
            call_user_func_array(array($this->query, 'bind_result'), $params);
            $result = array();
            while ($this->query->fetch()) {
                $r = array();
                foreach ($row as $key => $val) {
                    $r[$key] = $val;
                }
                if ($callback != null && is_callable($callback)) {
                    $value = call_user_func($callback, $r);
                    if ($value == 'break') break;
                } else {
                    $result[] = $r;
                }
            }
            $this->query->close();
            $this->query_closed = TRUE;
            return $result;
        }
    
        public function fetchArray() {
            $params = array();
            $row = array();
            $meta = $this->query->result_metadata();
            while ($field = $meta->fetch_field()) {
                $params[] = &$row[$field->name];
            }
            call_user_func_array(array($this->query, 'bind_result'), $params);
            $result = array();
            while ($this->query->fetch()) {
                foreach ($row as $key => $val) {
                    $result[$key] = $val;
                }
            }
            $this->query->close();
            $this->query_closed = TRUE;
            return $result;
        }

        public function error($error) {
            if ($this->show_errors) {
                exit($error);
            }
        }
    
        private function _gettype($var) {
            if (is_string($var)) return 's';
            if (is_float($var)) return 'd';
            if (is_int($var)) return 'i';
            return 'b';
        }
    
    }

?>