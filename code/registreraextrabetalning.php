<?php 
 
    if (!isset($_SESSION)) { session_start(); }
    
    require_once "dbmanager.php";
    require_once "managesession.php";
    

    $fakturaBelopp = 0;
    if (isset($_POST['nytt_faktura_belopp']))
    {
        $fakturaBelopp = $_POST['nytt_faktura_belopp'];
    } else {
        unset($_SESSION["extra_faktura"]);
    }
    
    $fakturaId = null;
    if (isset($_POST['faktura_id_name'])){
        $fakturaId = $_POST['faktura_id_name'];
    } else{
        unset($_SESSION["extra_faktura"]);
    }

    $datum = null;
    if (isset($_POST['datum_ny_inbetalning'])){
        $datum = $_POST['datum_ny_inbetalning'];
    } else {
        unset($_SESSION["extra_faktura"]); 
    }
    
    
    $db = new DbManager();
    if ($fakturaBelopp>0 && $datum != null && $fakturaId != 0){
        $db->registrera_extra_betalning((int)$fakturaId, $datum, (int)$fakturaBelopp);
        header("Location: ../extrainbetalning.php?faktid=" . $fakturaId);
    } else {
        header("Location: ../extrainbetalning.php");
    }
    
?>