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

    if ($_POST["nameOfFunction"] == "uppdatera_hyresgast"){
        add_hyresgast(true);
    }

    if ($_POST["nameOfFunction"] == "filter_lagenhet"){
        filter_lagenhet();
    }

    if ($_POST["nameOfFunction"] == "change_password"){
        change_password();
    }

    if ($_POST["nameOfFunction"] == "add_hyra"){
        add_hyra();
    }

    if ($_POST["nameOfFunction"] == "remove_parkering") {
        remove_parkering();
    }

    if ($_POST["nameOfFunction"] == "sag_upp_kontrakt") {
        sag_upp_kontrakt();
    }
    
    
}
    function change_password()
    {
        if (!isset($_SESSION)) { session_start(); }
        include_once "./config.php";
        include_once "./dbmanager.php";
        $db = new DbManager();

        $errors = [];
        $data = [];

        if (empty($_POST['user_id'])) {
            $errors['user_id'] = 'Användare?.';
        }

        if (empty($_POST['old_pwd'])) {
            $errors['old_pwd'] = 'Befintligt lösenord?.';
        }

        if (empty($_POST['new_pwd'])) {
            $errors['new_pwd'] = 'Nytt lösenord?.';
        }

        try{

            if (!empty($errors)){
                $err = "";
                foreach ($errors as $x) {
                    $err =  "$x <br>";
                }
                throw new Exception($err);
            }

            $user_id = $_POST["user_id"];
            $old_pwd = $_POST["old_pwd"];
            $hashedPwd = "";
            $new_pwd = $_POST["new_pwd"];

            //$current_password = 
            $sql = "select password from tidlog_users where username = ?";
            $data = $db->query($sql, array($user_id))->fetchAll();

            foreach($data as $row){
                $hashedPwd = $row["password"];
            }

            if (!password_verify($old_pwd, $hashedPwd)) {
                throw new Exception("Du har angivit fel lösenord.");
            }

            if (strlen($new_pwd) < 8) {
                throw new Exception("Lösenordet måste var minst 8 tecken");
            }

            $param_password = password_hash($new_pwd, PASSWORD_DEFAULT);
            
            $db->update_password($user_id, $param_password);


            echo json_encode(['change_password' => 'true']);

        }catch(\Throwable $th){

            echo json_encode(['change_password' => 'false', 'orsak' => $th->getMessage()]);
        }

    }
    function filter_lagenhet()
    {
        if (!isset($_SESSION)) { session_start(); }
        include_once "./config.php";
        include_once "./dbmanager.php";
        $db = new DbManager();

        $errors = [];
        $data = [];

        if (empty($_POST['fastighet_id'])) {
            $errors['fastighet_id'] = 'Fastighet?.';
        }

        try{

            if (!empty($errors)){
                $err = "";
                foreach ($errors as $x) {
                    $err =  "$x <br>";
                }
                throw new Exception($err);
            }

            $fastighet_id = $_POST["fastighet_id"];

            $data = null;
            $sql = "SELECT * from tidlog_lagenhet l inner join tidlog_fastighet f ON l.fastighet_id = f.fastighet_id
                    WHERE l.fastighet_id = ? ORDER BY lagenhet_nr ";

            $data = $db->query($sql, array($fastighet_id))->fetchAll();
            $resultSet = array();

            foreach ($data as $row) {
                $resultSet[] = $row;
            }
                 
            echo json_encode(['filter_lagenhet' => $resultSet]);

        }catch(\Throwable $th){

            echo json_encode(['filter_lagenhet' => 'false', 'orsak' => $th->getMessage()]);
        }

    }

    function add_hyresgast($uppdatera=false)
    {
        if (!isset($_SESSION)) { session_start(); }
        include_once "./config.php";
        include_once "./dbmanager.php";
        $db = new DbManager();
        $errors = [];
        $data = [];

        // if (empty($_POST['lagenhet_id'])) {
        //     $errors['lagenhetId'] = 'Lägenhet?';
        // }

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
    
            //$lagenhetId = $_POST["lagenhet_id"];
            $fnamn = $_POST["fnamn"];
            $enamn = $_POST["enamn"];
            $telefon = $_POST["telefon"];
            $epost = $_POST["epost"];    

            if ($uppdatera == false){
                if ($db->ny_hyresgast($lagenhetId, $fnamn,$enamn, $telefon, $epost, false))
                {
                    echo json_encode(['added_hyresgast' => 'true']);
                }
            } else{
                
                $hyresgastId = $_POST['hyresgast_id'];

                if ($db->ny_hyresgast($hyresgastId, $fnamn,$enamn, $telefon, $epost, true))
                {
                    echo json_encode(['added_hyresgast' => 'true']);
                }
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

    function add_hyra()
    {
        $db = new DbManager();
        
        $lagenthetNo = $_POST["lagenhetNo"];
        $hyra  = $_POST["hyra"];
        $parkering = $_POST["parkering"];

        try {
            if ($db->add_hyra($lagenthetNo, $hyra, $parkering))
            {
                echo json_encode(['add_hyra' => 'true']);
            } 
        } catch (\Throwable $th) {
            echo json_encode(['add_hyra' => 'false', 'orsak' => $th->getMessage()]);
        }
        
    }

    function remove_parkering()
    {
        $db = new DbManager();
        
        $lagenthetNo = $_POST["lagenhetNo"];
        
        try {
            if ($db->remove_parkering($lagenthetNo))
            {
                echo json_encode(['remove_parkering' => 'true']);
            } 
        } catch (\Throwable $th) {
            echo json_encode(['remove_parkering' => 'false', 'orsak' => $th->getMessage()]);
        }
        
    }

    function sag_upp_kontrakt()
    {
        $db = new DbManager();
        
        $hyresgastId = $_POST["hyresgastId"];
        $datum = $_POST["datum"];

        try {
            if ($db->sag_upp_kontrakt($hyresgastId, $datum))
            {
                echo json_encode(['sag_upp_kontrakt' => 'true']);
            } 
        } catch (\Throwable $th) {
            echo json_encode(['sag_upp_kontrakt' => 'false', 'orsak' => $th->getMessage()]);
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