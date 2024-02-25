<?php 
 //Information om hyresgäst, kontrakt, nycklar etc.

 if (!isset($_SESSION)) { session_start(); }

    require_once "./code/dbmanager.php";
    require_once "./code/managesession.php";
    require_once "./code/objHyresgast.php";
    
    if (!isset($_GET['hyresgast_id'])) {
        $hyresgastId = null;
    } else {
        $hyresgastId = $_GET['hyresgast_id'];
    }

    $db = new DbManager();
    $parkeringar = $db->query("select * from tidlog_parkering tp2 where tp2.park_id not in (
         select park_id from tidlog_parkering tp where park_id in (select park_id from tidlog_lagenhet tl)) ")->fetchAll();

    
    $hyresGInfo = new InfoHyresgast($hyresgastId);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Hyresgäst</title>
    </head>
    
    <body>
        <!-- <input type="hidden" id="hidlagenhetNo" name="HidLagenhetNo" value="<?php echo $lagenhetNo ?>" > -->
        <?php include("./pages/sidebar.php") ?>

        <div class="col-sm  min-vh-100 border">
            <h2>Hyresgäst</h2>
            <hr />
            <div class="container border" >
                <div class="d-inline-flex">
                    <h3><strong>Information om hyresgäst <?php echo $hyresGInfo->fnamn . " " . $hyresGInfo->enamn ?></strong></h3>
                </div>
                <div class="row mt-1">
                <div class="d-inline-flex align-bottom p-1 gap-2">
                            
                            <div class="form-group">
                                <label id="lblFnamn" class="label-primary">Förnamn</label>
                                <input id="fnamn" type="text" name="fnamn" class="form-control" style="width:200px">
                                <div class="invalid-feedback">
                                    Vänligen ange ett namn
                                </div>
                            </div>

                            <div class="form-group">
                                <label id="lblEnamn" class="label-primary">Efternamn</label>
                                <input id="enamn" type="text" name="enamn" class="form-control" style="width:200px" >
                            </div>

                            <!-- <div class="form-group">
                                <label id="lblLagenhetNo" class="label-primary" >Lägenhet Nr</label>
                                
                                <select id="lagenhetId" class="form-select" name="lagenhet" style="width:130px">
                                    <?php 

                                        foreach($lagenheter as $row)
                                        {
                                            echo "<option value='" .$row["lagenhet_id"] ."'>" .$row["lagenhet_nr"].  "</option>";
                                        }

                                    ?>
                                </select>

                            </div> -->
                            
                            <div class="form-group">
                                <label id="lblEpost" class="label-primary">Epost</label>
                                <input id="epost" type="text" name="epost" class="form-control" style="width:250px" >
                            </div>

                            <div class="form-group">
                                <label id="lblTelefon" class="label-primary">Telefon</label>
                                <input id="telefon" type="text" name="telefon" class="form-control" style="width:200px">
                            </div>

                            
                            <div class="form-group col-sm-4">
                                <br />
                                <input type="button"  class="btn btn-primary btn-send" value="Uppdatera" id="btnUppdateraHyresgast"> 
                            </div>
                        
                        </div>
                </div>
                <!--Info om lägenheten-->
                <div class="row mt-3">

                    <div class="col-4 ">
                        <label class="form-label">Kontraktbunden hyresgäst:</label>
                        <label class="form-label"><strong><?php echo $hyresGInfo->fnamn . " " . $hyresGInfo->enamn  ?></strong></label>
                    </div>
                    
                    <div class="col-6">
                        <!--TABELL SOM ANGER HYRA OCH PARKERING-->
                        <table class="table table-striped w-auto">
                            <thead>
                                <tr >
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
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="row-cols-auto ">
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
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="row">Total hyra</th>
                                    <td><strong><?php echo $hyresGInfo->hyra + $hyresGInfo->parkering . " kronor / månad." ?></strong></td>
                                    <td><strong><?php echo 12 *($hyresGInfo->hyra + $hyresGInfo->parkering) . " kronor / år." ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                        
                    </div>
                </div>

                <!--Kontraktdetaljer-->
                <div class="row mt-2">
                    <div class="col-4 ">
                        <label class="form-label">Kontrakt upprättat: </label>

                        <label class="form-label"><strong><?php echo $hyresGInfo->datumKontrakt ?></strong></label>
                    </div>

                    <!--UPPGIFTER OM KONTRAKT-->
                    <div class="col-8">
                    <table class="table table-striped w-auto" id="tblKontrakt">
                            <thead>
                                <tr >
                                    <th scope="col" class="table-primary">Kontrakt</th>
                                    <th scope="col" class="table-primary">Datum skapat</th>
                                    <th scope="col" class="table-primary">Datum uppsagt</th>
                                    <th scope="col" class="table-primary">Scannat dokument</th>
                                </tr>
                            </thead>

                            <!--Sparade kontrakt-->
                            <?php 
                                if ($hyresGInfo->datumKontrakt != null){
                                   
                                    $lnkPdf = "/bilder/pdf.png";
                                    
                                    echo "
                                        <tr class='row-cols-auto'>
                                            <td><label class='form-control'>" . $hyresGInfo->kontraktNamn . " </label></td>
                                            <td><label class='form-control'>" . $hyresGInfo->datumKontrakt . " </label></td>
                                            <td></td>
                                            
                                            <td>
                                                <a href='visakontrakt.php?kontraktId=" . $hyresGInfo->kontraktId . "'>
                                                <div style='height:100%;width:100%'>
                                                    <img src= .$lnkPdf . ></a>
                                                </div>
                                            </td>
                                        </tr>
                                    ";
                                }
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
                            if ($hyresGInfo->datumKontrakt == null){
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