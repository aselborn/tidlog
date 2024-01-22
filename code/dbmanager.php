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

        public function getRowCount()
        {
            $sql = "select count(*) as count from tidlog_jobs";
            $result = $this->connection->query($sql);
            $row = $result->fetch_assoc();
            return (int)$row["count"];
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

        public function update_jobid($jobId, $datum, $timmar, $fastighet, $beskrivning){

            $sql = "update tidlog_jobs SET job_date = ?, job_hour = ?, job_fastighet = ?, job_description = ?
                WHERE JobId = ?";
                
            $stmt =$this->connection->prepare($sql);
            $stmt->bind_param("sssss", $datum, $timmar, $fastighet, $beskrivning, $jobId);
            $stmt->execute();
        }


        public function total_hours (){
            
            $sql = "SELECT SUM(job_hour) AS total_hours FROM tidlog_jobs;";
            $result = $this->connection->query($sql);
            $row = $result->fetch_assoc();
            return (int)$row["total_hours"];
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