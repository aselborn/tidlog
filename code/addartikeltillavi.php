<?php 
    // header('Location:'.$_SERVER['SERVER_NAME'].'/extrafaktura.php');

    if (!isset($_SESSION)) { session_start(); }
    include_once "./config.php";
    include_once "./dbmanager.php";

    $hyresgastId = $_POST['hyresgast'];
    $fastighetId = $_POST['hidFastighetId'];

    $itemId =  $_POST['items'];
    $meddelande = $_POST['meddelande_hyresgast'];

    $pris = intval($_POST['pris']);
    $moms = $_POST['moms'];
    $momsbelopp = 0;

    if ($moms > 0)
    {
        $momsbelopp = doubleval($pris * ($moms / 100));
    }

    $totalbelopp = intval($pris + $momsbelopp);

    $giltligFran = $_POST['giltlig_fran'];
    $giltligTill = $_POST['giltlig_till'];
    
    $medHyra =1;
    $time_stamp = 'current_timestamp()';
    

    $errors = [];
    $data = [];

    $form_data = array();

    $sql = "INSERT INTO tidlog_artikel(med_hyra, hyresgast_id, item_id, totalbelopp, nettobelopp, momsbelopp, moms, kommentar, giltlig_from, giltlig_tom, skapad)";
    $sql .= "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, $time_stamp)";

    $stmt = $link->prepare($sql);
    $stmt->bind_param("ssssssssss", $medHyra, $hyresgastId,$itemId, $totalbelopp, $pris, $momsbelopp, $moms, $meddelande, $giltligFran, $giltligTill);
    $stmt->execute(); 
    $stmt->close();

    header("Location: ../extrafaktura.php?page=1&fastighetId=".$fastighetId .  "&hyresgastId=" .$hyresgastId  );
    exit;
?>