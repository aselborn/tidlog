<?php 
 
    if (!isset($_SESSION)) { session_start(); }
    
    require_once "dbmanager.php";
    require_once "managesession.php";

    $dtFom = $_POST["dt_fom"];
    $dtTom = $_POST["dt_tom"];

    $db = new DbManager();

    //$data = $db->GetInbetalningar($dtFom, $dtTom);

    $_SESSION["inbet_search"] = $data;

    header("Location: ../visainbetalningar.php");
?>