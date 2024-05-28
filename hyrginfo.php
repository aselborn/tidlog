<?php 
 //Information om hyresgäst, kontrakt, nycklar etc.

 if (!isset($_SESSION)) { session_start(); }

    require_once "./code/dbmanager.php";
    require_once "./code/managesession.php";
    require_once "./code/objHyresgast.php";
    require_once "./code/objKontrakt.php";
    require_once "./code/objDepositon.php";
    require_once "./code/datum_helper.php";
    
    if (!isset($_GET['hyresgast_id'])) {
        $hyresgastId = null;
    } else {
        $hyresgastId = $_GET['hyresgast_id'];
    }

    $db = new DbManager();
    $datumHelper = new DatumHelper();
   
    $hyresGInfo = new InfoHyresgast($hyresgastId);
    
    $kontraktGInfo = null;
    $depositionInfo = null;

    if ($hyresgastId != null) {
        $kontraktGInfo = new InfoKontrakt($hyresgastId);
        $depositionInfo = new InfoDeposition($hyresgastId);
    }
        

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Hantera befintlig hyresgäst</title>
    </head>
    
    <body>
        <input type="hidden" id="hidlagenhetNo" name="HidLagenhetNo" value="<?php echo $hyresGInfo->lagenhetNo ?>" />
        <input type="hidden" id="hidlagenhetId" name="HidLagenhetId" value="<?php echo $hyresGInfo->lagenhetId ?>" />
        <input type="hidden" id="hidHyra" name="HidHyra" value="<?php echo $hyresGInfo->hyra ?>" />
        <input type="hidden" id="hidHyresgastId" name="HidHyresgastId" value="<?php echo $hyresGInfo->hyresgastId ?>" />
        <input type="hidden" id="hidFskatt" name="HidFskatt" value="<?php echo $hyresGInfo->fskatt ?>" />
        <input type="hidden" id="hidKontraktUppsagdDatum" name="HidUppsagdDatum" value="<?php echo $hyresGInfo->datumKontraktUppsagt ?>" />

        <?php include("./pages/sidebar.php") ?>
            
            <div class="main">
                <div class="container-fluid mt-4" >
                <br/>
                <!-- <h3>Hantera befintlig hyresgäst i lägenhet, <?php echo $hyresGInfo->lagenhetNo ?></h3> -->
                <hr />
                <span><h2>Kontraktbunden hyresgäst <?php echo $hyresGInfo->lagenhetNo ?></h2></span>
                <div class="d-inline-flex">
                    
                    <table class="table table table-striped w-auto" id="tblHyresgast" >
                    
                        <thead>
                            <tr>
                                <th scope="col" class="table-primary">Förnamn</th>
                                <th scope="col" class="table-primary">Efternamn</th>
                                <th scope="col" class="table-primary">Adress</th>
                                <th scope="col" class="table-primary">Epost</th>
                                <th scope="col" class="table-primary">Telefon</th>
                                <th scope="col" class="table-primary">Andrahand?</th>
                                <th scope="col" class="table-primary"></th> 
                            </tr>
                        </thead>
                        
                        <tr>
                            <td>
                                <input id="fnamn" type="text" name="fnamn" class="" value="<?php echo $hyresGInfo->fnamn ?>" />
                            </td>
                            <td>
                                <input id="enamn" type="text" name="enamn"  value="<?php echo $hyresGInfo->enamn ?>" />
                            </td>
                            <td>
                                <input id="adress" type="text" name="adress" style="width: 50px;" value="<?php echo $hyresGInfo->adress ?>" />
                            </td>
                            <td>
                                <input id="epost" type="text" name="epost"  value="<?php echo $hyresGInfo->epost ?>" style="width:250px" />
                            </td>
                            <td>
                                <input id="telefon" type="text"  value="<?php echo $hyresGInfo->telefon ?>" name="telefon" />
                            </td>
                            <td>
                                <!-- <input type="checkbox" name="chkAndraHand" id="chkAndraHand" value="<?php echo $hyresGInfo->andrahand ?>" checked  /> -->
                                <?php 
                                    if ($hyresGInfo->andrahand == 1){
                                        echo '<input type="checkbox" name="chkAndraHand" id="chkAndraHand" checked value=1 />';
                                    } else{
                                        echo '<input type="checkbox" name="chkAndraHand" id="chkAndraHand" value=0 />';
                                    }
                                ?>
                                
                            </td>
                            <td>
                                <input type="button" name="uppdateraHyresgast" id="btnUppdateraHyresgast" value="Uppdatera"class="btn btn-success" />
                            </td>
                            <td>
                               <input type="button" name="sag_up_hyresgast" id="btnSagUppHyresgast"  value="Säg upp"class="btn btn-warning alert_me" />
                               
                            </td>
                        </tr>

                    </table>

                </div>
                <div class="row mt-1">
                
                <!--Info om Hyresgästen-->
                
                <!--Deposition?-->
                <div class="row mt-2">
                    <div class="col-12">
                                
                            <table class="table table-striped w-auto" id="tblKontrakt" name="depositonTabell">
                                    <thead>
                                        <tr >
                                        <th scope="col" class="table-primary">Belopp</th>
                                            <th scope="col" class="table-primary">Datum </th>
                                            <th scope="col" class="table-primary">Belopp åter</th>
                                            <th scope="col" class="table-primary">Datum åter</th>
                                            <th scope="col" class="table-primary"></th>
                                            <th scope="col" class="table-primary"></th>
                                        </tr>
                                    </thead>
                            <form action="./code/deposition.php" method="POST" id="frmDeposition">
                                <tbody>
                                        
                                    <input type="hidden" value=<?php echo $hyresGInfo->hyresgastId ?> name="hdHyresgast"/>
                                        <input type="hidden" value=<?php echo $hyresGInfo->lagenhetId ?> name="hdLagenhetId"/>
                                        <input type="hidden" value=<?php echo $hyresGInfo->lagenhetNo ?> name="hdLagenhetNo"/>
                                        
                                    <?php 
                                        
                                        if ($depositionInfo->belopp == null) //NY Deposition
                                        { ?>
                                            
                                            <tr>
                                            <td><input type="number" style="width: 100px;" required class="form-control-sm" name="deposition_belopp"></td>
                                            <td><input type="date"  style="width: 120px;" required class="form-control-sm" name="deposition_datum" value="<?php echo date('Y-m-d') ?>"></td>
                                            <!-- <td><input type="number" style="width: 100px;" class="form-control-sm" name="deposition_ater_belopp"></td>
                                            <td><input type="date"  style="width: 120px;" class="form-control-sm" required name="deposition_ater_datum" value="<?php echo null ?>"></td> -->
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <input type="submit" id="btnSparadeposition"value="Spara ny deposition" name="spara_deposition" class="btn btn-outline-success btn-sm rounded-5" />
                                            </td>
                                        </tr>
                                        <?php } else { // befintligt depositioN ?>
                                            <tr>
                                                <td><input type="number" style="width: 100px;"  class="form-control-sm "  disabled value="<?php  echo $depositionInfo->belopp  ?>" name="deposition_belopp"></td>
                                                <td><input type="date"  style="width: 120px;" disabled class="form-control-sm" name="deposition_datum" value="<?php echo $datumHelper->GetDatum($depositionInfo->datum_deposition) ?>"></td>
                                                <td><input type="number" style="width: 100px;" class="form-control-sm" name="deposition_ater_belopp" value="<?php echo $depositionInfo->belopp_ater ?>"></td>
                                                <td><input type="date"  style="width: 120px;" class="form-control-sm" name="deposition_ater_datum" value="<?php echo $datumHelper->GetDatum($depositionInfo->datum_ater) == "" ? date('Y-m-d') : $datumHelper->GetDatum($depositionInfo->datum_ater) ?>"></td>
                                                <td>
                                                    <input type="submit" id="btnUpdatera"value="Uppdatera deposition" name="uppdatera_deposition" class="btn btn-outline-success btn-sm rounded-5" />
                                                </td>
                                            </tr>
                                        <?php 
                                            } 
                                        ?>

                                    
                                    
                                   
                                    <!--Raden för att lägga till en deposition.-->
                                <!-- <form action="./code/deposition.php" method="POST" id="frmDeposition">
                                    <tr class="row-cols-auto d-none row_deposition" id="rowNyDeposition">
                                        <td><input type="number" class="form-control-sm" id="idDepositionBelopp" name="DepositionBelopp" style="width: 110px;"/></td>
                                        <td><input type="date" class="form-control-sm" id="dtDepositionDatum" value="<?php  echo date("Y-m-d")  ?>" name="DepositionDatum" /></td>
                                        <td><input type="date" class="form-control-sm d-none" id="dtDepositionDatumAter" name="DepositionDatumAter" /></td>
                                        <td><input type="number" class="form-control-sm d-none" id="idBeloppAter" name="BeloppAter" /></td>

                                        <input type="hidden" value=<?php echo $hyresGInfo->hyresgastId ?> name="hdHyresgast"/>
                                        <input type="hidden" value=<?php echo $hyresGInfo->lagenhetId ?> name="hdLagenhetId"/>
                                        <input type="hidden" value=<?php echo $hyresGInfo->lagenhetNo ?> name="hdLagenhetNo"/>
                                        
                                        <td>
                                            <input type="submit" id="btnSparadeposition"value="Spara ny deposition" name="sparakontrakt" class="btn btn-outline-success btn-sm rounded-5" />
                                        </td>
                                    </tr>
                                </form> -->

                                </tbody>
                            </form> 
                            </table>
                            <!-- <?php 
                                if ($depositionInfo->belopp == null ){
                                    echo "<input type ='button' id='btnNyDeposition' class='btn btn-outline-success btn-sm rounded-5' name=ny_deposition value='Ny deposition' />";
                                }
                            ?> -->
                        
                        <!--Visas endast om deposition inte finns sparat!-->
                    </div>
                </div>

                <!--Kontraktdetaljer-->
                <div class="row mt-2">
                    <!--UPPGIFTER OM KONTRAKT-->
                    <div class="col-12">
                    <table class="table table-striped w-auto" id="tblKontrakt">
                            <thead>
                                <tr >
                                    <th scope="col" class="table-primary">Kontrakt</th>
                                    <th scope="col" class="table-primary">Datum skapat</th>
                                    <th scope="col" class="table-primary">Datum uppsagt</th>
                                    <th scope="col" class="table-primary">Scannat dokument</th>
                                    <th scope="col" class="table-primary"></th>
                                    <th scope="col" class="table-primary"></th>
                                </tr>
                            </thead>

                            <!--Sparade kontrakt-->
                            <?php 
                                if ($kontraktGInfo->kontraktId != null){
                                    
                                    foreach ($kontraktGInfo as $row) {

                                    $lnkPdf = "/bilder/pdf.png";
                                    
                                        echo "
                                            <tr class='row-cols-auto'>
                                                <td><label class='form-control-sm'>" . $kontraktGInfo->kontraktNamn . " </label></td>
                                                <td><label class='form-control-sm'>" . $kontraktGInfo->datumKontrakt . " </label></td>
                                                <td><input type='date' class='form-control-sm'  id='dtDateBackKontrakt' name='dtTom'  /></td>
                                                
                                                <td>
                                                    <a href='visakontrakt.php?kontraktId=" . $kontraktGInfo->kontraktId . "'>
                                                    <div style='height:100%;width:100%'>
                                                        <img src= .$lnkPdf . ></a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <td>
                                                        <input type='button' id='btnContractNoValid' value='Säg upp' class='btn btn-danger' />
                                                    </td>
                                                </td>
                                            </tr>
                                            
                                        ";
                                    }
                                }
                                //if ($hyresGInfo->datumKontrakt != null){
                                   
                                    
                                //}
                            ?>
                          
                            <!--Raden för att lägga till ett kontrakt.-->
                            <form  action="./code/uploadkontrakt.php" method="post" enctype="multipart/form-data">
                                <tr class="row-cols-auto d-none" id="rowNyttKontrakt">
                                    <td><input type="text" class="form-control-sm" id="idKontraktNamn" name="kontraktNamn" /></td>
                                    <td><input type="date" class="form-control-sm" id="dtDateGoneKontrakt" name="dtFom" /></td>
                                    <td><input type="date" class="form-control-sm d-none" id="txtDateBackKontrakt" name="dtTom" /></td>
                                    <input type="hidden" value=<?php echo $hyresGInfo->hyresgastId ?> name="hdHyresgast"/>
                                    <input type="hidden" value=<?php echo $hyresGInfo->lagenhetId ?> name="hdLagenhetId"/>
                                    <input type="hidden" value=<?php echo $hyresGInfo->lagenhetNo ?> name="hdLagenhetNo"/>
                                    <td>
                                        <label class=""file-upload>
                                            <input type="file" name="pdfkontrakt" id="file_kontrakt" accept="application/pdf" id="btnAddKontraktBlob"value="ladda..." class="btn btn-info" />
                                        </label>
                                        
                                    </td>
                                    <td><input type="submit" id="btnSparaKontrakt"value="Spara" name="sparakontrakt" class="btn btn-success" /></td>
                                </tr>
                            </form>
                        <table>
                        <!--Visas endast om kontrakt inte finns sparat!-->
                        <?php 
                            if ($hyresGInfo->datumKontrakt == null || $hyresGInfo->datumKontraktUppsagt != null){
                                echo '<input type="button" id="btnAddKontraktDokument"value="Nytt" class="btn btn-success" />';
                            }
                        ?>
                        
                    </div>
                </div>

                <!--Nyckekvitton.-->
                <div class="row mt-2">
                    <div class="col-4 ">
                        <label class="form-label">Nyckelkvitton: </label>
                        
                        <label class="form-label"><strong><?php echo $hyresGInfo->datumNyckelKvitto ?></strong></label>
                    </div>
                    
                    <!--UPPGIFTER OM KONTRAKT-->
                    <div class="col-8">
                        <!--TABELL OM NYCKELKBVITTON-->
                    <table class="table table-striped w-auto" id="tblNyckelDokument">
                            <thead>
                                <tr >
                                    <th scope="col" class="table-primary">Nyckel namn</th>
                                    <th scope="col" class="table-primary">Datum uthyrd</th>
                                    <th scope="col" class="table-primary">Datum åter</th>
                                    <th scope="col" class="table-primary">Scannat dokument</th>
                                </tr>
                            </thead>
                            <!--Raden för att lägga till en nyckel.-->
                            <form  action="./code/upload.php" method="post" enctype="multipart/form-data">
                            <tr class="row-cols-auto d-none" id="rowNyNyckel">
                                <td><input type="text" class="form-control-sm" id="txtNyckelNamn" /></td>
                                <td><input type="date" class="form-control-sm" id="dtDateGone" /></td>
                                <td><input type="date" class="form-control-sm d-none" id="txtDateBack" /></td>
                                <td>
                                    <label class=""file-upload>
                                        <input type="file" name="pdf" id="fileData" accept="application/pdf" id="btnAddNyckelBlob"value="ladda..." class="btn btn-info" />
                                    </label>
                                    
                                </td>
                                <td><input type="button" id="btnSparaDockument"value="Spara" class="btn btn-success" /></td>
                            </tr>
                            </form>
                        <table>
                        <input type="button" id="btnAddNyckelDokument"value="Nytt" class="btn btn-success" />
                    </div>
                </div>

            </div>
        </div>

    </body>
</html>