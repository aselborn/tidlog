<?php
    //Registrera inbetalning!
    if (!isset($_SESSION)) { session_start(); }
    require_once "dbmanager.php";
    require_once "managesession.php";


    $data = json_decode( $_POST['inbet'], true);

    foreach($data as $item){
        
        $faktId = $item["fakturaId"];
        $summa = $item["radSumma"];

        
    }

?>