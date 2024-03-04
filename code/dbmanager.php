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

        public function get_faktura_underlag($year, $month)
        {
            $fakturor = $this->query("select * from tidlog_faktura tf 
            inner join tidlog_hyresgaster th on tf.hyresgast_id = th.hyresgast_id 
            inner join tidlog_lagenhet tl on tl.lagenhet_id = tf.lagenhet_id 
            left outer join tidlog_parkering tp on tp.park_id =tl.park_id 
            WHERE tf.faktura_year = ? and tf.faktura_month = ?", array($year, $month))->fetchAll();

            return $fakturor;
        }

        public function getRowCount()
        {
            $sql = "select count(*) as count from tidlog_jobs";
            $result = $this->connection->query($sql);
            $row = $result->fetch_assoc();
            return (int)$row["count"];
        }

        public function getLagenhetCount()
        {
            $sql = "select count(*) as count from tidlog_lagenhet";
            $result = $this->connection->query($sql);
            $row = $result->fetch_assoc();
            return (int)$row["count"];
        }

        public function getHyresgastCount()
        {
            $sql = "select count(*) as count from tidlog_hyresgaster";
            $result = $this->connection->query($sql);
            $row = $result->fetch_assoc();
            return (int)$row["count"];
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

        public function insert_new_kontrakt($lagenhetId, $hyresgastId, $datum, $kontraktBlob, $kontraktNamn)
        {
            $sql = "INSERT INTO tidlog_kontrakt (lagenhet_id, hyresgast_id, datum, kontrakt, kontrakt_namn) VALUES(?, ?, ?, ?, ?)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("sssss",  $lagenhetId, $hyresgastId, $datum, $kontraktBlob, $kontraktNamn);
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

        public function add_hyra($lagenhetNo, $hyra, $parkering){
            $val = 0;

            if ($parkering == 0){
                $sql = "UPDATE tidlog_lagenhet SET hyra = ? WHERE lagenhet_nr = ?" ;
                $val = $hyra;
            } else if ($hyra == 0){
                $sql = "UPDATE tidlog_lagenhet SET park_id = ? WHERE lagenhet_nr = ?" ;
                $val =$parkering;
            }
            try{
                $stmt = $this->connection->prepare($sql);
                
                $stmt->bind_param("ss",  $val, $lagenhetNo);
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

        public function sag_upp_kontrakt($hyresgastId, $datum)
        {
            $sql = "UPDATE tidlog_kontrakt set datum_uppsagd = ? where hyresgast_id = ?";
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

        public function ny_hyresgast($lagenhetId, $fnamn,$enamn, $adress, $telefon, $epost, $isandrahand, $update = false)
        {
            $sql = "";
            if ($update){
                $sql = "UPDATE tidlog_hyresgaster SET fnamn = ?, enamn = ?, adress=?, epost = ?, telefon = ?, andrahand = ? WHERE hyresgast_id = ?";
            } else {
                $sql = "INSERT INTO tidlog_hyresgaster(lagenhet_id, fnamn, enamn, adress, epost, telefon, andrahand) VALUES (?, ?, ?, ?, ?, ?, ?)";
            }
            
            try{
                $andraHand = $isandrahand == "true" ? 1 : 0;

                $stmt = $this->connection->prepare($sql);
                $stmt->bind_param("sssssss", $fnamn, $enamn,$adress, $epost, $telefon, $andraHand, $lagenhetId);
            
                $stmt->execute();
                $stmt->close();
    
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

        public function spara_faktura($fil, $hyresgastId)
        {
            $pfdContent = addslashes(file_get_contents($fil)); 
            

            $sql = "UPDATE tidlog_faktura SET faktura = ? where hyresgast_id = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("ss", $pfdContent, $hyresgastId);
            $stmt->execute();
            $stmt->close();
        }

        /*
            Skapa alla fakturor för en viss månad.
        */
        public function skapa_fakturor($month, $monthNo, $year)
        {
            $hyresGaster = $this->query("select th.hyresgast_id , tl.lagenhet_id , tp.park_id, tl.lagenhet_id, tl.lagenhet_nr 
            from tidlog_hyresgaster th 
                inner join tidlog_lagenhet tl ON th.lagenhet_id = tl.lagenhet_id
                left outer join tidlog_parkering tp on tp.park_id =tl.park_id 
                left outer join tidlog_faktura tf on tf.lagenhet_id = tl.lagenhet_id")->fetchAll();
            
            $sql ="";

            foreach($hyresGaster as $row)
            {
                $hyresgastId = $row["hyresgast_id"];
                $lagenhetId = $row["lagenhet_id"];
                $parkId = $row["park_id"];

                $fakturaNr = $row["lagenhet_nr"] . "-" . $month . "-" . $year;
                $fakturaDatum = date('Y-m-d');
                $ocr = "ocr";
                $dtTmp = strval($year) . strval($month) . "-01";
                $dueDate = date("Y-m-t", strtotime($dtTmp));
                $spec = 'hyra för ...';

                $sql = "INSERT INTO tidlog_faktura( hyresgast_id, 
                    lagenhet_id, park_id, fakturanummer, 
                    FakturaDatum, ocr, duedate, specifikation, 
                        `faktura_year`, `faktura_month`)
                
                VALUES(?,?,?,?,?,?,?,?,?,?)";

                $stmt = $this->connection->prepare($sql);
                $stmt->bind_param("ssssssssss", $hyresgastId, $lagenhetId, $parkId, $fakturaNr, $fakturaDatum, $ocr, $dueDate, $spec, $year, $monthNo);

                $stmt->execute();
                $stmt->close();

                

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