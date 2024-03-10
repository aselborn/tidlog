<?php 
 //Information om hyresgäst, kontrakt, nycklar etc.

 if (!isset($_SESSION)) { session_start(); }

    require_once "./code/dbmanager.php";
    require_once "./code/managesession.php";
    require_once "./code/objHyresgast.php";
    require_once "./code/objKontrakt.php";
    
    if (!isset($_GET['hyresgast_id'])) {
        $hyresgastId = null;
    } else {
        $hyresgastId = $_GET['hyresgast_id'];
    }

    $db = new DbManager();
    $parkeringar = $db->query("select * from tidlog_parkering tp2 where tp2.park_id not in (
         select park_id from tidlog_parkering tp where park_id in (select park_id from tidlog_lagenhet tl)) ")->fetchAll();
    
    $hyresGInfo = null;
    if ($hyresgastId != null)
        $hyresGInfo = new InfoHyresgast($hyresgastId);

    $kontraktGInfo = null;
    if ($hyresgastId != null)
        $kontraktGInfo = new InfoKontrakt($hyresgastId);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Hantera befintlig hyresgäst</title>
    </head>
    
    <body>
        <input type="hidden" id="hidlagenhetNo" name="HidLagenhetNo" value="<?php echo $hyresGInfo->lagenhetNo ?>" />
        <input type="hidden" id="hidHyra" name="HidHyra" value="<?php echo $hyresGInfo->hyra ?>" />
        <input type="hidden" id="hidHyresgastId" name="HidHyresgastId" value="<?php echo $hyresGInfo->hyresgastId ?>" />
        <input type="hidden" id="hidKontraktUppsagdDatum" name="HidUppsagdDatum" value="<?php echo $hyresGInfo->datumKontraktUppsagt ?>" />

        <?php include("./pages/sidebar.php") ?>

        <div class="col-sm  min-vh-100 border">
            <h2>Hantera befintlig hyresgäst</h2>
            <hr />
            <div class="container border" >
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
                        </tr>

                    </table>

                </div>
                <div class="row mt-1">
                
                <!--Info om lägenheten-->
                <div class="row mt-3 ">
                    
                    <div class="col-12 ">
                        <!--TABELL SOM ANGER HYRA OCH PARKERING-->
                        <table class="table table-striped w-auto">
                            <thead>
                                <tr >
                                    <th scope="col" class="table-primary">Lägenhet</th>
                                    <th scope="col" class="table-primary">Hyra</th>
                                    <th scope="col" class="table-primary">Ny Hyra</th>
                                    
                                    
                                    <?php 
                                        if ($hyresGInfo->parkering == 0){
                                            echo "<th scope='col' class='table-primary'>Välj parkering</th>";
                                        } else{
                                            echo "<th scope='col' class='table-primary'>Parkering</th>";
                                        }
                                    ?>
                                    <th scope="col" class="table-primary"></th>
                                    <th scope="col" class="table-primary">Moms %</th>
                                    <th scope="col" class="table-primary">Moms belopp</th>
                                    <th scope="col" class="table-primary"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="row-cols-auto ">
                                    <td><?php echo "Nr : ". $hyresGInfo->lagenhetNo ?></td>
                                    <td><?php echo $hyresGInfo->hyra . " kr/mån" ?></td>
                                    <td class="mt-1 border">
                                        <input class="form-control-sm" style="width: 120px;" type="number" id="txtNyHyra" />
                                        <input type="button" id="btnNyHyra" class="btn btn-success" value="Spara">
                                    </td>
                                    
                                    <!-- <td>
                                        <?php if ($hyresGInfo->parkering == 0){
                                            echo '<label class="form-label">Välj parkering: </label>';
                                        }

                                        ?>
                                    </td> -->

                                    <td class="mt-1">
                                        <?php 
                                            if ($hyresGInfo->parkering == 0){
                                                
                                                echo '<select id="cboParkering" class="form-select" name="Parkering">';
                                                foreach($parkeringar as $row)
                                                {
                                                    echo "<option value='" .$row["park_id"] ."'>" .$row["parknr"].  "</option>";
                                                }
                                                echo '</select>';

                                            } else {
                                                echo "<label class='form-label' >" .  $hyresGInfo->parkering . " kr/mån" . " </label>";
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            if ($hyresGInfo->parkering > 0){
                                                echo "<input type='button' id='btnRemovePark' class='btn btn-success ' value='Ta bort'> ";
                                            }
                                        ?>
                                    </td>

                                    <!--Moms?-->
                                    <td>
                                        <input type="number" class="form-control-sm" style="width: 50px;" id="txtmomsProcent" value="<?php echo $hyresGInfo->momsprocent ?>" />
                                    </td>
                                    <td>
                                        <div>
                                            <label class="form-label" id="lblMomsSum"><?php echo $hyresGInfo->moms ?></label>
                                        </div>
                                    </td>
                                    <td>
                                        <input type='button' id='btnSparaMoms' class='btn btn-success ' value='Spara moms'>
                                    </td>

                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="row">Total hyra</th>
                                    <td><strong><?php echo $hyresGInfo->hyra + $hyresGInfo->parkering + $hyresGInfo->moms . " kronor / månad." ?></strong></td>
                                    <td><strong><?php echo 12 *($hyresGInfo->hyra + $hyresGInfo->parkering + $hyresGInfo->moms) . " kronor / år." ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>

                        
                    </div>
                    <!--moms-->
                    <!-- <div class="col-4 ">
                                            
                    </div> -->
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