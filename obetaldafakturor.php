<?php
      if (!isset($_SESSION)) { session_start(); }
      
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";

      $db = new DbManager();
      $obetalda = $db->GetObetaldaFakturor();

      //$obetalda = 

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Obetalda fakturor</title>
    </head>
    <body>
        
        <?php include("./pages/sidebar.php") ?>

        <div class="main">
            <div class="container-fluid mt-4" >
                <br>
                <h2>Obetalda fakturor</h2>
                <!-- <form method="POST" action="./code/reginbetview.php">
                    <input type="hidden" value="sok_inbetalda" name="sok_inbetalda" />
                    <div class="row mt-2">
                    
                        <div class="d-inline-flex p-1 gap-2">
                            <label for="dtFom">Från</label>
                            <input type="text" class="form-control-sm" id="dtFom" name="dt_fom"></input>
                            <label for="dtTom">Till</label>
                            <input type="text" class="form-control-sm" id="dtTom" name="dt_tom" ></input>
                            <button name="sok_inbetalningar" class="btn btn-outline-success  rounded-5" >Sök inbetalningar</button>
                        </div>
                    </div>
                    
                </form> -->
                
                <table class="table table-hover table-striped mt-2" id="tblObetaldaFakturor">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="table-primary">FakturaNummer</th>
                            <th scope="col" class="table-primary">Namn</th>
                            <th scope="col" class="table-primary">Efternamn</th>
                            <th scope="col" class="table-primary">Belopp</th>
                            <th scope="col" class="table-primary">Lägenhet</th>
                            <th scope="col" class="table-primary">Skickad</th>
                            <th scope="col" class="table-primary">Förfallodatum</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>

            
        </div>
                


    </body>
</html>