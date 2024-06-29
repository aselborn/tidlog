<?php
      if (!isset($_SESSION)) { session_start(); }
      
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";
      require_once "./code/datum_helper.php";


      $db = new DbManager();
      $dtHelper = new DatumHelper();
      $felaktiga = $db->GetDiffBeloppFakturor();

      //$obetalda = 

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Felaktiga fakturor</title>
    </head>
    <body>
        
        <?php include("./pages/sidebar.php") ?>

        <div class="main">
            <div class="container-fluid mt-4" >
                <br>
                <h2>Felaktiga fakturor</h2>
                <!-- <form method="POST" action="./code/reginbetview.php">
                    <input type="hidden" value="sok_inbetalda" name="sok_inbetalda" />
                    <div class="row mt-2">
                    
                        <div class="d-inline-flex p-1 gap-2">
                            <label for="dtFom">Från</label>
                            <input type="text" class="form-control-sm" id="dtFom" name="dt_fom"></input>
                            <label for="dtTom">Till</label>
                            <input type="text" class="form-control-sm" id="dtTom" name="dt_tom" ></input>
                            <button name="sok_inbetalningar" class="btn btn-outline-success  rounded-5" >Sök fakturor</button>
                        </div>
                    </div>
                    
                </form> -->
                
                <table class="table table-hover table-striped mt-3" id="tblObetaldaFakturor">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="table-primary">FakturaNummer</th>
                            <th scope="col" class="table-primary">Fastighet</th>
                            <th scope="col" class="table-primary">Namn</th>
                            <th scope="col" class="table-primary">Efternamn</th>
                            <th scope="col" class="table-primary">Belopp</th>
                            <th scope="col" class="table-primary">Bet.Belopp</th>
                            <th scope="col" class="table-primary">Diff</th>
                            <th scope="col" class="table-primary">Dagar</th>
                            <th scope="col" class="table-primary">Lägenhet</th>
                            <th scope="col" class="table-primary">Inbetald</th>
                            <th scope="col" class="table-primary">Förfallodatum</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 

                            foreach($felaktiga as $row)
                            {
                                $fakturanummer = $row['fakturanummer'];
                                $fastighet = $row["fastighet_namn"];
                                $namn  =$row["fnamn"];
                                $enamn  =$row["enamn"];
                                $belopp = $row["belopp"];
                                $inbet = $belopp + ($row["diff_belopp"]);
                                $diff = $row["diff_belopp"];
                                $dagar = $row["diff_datum_days"];
                                $lagenhet = $row["lagenhet_nr"];
                                $inbetald = $dtHelper->GetDatum(($row["inbetald"]));
                                $duedate = $dtHelper->GetDatum(($row["ffdatum"]));
                                
                                echo 
                                "
                                    <tr>
                                        <td>$fakturanummer</td>
                                        <td>$fastighet</td>
                                        <td>$namn</td>
                                        <td>$enamn</td>
                                        <td>$belopp</td>
                                        <td>$inbet</td>
                                        <td>$diff</td>
                                        <td>$dagar</td>
                                        <td>$lagenhet</td>
                                        <td>$inbetald</td>
                                        <td>$duedate</td>
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