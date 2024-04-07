<?php
    if (!isset($_SESSION)) { session_start(); }

    require_once "./code/dbmanager.php";
    require_once "./code/managesession.php";
    $db = new DbManager();

    if (isset($_GET['fastighetId']))
    {
      $fastighetId = intval($_GET['fastighetId']);
    }

    if (isset($_GET['hyresgastId'])){
      $hyresgastId = intval($_GET['hyresgastId']);
      $isPostBack = true;
    }

    if (!isset($_GET['page'])) 
    {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    $firstDateInMonth = date("Y-m-01");
    $lastDateInMonth = date('Y-m-t');

    $fastighetNamn = $db->get_fastighet_namn($fastighetId);
    $avimeddelanden = $db->query("select tm.meddelande_id , tm.meddelande , th.fnamn , th.enamn , tm.giltlig_fran , tm.giltlig_till  from tidlog_meddelande tm
	inner join tidlog_hyresgaster th on tm.hyresgast_id  = th.hyresgast_id 
	inner join tidlog_lagenhet tl  on tl.hyresgast_id  =th.hyresgast_id 
	inner join tidlog_fastighet tf on tf.fastighet_id =tl.fastighet_id 
		where tf.fastighet_id = ? order by th.fnamn, th.enamn " , array($fastighetId))->fetchAll();
 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Lägg till meddelande</title>
    </head>
    
    <?php include("./pages/sidebar.php") ?>

    <body>
       
        <div class="main ">
            
            <div class="container-fluid mt-5" >
                
                <hr />    
                <h2>Lägg till ett meddelande till hyresgäster för boendes på <?php echo $fastighetNamn ?></h2>

                <div class="row mt-2">
                    <form action="./code/addmeddelandeavi.php" method="POST" id="frmNyttMeddelande">
                        <input type="hidden" id="hidFastighetId" name="HidFastighetId" value="<?php echo $fastighetId ?>" >
                        <div class="row mt-1">
                            <?php 
                                if (isset($hyresgastId))
                                {
                                    echo 
                                    "
                                        <input type='hidden' name='hidFastighetId' id='HidFastighetId' value='$fastighetId' />
                                    ";
                                            

                                }
                            ?>

                            <div class="col-2">
                                <div class="form-group">
                                    <label id="lblDatum" class="label-primary">Giltlig från</label>
                                    <input id="job_date" type="date" name="giltlig_fran" class="form-control" placeholder="Ange datum" value="<?php echo $firstDateInMonth; ?>" required="required" data-error="Datum måste anges.">
                                    <div class="help-block with-errors"></div>                                
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label id="lblDatum" class="label-primary">Giltlig till</label>
                                    <input id="job_date" type="date" name="giltlig_till" class="form-control" placeholder="Ange datum" value="<?php echo $lastDateInMonth; ?>" required="required" data-error="Datum måste anges.">
                                    <div class="help-block with-errors"></div>                                
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                <br />
                                    <label for="allaHyresgaster" id="lblDatum"  class="label-primary">Alla hyresgäster</label>
                                    <input type="checkbox" value="1" checked id="allaHyresgaster" name="allahyresgaster"/>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="form_message">Meddelande till hyresavi</label>
                                    <textarea id="idMeddelande_hyresgast" name="meddelande_hyresgast" class="form-control" placeholder="Ange meddelande till hyresgäst, som kommer ut på hyresavin" rows="2" required="required" data-error="Vänligen ge en beskrivning till hyresgästen."></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>
                            <div class="col-md-5 mt-4 ">
                                <input type="submit" id="btnSparaAviMeddelande" class="btn btn-primary btn-send" value="Spara">

                            </div>
                        </div>
                    
                    </form>

                </div>

                <!--Om det finns avimeddelanden!-->
                <div class="row mt-4 " id="divArtikel">
                            
                    <div class="col">
                        <table class="table table-sm table-striped tbale-hover" id="tblAvimeddelande">
                            <thead>
                                <tr >
                                    <th scope="col">Meddelande</th>
                                    <th scope="col">hyresgast</th>
                                    <th scope="col">Giltlig från</th>
                                    <th scope="col">Giltlig till</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    foreach($avimeddelanden as $row)
                                    {
                                        $meddelandeId = $row['meddelande_id'];
                                        $meddelande = $row['meddelande'];
                                        $hyresgast = $row['fnamn'] . " " . $row['enamn'];
                                        
                                        $dtdat = date_create($row["giltlig_fran"]);
                                        $fran = date_format($dtdat, "Y-m-d");
    
                                        $dttill = date_create($row["giltlig_till"]);
                                        $till = date_format($dttill, "Y-m-d");

                                        echo 
                                        "
                                            <tr id='$meddelandeId'>
                                            <td>" .$meddelande . "</td>
                                            <td>" .$hyresgast . "</td>
                                            <td>" .$fran . "</td>
                                            <td>" .$till . "</td>
                                            <td> <input type=button class='btn btn-outline-success btn-sm rounded-5 radera_avi_binder' id='btnRaderaAvimeddelande' value=radera meddelande='" . $meddelandeId . "'</input></td>
                                            </tr>
                                        ";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                                

            </div>
            
            
        </div>
    </body>

</html>
