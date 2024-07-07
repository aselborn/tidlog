<?php 
 
    if (!isset($_SESSION)) { session_start(); }
    
    require_once "dbmanager.php";
    require_once "managesession.php";
    
    //$referer = $_SERVER['HTTP_REFERER'];
    if (isset($_POST['df_fom'])){
        $dtFom = $_POST["dt_fom"];
    }
    if (isset($_POST['dt_tom'])){
        $dtTom = $_POST["dt_tom"];
    }
    
    
    $sok_en_faktura=true;

    $sok_en_faktura = $_GET["sokfaktura"];
    
    $db = new DbManager();

    if ($sok_en_faktura === "true")
    {
        $fakturaNr = trim($_POST['faktura_nummer']);

        $faktura = $db->sok_extra_faktura($fakturaNr);
        $_SESSION["extra_faktura"] = $faktura;

        header("Location: ../extrainbetalning.php?fakturanr=" . $fakturaNr );
        return;  
    }

    $data = $db->GetInbetalningar($dtFom, $dtTom);

    $_SESSION["inbet_search"] = $data;

    header("Location: ../visainbetalningar.php");
?>