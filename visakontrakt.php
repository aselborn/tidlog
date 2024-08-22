<?php 
    
     if (!isset($_SESSION)) { session_start(); }
     require_once "./code/dbmanager.php";
     require_once "./code/managesession.php";

    $db = new DbManager();
    

     $kontraktId = $_GET["kontraktId"];

     $mittKontrakt = $db->query("select kontrakt, fnamn, enamn from tidlog_kontrakt where kontrakt_id = ?", array($kontraktId))->fetchAll();

     $theKontrakt = null;
     $kontraktNamn = null;
     foreach($mittKontrakt as $row)
     {
        $theKontrakt = $row["kontrakt"];
        $kontraktNamn = $row["fnamn"] . "_" . $row["enamn"];
     }

     if ($theKontrakt == null)
     {
         echo "Det finns inget kontrakt för id = " . $kontraktId;
     }

     $content = stripslashes($theKontrakt);

     header('Content-type: application/pdf');
     header('Content-Disposition: inline; filename=' . $kontraktNamn . '.pdf');
     header('Content-Transfer-Encoding: binary');
     header('Accept-Ranges: bytes');

     echo $content;

     //@readfile("data:application/pdf;base64, $content");
     
?>
