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
                <table id="tblAvisering" class="table table-primary">

                    <tr>
                        <th scope="col" class="table-primary">Hyresgäst</th>
                        <th scope="col" class="table-primary">Lägenhet</th>
                        <th scope="col" class="table-primary">Belopp</th>    
                    </tr>

                </table>
                <form  action="./code/createpdf.php" method="post" enctype="multipart/form-data">
                    <input type="submit" value="Skapa PDF" id="btnPdf" class="btn btn-success" ></input>
                </form>
                
            </div>
        </body>
</html>