<?php 
//Denna fil skall söka efter avier som inte är inbetalade.
if (!isset($_SESSION)) { session_start(); }
include_once "config.php";
include_once "dbmanager.php";
require "managesession.php";;

if (isset($_POST["search_for"])){

    if ($_POST["search_for"] == "faktura_nummer"){
        search_faktura();
    }

    if ($_POST["search_for"] == "belopp"){
        search_faktura_by_belopp();
    }
}


function search_faktura(){
    $db = new DbManager();
    
    $faktnr = $_POST["faktNr"];
    $fastighet  =1; //$_POST["fastighet"];

    $sql = "
        select tf.fakturanummer , (tf.belopp_hyra + tf.belopp_parkering) as belopp , concat(th.fnamn , ' ',  + th.enamn) as namn ,
        tl.lagenhet_nr as lagenhetNo, tf.FakturaDatum 
            from tidlog_faktura tf 
                inner join tidlog_hyresgaster th on th.hyresgast_id =tf.hyresgast_id 
                inner join tidlog_lagenhet tl on tf.lagenhet_id = tl.lagenhet_id 
                where tf.fakturanummer  like ?
        ";
    
    $resultSet = array();

    try{

        $data = $db->search_faktura($sql, $faktnr, $fastighet);
        
        foreach ($data as $row) {
            $resultSet[] = $row;
        }
        
        $encoded = json_encode(['fakturor' => $resultSet]);

        echo json_encode(['fakturor' => $resultSet]);

    } catch(Exception $e){
        echo json_encode(array('error' => $e->getMessage()));
    }
}

function search_faktura_by_belopp(){
    $db = new DbManager();
    
    $faktnr = $_POST["faktNr"];
    $belopp = $_POST['belopp'];
    
    $fastighet  =1; //$_POST["fastighet"];

    $sql = "
        select tf.fakturanummer , (tf.belopp_hyra + tf.belopp_parkering) as belopp , concat(th.fnamn , ' ',  + th.enamn) as namn ,
        tl.lagenhet_nr as lagenhetNo, tf.FakturaDatum 
            from tidlog_faktura tf 
                inner join tidlog_hyresgaster th on th.hyresgast_id =tf.hyresgast_id 
                inner join tidlog_lagenhet tl on tf.lagenhet_id = tl.lagenhet_id 
                where tf.fakturanummer  like ?
        ";
    
    $resultSet = array();

    try{

        $data = $db->search_faktura($sql, $faktnr, $fastighet);
        
        foreach ($data as $row) {
            $resultSet[] = $row;
        }
        
        $encoded = json_encode(['fakturor' => $resultSet]);

        echo json_encode(['fakturor' => $resultSet]);

    } catch(Exception $e){
        echo json_encode(array('error' => $e->getMessage()));
    }
}
?>