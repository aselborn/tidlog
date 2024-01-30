<?php 

if (!isset($_SESSION)) { session_start(); }
    
include_once "config.php";
include_once "dbmanager.php";
require "managesession.php";

if (isset($_POST["nameOfFunction"])){
    if ($_POST["nameOfFunction"] == "filter_report"){
        filter_report();
    }
}
    

    function filter_report()
    {
        $user = $_SESSION["username"];
        $db = new DbManager();
        $dtFom = $_POST["fomDate"];
        $dtTom = $_POST["tomDate"];
        $fastighet  =$_POST["fastighet"];

        $data = $db->query("select * from tidlog_jobs WHERE job_username = ? and job_date BETWEEN ? and ? and job_fastighet = ?", array($user, $dtFom, $dtTom, $fastighet))->fetchAll();
        $resultSet = array();

        try{
            
            foreach ($data as $row) {
                $resultSet[] = $row;
            }
            
            echo json_encode(['filtered_report' => $resultSet]);

        } catch(Exception $e){
            echo json_encode(array('error' => $e->getMessage()));
        }
        
    }

?>