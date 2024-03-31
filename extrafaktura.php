<?php
    if (!isset($_SESSION)) { session_start(); }

    require_once "./code/dbmanager.php";
    require_once "./code/managesession.php";
    $db = new DbManager();

    if (isset($_GET['fastighetId']))
      {
        $isPostBack = true;
        $fastighetId = intval($_GET['fastighetId']);
      }
      if (!isset($_GET['page'])) 
      {
          $page = 1;
      } else {
          $page = $_GET['page'];
      }

    $fastighetNamn = $db->get_fastighet_namn($fastighetId);
    $items = $db->query(
        "
            select * from tidlog_item order by artikel
        ")->fetchAll();

    $hyresgaster = $db->query(
    "
    select * from tidlog_hyresgaster hr 
    inner join tidlog_lagenhet tl on tl.hyresgast_id = hr.hyresgast_id 
    where tl.fastighet_id = ?
    order by adress, fnamn, enamn
    ", array($fastighetId))->fetchAll();

   
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Extra faktura till hyresgäst</title>
    </head>
    
    <?php include("./pages/sidebar.php") ?>

    <body>
    <div class="main ">
            
            <div class="container-fluid mt-5" >
                
                <hr />    
                <h2>Lägg till artikel till hyresgäst för boendes på <?php echo $fastighetNamn ?></h2>

                <div class="row mt-2">
                    
                    <form action="./code/addartikeltillavi.php" method="POST" id="frmNyArtikal" onSubmit="window.location.reload()">
                        <div class="row mt-1">

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label id="lblDatum" class="label-primary">Giltlig från</label>
                                    <input id="job_date" type="date" name="giltlig_fran" class="form-control" placeholder="Ange datum" value="<?php echo date('Y-m-d'); ?>" required="required" data-error="Datum måste anges.">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label id="lblDatum" class="label-primary">Giltlig till</label>
                                    <input id="job_date" type="date" name="giltlig_till" class="form-control" placeholder="Ange datum" value="<?php echo date('Y-m-d'); ?>" required="required" data-error="Datum måste anges.">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label id="lblItem" class="label-primary">Välj artikel</label>
                                    <select id="itemId" class="form-select" name="items">
                                    <!-- <option value="0">Välj artikel</option> -->
                                    <?php 

                                        foreach($items as $row)
                                        {
                                            echo "<option value='" .$row["item_id"] ."'>" .$row["artikel"].  "</option>";
                                        }

                                    ?>
                                    </select>
                                </div>
                            </div>
                            
                        </div>

                        <!-- <div class="row mt-4">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input type="checkbox" value="0" name="chkAllaHyresgaster" />
                                    <label for="chkAllaHyresgaster">Alla hyresgäster?</label>
                                </div>
                            </div>
                        </div> -->

                        <div class="row mt-4">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label id="lblHyresgaster" class="label-primary">Välj hyresgäst</label>
                                    <select id="selectHyresgast" class="form-select" name="hyresgast">
                                    <option value="0">Välj</option>
                                    <?php 
                                    
                                    foreach($hyresgaster as $row)
                                    {
                                        echo "<option value='" .$row["hyresgast_id"] ."'>" .$row["fnamn"] . " " . $row["enamn"] . " " . $row["adress"] .  "</option>";
                                    }

                                    ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label id="lblPris" class="label-primary">Pris</label>
                                    <br />
                                    <input type="number" class="form-control" name="pris" style="width: 120px;" />
                                </div>
                            </div>

                        </div>
                        
                        

                        <!--Om det finns en artikel.-->
                        <div class="row mt-4 d-none" id="divArtikel">
                            <table class="table table-sm table-striped" id="tblExtraFaktura">
                                <th scope="col">Artikel</th>
                                <th scope="col">Pris</th>
                                <th scope="col">Giltlig från</th>
                                <th scope="col">Giltlig till</th>
                                <th scope="col">Meddelande</th>
                                <th scope="col"></th>

                                <tbody>

                                </tbody>
                            </table>

                        </div>

                        <!--Ny-->

                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="form_message">Meddelande till hyresavi</label>
                                    <textarea id="idMeddelande_hyresgast" name="meddelande_hyresgast" class="form-control" placeholder="Ange meddelande till hyresgäst" rows="3" required="required" data-error="Vänligen ge en beskrivning till hyresgästen."></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>
                            <div class="col-md-5 mt-4 ">
                                <input type="submit" id="btnSparaExtraFaktura" class="btn btn-primary btn-send" value="Spara">

                            </div>
                            <div class="col-md-3 mt-4 ">
                                <label id="lblMissingData" class="text-danger form-label invisible">Data saknas, kan inte spara.</label>
                            </div>
                     
                        </div>
                    </form>

                    
                </div>

            </div>
    </body>
</html>