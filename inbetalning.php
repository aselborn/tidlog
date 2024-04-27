<?php
      if (!isset($_SESSION)) { session_start(); }
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";

    $isPostBack = false;
    $fakturaNummer = "";
    $totalBelopp = null;
    $belopp = null;
    $lagenhetNo = null;
    $efternamn = null;

      if (isset($_GET["fakturanummer"])){
        $fakturaNummer = $_GET["fakturanummer"];
        $isPostBack = true;
      }
      if (isset($_GET["totalbelopp"])){
        $totalBelopp = $_GET["totalbelopp"];
      }
      if (isset($_GET["belopp"])){
        $belopp = $_GET["belopp"];
      }
      if (isset($_GET["lagenhetNo"])){
        $lagenhetNo = $_GET["lagenhetNo"];
      }
      if (isset($_GET["namn"])){
        $efternamn = $_GET["namn"];
      }  
        
      $data = null;  

      if (isset($_SESSION["faktura_search"]))
      {
        $data = $_SESSION["faktura_search"];
      }
      
      if (!$isPostBack){
        unset($_SESSION["faktura_search"]);
        $data = null;
      }
        

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Inbetalningar</title>
    </head>

    <body>

        <input type="hidden" id="hidUserName" name="HidUsername" value="<?php echo $_SESSION["username"] ?>">

        <!-- <?php include("./pages/sidebar.php") ?> -->

        <div class="main">
            <div class="container-fluid mt-4">
                <h2>Kontroll av inkommande hyra</h2>
            <form method="POST" action="./code/sokfaktura.php">
                <div class="row">
                    <div class="d-inline-flex gap-3">
                        <div class="col-auto ">
                            <label class="form-label">Datum inbetalt</label>
                            <input id="bg_date" type="date" name="bg_datum" class="form-control" style="width: 180px;" value="<?php echo date("Y-m-d"); ?>"
                                placeholder="Ange datum" required="required" data-error="Datum måste anges.">
                        </div>

                        <div class="col-auto ">
                            <label class="form-label">Totalt belopp</label>
                            <input id="txt_belopp" type="number" name="inbetalt_belopp" value="<?php echo $totalBelopp ?>"  style="width:150px; text-align:center" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="d-inline-flex">
                    
                        
                            <table class="table table table-striped w-auto" id="tblSearchInbetalning" >
                                <thead>
                                    <tr>
                                        <th scope="col" class="table-primary">Fakturanummer</th>
                                        <th scope="col" class="table-primary">Belopp</th>
                                        <th scope="col" class="table-primary">Efternamn</th>
                                        <th scope="col" class="table-primary">Lägenhetsnr</th>
                                        
                                        <th scope="col" class="table-primary"></th> 
                                    </tr>
                                    <tr>
                                        <td>
                                            <input id="idFakturaId" type="text" name="faktura_nummer" value="<?php echo $fakturaNummer; ?>" required data-error="ange del av fakturanr"/>
                                            
                                        </td>
                                        <td>
                                            <input id="idBelopp" type="number" style="width: 100px; text-align:center" value="<?php echo $belopp ?>" name="belopp" />
                                        </td>
                                        <td>
                                            <input id="idEfternamn" type="text" name="efternamn" value="<?php echo $efternamn ?>" />
                                        </td>
                                        <td>
                                            <input id="idLagenhet" type="number" style="width: 100px; text-align:center" name="lagenhet" value="<?php echo $lagenhetNo ?>" />
                                        </td>
                                        <td>
                                            <input type="submit" class="btn btn-outline-success btn rounded-5" name="sok_faktura" value="sök" />
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        
                        
                    </div>
                </div>

                <!--Plock tabell-->
                <div class="row mt-3">
                    <div class="d-inline-flex">
                    <table class="table table table-striped w-auto" id="tblInbetalning" >
                            <thead>
                                <tr>
                                    <th scope="col" class="table-primary">Fakturanummer</th>
                                    <th scope="col" class="table-primary">Belopp</th>
                                    <th scope="col" class="table-primary">Efternamn</th>
                                    <th scope="col" class="table-primary">Lägenhetsnr</th>
                                    
                                    <th scope="col" class="table-primary">Fakturadatum</th> 
                                </tr>
                            </thead>
                            <tbody>

                                <?php 
                                    if ($data != null)
                                    {
                                        foreach($data as $row )
                                        {
                                            $dtdat = date_create($row["fakturadatum"]);
                                            $dt = date_format($dtdat, "Y-m-d");
                                            echo "
                                            <tr>
                                                <td>"  . $row["fakturanummer"] . "</td>
                                                <td>"  . $row["belopp"] . "</td>
                                                <td>"  . $row["namn"] . "</td>
                                                <td>"  . $row["lagenhetNo"] . "</td>
                                                <td>"  . $dt . "</td>
                                            </tr>
                                            ";
                                        }
                                    }
                                
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                </form>
            </div>
            


        </div>
    </body>
</html>