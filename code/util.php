<?php 

if (!isset($_SESSION)) { session_start(); }
    
include_once "config.php";
include_once "dbmanager.php";
require "managesession.php";

if (isset($_POST["nameOfFunction"])){
    if ($_POST["nameOfFunction"] == "filter_report"){
        filter_report();
    }
    if ($_POST["nameOfFunction"] == "fastigheter") {
        get_fastigheter();
    }

    if ($_POST["nameOfFunction"] == "add_apartment"){
        add_apartment();
    }
    
    if ($_POST["nameOfFunction"] == "add_hyresgast"){
        add_hyresgast();
    }
}
    
    function add_hyresgast()
    {
        if (!isset($_SESSION)) { session_start(); }
        include_once "./config.php";
        include_once "./dbmanager.php";
        $db = new DbManager();
        $errors = [];
        $data = [];

        if (empty($_POST['lagenhet_id'])) {
            $errors['lagenhetId'] = 'Lägenhet?';
        }

        if (empty($_POST['fnamn'])) {
            $errors['fnamn'] = 'Förnamn?.';
        }

        if (empty($_POST['enamn'])) {
            $errors['enamn'] = 'Efternamn?.';
        }

        if (empty($_POST['epost'])) {
            $errors['epost'] = 'Epost?.';
        }

        if (empty($_POST['telefon'])) {
            $errors['telefon'] = 'Telefon?.';
        }

        try{

            if (!empty($errors)) {
                $data['success'] = false;
                $data['errors'] = $errors;

                $err = "";

                foreach ($errors as $x) {
                    $err =  "$x <br>";
                }

                throw new Exception("Fel i indata " . $x);
            } else {
                $data['success'] = true;
                $data['message'] = 'Success!';
            }
    
            $lagenhetId = $_POST["lagenhet_id"];
            $fnamn = $_POST["fnamn"];
            $enamn = $_POST["enamn"];
            $telefon = $_POST["telefon"];
            $epost = $_POST["epost"];    

            if ($db->ny_hyresgast($lagenhetId, $fnamn,$enamn, $telefon, $epost))
            {
                echo json_encode(['added_hyresgast' => 'true']);
            }
        } catch(\Throwable $th){
            echo json_encode(['added_apartment' => 'false', 'orsak' => $th->getMessage()]);
        }

    }   
    function add_apartment()
    {
        

        $user = $_SESSION["username"];
        $db = new DbManager();
        $fastighetId = $_POST["fastighet_Id"];
        $lagenthetNo = $_POST["lagenhet_No"];
        $yta  =$_POST["yta"];

        try {
            if ($db->add_lagenhet($fastighetId, $lagenthetNo, $yta))
            {
                echo json_encode(['added_apartment' => 'true']);
            } 
        } catch (\Throwable $th) {
            echo json_encode(['added_apartment' => 'false', 'orsak' => $th->getMessage()]);
        }
        
    }

    function filter_report()
    {
        $user = $_SESSION["username"];
        $db = new DbManager();
        $dtFom = $_POST["fomDate"];
        $dtTom = $_POST["tomDate"];
        $fastighet  =$_POST["fastighet"];

        $data = null;

        if (strcmp($fastighet, 'Alla') == 0){
            $data = $db->query("select date(job_date) as job_date, job_hour, job_fastighet, job_description FROM tidlog_jobs WHERE job_username = ? and job_date BETWEEN ? and ? ORDER BY job_date DESC", array($user, $dtFom, $dtTom))->fetchAll();
        } else{
            $data = $db->query("select date(job_date) as job_date, job_hour, job_fastighet, job_description FROM tidlog_jobs WHERE job_username =  ? and job_date BETWEEN ? and ? and job_fastighet = ? ORDER BY job_date DESC", array($user, $dtFom, $dtTom, $fastighet))->fetchAll();
        }

        
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

    function get_fastigheter(){
        $db = new DbManager();
        $data =  $db->query("SELECT * FROM tidlog_fastighet");
        $resultSet = array();

        try{
            
            foreach ($data as $row) {
                $resultSet[] = $row;
            }
            
            echo json_encode(['fastigheter' => $resultSet]);

        } catch(Exception $e){
            echo json_encode(array('error' => $e->getMessage()));
        }
    }
?>