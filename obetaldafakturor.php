<?php
      if (!isset($_SESSION)) { session_start(); }
      
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";
      require_once "./code/datum_helper.php";


      $db = new DbManager();
      $dtHelper = new DatumHelper();
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
                    <tbody>
                        <?php 
                            foreach($obetalda as $row){
                                
                                $faktNr = $row["fakturanummer"];
                                $belopp = $row["belopp"];
                                $namn = $row["namn"];
                                $enamn = $row["efternamn"];
                                $lagenhetNr = $row["lagenhet_nr"];
                                $skickad = $dtHelper->GetDatum(($row["skickad"]));
                                $ffdatum = $dtHelper->GetDatum($row["ffdatum"]);

                                echo 
                                "   
                                    <tr>
                                        <td>$faktNr</td>
                                        <td>$namn</td>
                                        <td>$enamn</td>
                                        <td>$belopp</td>
                                        <td>$lagenhetNr</td>
                                        <td>$skickad</td>
                                        <td>$ffdatum</td>

                                    </tr>
                                ";
                            }
                        ?>
                    </tbody>
                </table>

            </div>

            
        </div>
                


    </body>
</html>