<?php 
    // header('Location:'.$_SERVER['SERVER_NAME'].'/extrafaktura.php');

    if (!isset($_SESSION)) { session_start(); }
    include_once "./config.php";
    include_once "./dbmanager.php";

    $hyresgastId = $_POST['hyresgast'];
    $itemId =  $_POST['items'];
    $meddelande = $_POST['meddelande_hyresgast'];

    $totalbelopp = $_POST['pris'];

    $giltligFran = $_POST['giltlig_fran'];
    $giltligTill = $_POST['giltlig_till'];
    
    $medHyra =1;
    $time_stamp = 'current_timestamp()';

    $errors = [];
    $data = [];

    $form_data = array();

    $sql = "INSERT INTO tidlog_artikel(med_hyra, hyresgast_id, item_id, totalbelopp, kommentar, giltlig_from, giltlig_tom, skapad)";
    $sql .= "VALUES (?, ?, ?, ?, ?, ?, ?, $time_stamp)";

    $stmt = $link->prepare($sql);
    $stmt->bind_param("sssssss", $medHyra, $hyresgastId,$itemId, $totalbelopp, $meddelande, $giltligFran, $giltligTill);
    $stmt->execute();
    $stmt->close();
?>