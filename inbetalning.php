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

        <input type="hidden" id="hidUserName" name="HidUsername" value="<?php echo $_SESSION["username"] ?>">

        <!-- <?php include("./pages/sidebar.php") ?> -->

        <div class="main">
            <div class="container-fluid mt-4">
                <h2>Kontroll av inkommande hyra</h2>

                <div class="row">
                    <div class="d-inline-flex gap-3">
                        <div class="col-auto ">
                            <label class="form-label">Datum inbetalt</label>
                            <input id="bg_date" type="date" name="bg_datum" class="form-control" style="width: 180px;" value="<?php echo date("Y-m-d"); ?>"
                                placeholder="Ange datum" required="required" data-error="Datum måste anges.">
                        </div>

                        <div class="col-auto ">
                            <label class="form-label">Totalt belopp</label>
                            <input id="txt_belopp" type="number" name="inbetalt_belopp"  style="width:150px" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="d-inline-flex">
                    
                        <table class="table table table-striped w-auto" id="tblInbetalning" >
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
                                        <input id="idFakturaId" type="text" name="Faktura" />
                                    </td>
                                    <td>
                                        <input id="idBelopp" type="text" name="Belopp" />
                                    </td>
                                    <td>
                                        <input id="idEfternamn" type="text" name="Efternamn" />
                                    </td>
                                    <td>
                                        <input id="idLagenhet" type="text" name="Lagenhet" />
                                    </td>
                                    
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            


        </div>
    </body>
</html>