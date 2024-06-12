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
    $dtInbetald = null;
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
    
      if (isset($_GET["dtInbetald"])){
        $dtInbetald = $_GET["dtInbetald"];
      }
      $data = null;  

      if (isset($_SESSION["faktura_search"]))
      {
        $data = $_SESSION["faktura_search"];

        //echo '<script type="text/javascript">setSearchTableVisible(true);</script>';

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
        <input type="hidden" id="hidInbetaldDatum" name="HidInbetaldDatum" value="<?php  echo $dtInbetald ?>" >

        <!-- <?php include("./pages/sidebar.php") ?> -->

        <div class="main">
            <div class="container-fluid mt-4">
                <h2>Registrera inbetalad hyra</h2>
            <form id="frmInbetalning" method="POST" action="./code/sokfaktura.php">
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
                        <div class="col-auto mt-2">
                            <br />
                            <label id="lblTotSum" class="d-none">total summa : </label>
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
                                            <input type="submit" class="btn btn-outline-success btn rounded-5" name="sok_faktura" value="sök" id="btnSearchInbetalningar"/>
                                        </td>
                                        <td>
                                            <!-- <input type="button" id="btnEndastMarkerade" class="btn btn-outline-success btn rounded-5"  value="visa bara markerade" /> -->
                                            <td><input type="button" id="btnRegistreraInbetalning"  class="btn btn-outline-success  rounded-5 d-none" value="registrera inbetalning"></td>
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
                    <table class="table w-auto " id="tblInbetalning" >
                            <thead>
                                <tr>
                                <th scope="col" class="table-primary"></th>
                                    <th scope="col" class="table-primary">Fakturanummer</th>
                                    <th scope="col" class="table-primary">Fakturerat Belopp</th>
                                    <th scope="col" class="table-primary">Inbetalt belopp</th>
                                    <th scope="col" class="table-primary">Efternamn</th>
                                    <th scope="col" class="table-primary">Lägenhetsnr</th>
                                    
                                    <th scope="col" class="table-primary">Fakturadatum</th> 
                                    <th scope="col" class="table-primary">Förfallodatum</th> 
                                </tr>
                            </thead>
                            <tbody>

                                <?php 
                                
                                    if ($data != null)
                                    {
                                        $rowId = 0;
                                        $sumRadBelopp = 0;
                                        foreach($data as $row )
                                        {
                                            
                                            $dtdat = date_create($row["fakturadatum"]);
                                            $dt = date_format($dtdat, "Y-m-d");
                                            $fakturaId = $row["faktura_id"];
                                            $faktBelopp =  $row["belopp"];
                                            $sumRadBelopp += $faktBelopp;
                                            $dtdat = date_create($row["duedate"]);
                                            $duedate = date_format($dtdat, "Y-m-d");
                                            
                                            echo "
                                            <tr class = 'inp_belopp_binder row_class' belopp=" . $row["belopp"] .  " id = $fakturaId>
                                                <td>
                                                    <input type='checkbox' name='chk_inbetalt' belopp=" . $row["belopp"] ." class='inp_checkbox'> </input>
                                                </td>
                                                <td>"  . $row["fakturanummer"] . "</td>
                                                <td class='text-center'>
                                                    "  . $faktBelopp . "
                                                </td>
                                                <td class='text-center'>
                                                    <span>
                                                        <input name='edited_belopp' type='number' id='row_" . $rowId . "' class='form-control-sm binder_inbetalt_belopp' belopp=0 style='width:80px; text-align:center;' value=" .$faktBelopp . "></input>
                                                    </span>
                                                </td>
                                                <td>"  . $row["namn"] . "</td>
                                                <td>"  . $row["lagenhetNo"] . "</td>
                                                <td>"  . $dt . "</td>
                                                <td>"  . $duedate . "</td>
                                            </tr>
                                            
                                            ";

                                            $rowId++;
                                        }
                                        echo "
                                        <tr>
                                                <td></td>
                                                <td></td>
                                                <td class='text-center'>
                                                    <span>
                                                        <strong> "  . $sumRadBelopp . "</strong>
                                                    </span>
                                                </td>
                                                <td id='sumNyttBelopp' class='text-center binder_nytt_belopp'>
                                                    
                                                </td>
                                            </tr>
                                        ";
                                    }

                                
                                ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="row">Totalt inbetalt belopp</th>
                                    <td>Summa : <strong><label id="lblInbetaldSumma"></label></strong></td>
                                    
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                </form>
            </div>
            


        </div>
    </body>
</html>