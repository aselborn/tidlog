<?php
      if (!isset($_SESSION)) { session_start(); }
      
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";
      require_once "./code/datum_helper.php";

      $isPostBack = false;
      $fakturanummer="";

      if (isset($_GET['fakturanr'])){
        $isPostBack=true;
        $fakturanummer = $_GET["fakturanr"] == null ? "" : $_GET['fakturanr'];
        $fakturanummer = trim($fakturanummer);
      }
      
      if (isset($_GET['faktid'])){
        $isPostBack=true;
      }

      if (!$isPostBack){
        unset($_SESSION["extra_faktura"]);
        $extra_faktura = null;
      }
        
      $extra_faktura = null;
      if (isset($_SESSION["extra_faktura"])){
        $extra_faktura = $_SESSION["extra_faktura"];
      }

      $db = new DbManager();
      $dtHelper = new DatumHelper();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Registrera extra inbetalning</title>
    </head>
    <body>
        
        <?php include("./pages/sidebar.php") ?>

        <div class="main">
            <div class="container-fluid mt-4" >
                <br>
                <h2>Registrera en extra inbetalning till befintlig faktura</h2>
                <form method="POST" action="./code/reginbetview.php?sokfaktura=true">
                    <input type="hidden" value="sok_inbetalda" name="sok_inbetalda" />

                    

                    <div class="row mt-2">
                    
                        <div class="d-inline-flex p-1 gap-2">
                            <label for="dtFom">Sök fakturanummer:</label>
                            <input type="text" class="form-control-sm" id="dtFakturaNr" name="faktura_nummer" required value="<?php echo trim($fakturanummer); ?> "></input>
                            <button name="sok_inbetalningar" class="btn btn-outline-success  rounded-5" >Sök faktura</button>
                        </div>
                    </div>
                    
                </form>
               <br />
               <?php 
                if ($extra_faktura == null && $isPostBack){
                    echo "<h2>Tabellen är tom.</h2>";
                    return;
                }  if ($extra_faktura == null && !$isPostBack){
                    return;
                }
               ?>
               <form method="POST" action="./code/registreraextrabetalning.php">
                    <table id='extraInbetTable' class='table table-striped table-sm'>
                            <thead class="table-dark">
                                <tr>
                                    <th scope='col' class='table-primary'>Inbetald</th>
                                    <th scope='col' class='table-primary'>Förnamn</th>
                                    <th scope='col' class='table-primary'>Efternamn</th>
                                    <th scope='col' class='table-primary'>Fakturanummer</th>
                                    <th scope='col' class='table-primary'>Belopp (kr)</th>
                                    <th scope='col' class='table-primary'>Diff (kr)</th>
                                    <th scope='col' class='table-primary'>Lägenhetsnr</th>                                        
                                </tr>
                        </thead>
                        <tbody>
                            <?php 
                                if ($extra_faktura != null){
                                    $loop = 0;
                                    foreach($extra_faktura as $row)
                                    {
                                        
                                        $inbetald = $dtHelper->GetDatum(($row["inbetald"]));
                                        $fnamn = $row["fnamn"];
                                        $enamn = $row["enamn"];
                                        $faktnr = $row["fakturanummer"];
                                        $belopp = $row["belopp"];
                                        $diff_belopp = $row["diff_belopp"];
                                        $lagenhetNr = $row["lagenhet_nr"];
                                        $fakturaId = $row["faktura_id"];

                                        if ($loop > 0){
                                            $inbetald =  $dtHelper->GetDatum(($row["extradatum"]));
                                            $belopp = $row["extrabelopp"];
                                            $diff_belopp = $next_diffbelopp + ($belopp);
                                        }

                                        echo 
                                        "
                                            <tr>
                                                <td>$inbetald</td>
                                                <td>$fnamn</td>
                                                <td>$enamn</td>
                                                <td>$faktnr</td>
                                                <td>$belopp</td>
                                                <td>$diff_belopp</td>
                                                <td>$lagenhetNr</td>
                                                <input type='hidden' value='$fakturaId' name='faktura_id_name' />
                                            </tr>
                                        ";

                                        if ($loop == 0 && $row["extrabelopp"] != null ){
                                            $inbetald =  $dtHelper->GetDatum(($row["extradatum"]));
                                            $belopp = $row["extrabelopp"];
                                            $diff_belopp = $diff_belopp + ($belopp);
                                            $next_diffbelopp = $diff_belopp;
                                            echo 
                                            "
                                                <tr>
                                                    <td>$inbetald</td>
                                                    <td>$fnamn</td>
                                                    <td>$enamn</td>
                                                    <td>$faktnr</td>
                                                    <td>$belopp</td>
                                                    <td>$diff_belopp</td>
                                                    <td>$lagenhetNr</td>
                                                    <input type='hidden' value='$fakturaId' name='faktura_id_name' />
                                                </tr>
                                            ";  
                                        }
                                        $loop++;
                                    }
                                }
                            ?>
                            </tbody>
                        </table>

                    
                        <div class="row d-flex mt-4">
                            <div class="col-3">
                                <label class="form-label p-2">Inbetalt belopp</label>
                                <input type="number" style="width: 130px;" id="nyttFakturaBelopp" required name ="nytt_faktura_belopp" class="form-control-sm"/>
                            </div>
                        </div>

                        <div class="row d-flex ">
                            <div class="col-4" >
                                <label class="form-label p-2">Inbetald Datum</label>
                                <input type="date" style="width: 130px;" id="idNewInbetalning" value="<?php echo  date("Y-m-d");?>" name="datum_ny_inbetalning"class="form-control-sm" />
                                <input type="submit"  class="btn btn-outline-success rounded-5 " name="reg_nytt_belopp" value="Registrera ny inbetalning"/>
                            </div>
                        </div>
                </form>

            </div>

            
        </div>
                


    </body>
</html>