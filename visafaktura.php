<?php 
     header('Content-type: application/pdf');
     header('Content-Disposition: inline; filename=name.pdf');
     header('Content-Transfer-Encoding: binary');
     header('Accept-Ranges: bytes');

     if (!isset($_SESSION)) { session_start(); }
     require_once "./code/dbmanager.php";
     require_once "./code/managesession.php";

    $db = new DbManager();
    //  if (!isset($_GET["faktura_id"]))
    //  {
    //     echo "<h1>Faktura är inte angiven!</h1>";
    //     return;
    //  }

     $fakturaId = $_GET["fakturaId"];

     $minFaktura = $db->query("select faktura from tidlog_faktura where faktura_id = ?", array($fakturaId))->fetchAll();

     $theFaktura = null;
     foreach($minFaktura as $row)
     {
        $theFaktura = $row["faktura"];
     }

     @readfile("data:application/pdf;base64, $minFaktura");
     
?>
