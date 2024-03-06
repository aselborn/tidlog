<?php 
    
     if (!isset($_SESSION)) { session_start(); }
     require_once "./code/dbmanager.php";
     require_once "./code/managesession.php";

    $db = new DbManager();
    

     $fakturaId = $_GET["fakturaId"];

     $minFaktura = $db->query("select faktura, fakturanummer from tidlog_faktura where faktura_id = ?", array($fakturaId))->fetchAll();

     $theFaktura = null;
     $fakturaNummer = null;
     foreach($minFaktura as $row)
     {
        $theFaktura = $row["faktura"];
        $fakturaNummer = $row["fakturanummer"];
     }

     if ($theFaktura == null)
     {
         echo "Det finns ingen faktura för id = " . $fakturaId;
     }

     $content = stripslashes($theFaktura);

     header('Content-type: application/pdf');
     header('Content-Disposition: inline; filename=' . $fakturaNummer . '.pdf');
     header('Content-Transfer-Encoding: binary');
     header('Accept-Ranges: bytes');

     echo $content;

     //@readfile("data:application/pdf;base64, $content");
     
?>
