<?php
      if (!isset($_SESSION)) { session_start(); }
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";

      $db = new DbManager();

      if (!isset($_GET['page'])) 
      {
          $page = 1;
      } else {
          $page = $_GET['page'];
      }

      
      

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Avisering</title>
    </head>

    <body>
        
        <?php include("./pages/sidebar.php") ?>

        <div class="col-sm  min-vh-100 border">
            <h2>Avisering</h2>
            <hr />
            <div class="container " >
                <input type="button" value="Skapa PDF" id="btnPdf" class="btn btn-success"></input>
            </div>
        </body>
</html>