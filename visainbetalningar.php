<?php
      if (!isset($_SESSION)) { session_start(); }
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";



?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Inbetalningar</title>
    </head>
    <body>
        
        <?php include("./pages/sidebar.php") ?>

        <div class="main">
            <div class="container-fluid mt-4" >
                <br>
                <h2>Registrerade inbetalningar</h2>
            </div>

            <div class="row mt-2">
                <div class="col-auto">
                    <div class="d-inline-flex p-1 gap-2">
                        <label for="dtFom">Från</label>
                        <input type="text" class="form-control" id="dtFom" >wh</input>
                    </div> 
                </div>
            </div>
        </div>
                


    </body>
</html>