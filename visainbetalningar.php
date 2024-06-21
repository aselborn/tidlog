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
                <form method="POST" action="./code/reginbetview.php">
                    <input type="hidden" value="sok_inbetalda" name="sok_inbetalda" />
                    <div class="row mt-2">
                    
                        <div class="d-inline-flex p-1 gap-2">
                            <label for="dtFom">Från</label>
                            <input type="text" class="form-control-sm" id="dtFom" name="dt_fom"></input>
                            <label for="dtTom">Till</label>
                            <input type="text" class="form-control-sm" id="dtTom" name="dt_tom" ></input>
                            <button name="sok_inbetalningar" class="btn btn-outline-success  rounded-5" >Sök inbetalningar</button>
                            <input type="button" id="btnRegistreraInbetalning"  class="btn btn-outline-success  rounded-5 d-none" value="registrera inbetalning">
                        </div>

                    </div>
                </form>
                
            </div>

            
        </div>
                


    </body>
</html>