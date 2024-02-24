<?php 
    if (!isset($_SESSION)) { session_start(); }

    require_once "./code/dbmanager.php";
    require_once "./code/managesession.php";
    require_once "./code/objLagenhet.php";

    if (!isset($_GET['lagenhetNo'])) {
        $lagenhetNo = 1;
    } else {
        $lagenhetNo = $_GET['lagenhetNo'];
    }
    
    $db = new DbManager();
    $parkeringar = $db->query("select * from tidlog_parkering tp2 where tp2.park_id not in (
        select park_id from tidlog_parkering tp where park_id in (select park_id from tidlog_lagenhet tl)) ")->fetchAll();

    $lghInfo = new InfoLagenhet($lagenhetNo);
    

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Lägenhetinformation</title>
    </head>
    
    <body>
        <input type="hidden" id="hidlagenhetNo" name="HidLagenhetNo" value="<?php echo $lagenhetNo ?>" >
        <?php include("./pages/sidebar.php") ?>

        <div class="col-sm  min-vh-100 border">
            <h2>Lägenhet</h2>
            <hr />
            <div class="container border" >
                <div class="d-inline-flex">
                    <h3><strong>Information om lägenhet nr <?php echo $lghInfo->lagenhetNo ?></strong></h3>
                </div>
                
                <!--Info om lägenheten-->
                <div class="row mt-3">

                    <div class="col-4 ">
                        <label class="form-label">Kontraktbunden hyresgäst:</label>
                        <label class="form-label"><strong><?php echo $lghInfo->innehavare ?></strong></label>
                    </div>
                    
                    <div class="col-6">
                        <!--TABELL SOM ANGER HYRA OCH PARKERING-->
                        <table class="table table-striped w-auto">
                            <thead>
                                <tr >
                                    <th scope="col" class="table-primary">Hyra</th>
                                    <th scope="col" class="table-primary">Ny Hyra</th>
                                    <?php 
                                        if ($lghInfo->parkering == 0){
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
                                    <td><?php echo $lghInfo->hyra . " kr/mån" ?></td>
                                    <td class="mt-1 border">
                                        <input class="form-control-sm" style="width: 120px;" type="number" id="txtNyHyra" />
                                        <input type="button" id="btnNyHyra" class="btn btn-success" value="Spara">
                                    </td>
                                    
                                    <!-- <td>
                                        <?php if ($lghInfo->parkering == 0){
                                            echo '<label class="form-label">Välj parkering: </label>';
                                        }

                                        ?>
                                    </td> -->

                                    <td class="mt-1">
                                        <?php 
                                            if ($lghInfo->parkering == 0){
                                                
                                                echo '<select id="cboParkering" class="form-select" name="Parkering">';
                                                foreach($parkeringar as $row)
                                                {
                                                    echo "<option value='" .$row["park_id"] ."'>" .$row["parknr"].  "</option>";
                                                }
                                                echo '</select>';

                                            } else {
                                                echo "<label class='form-label' >" .  $lghInfo->parkering . " kr/mån" . " </label>";
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            if ($lghInfo->parkering > 0){
                                                echo "<input type='button' id='btnRemovePark' class='btn btn-success ' value='Ta bort'> ";
                                            }
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="row">Total hyra</th>
                                    <td><strong><?php echo $lghInfo->hyra + $lghInfo->parkering . " kronor / månad." ?></strong></td>
                                    <td><strong><?php echo 12 *($lghInfo->hyra + $lghInfo->parkering) . " kronor / år." ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                        
                    </div>
                </div>

                <!--Kontraktdetaljer-->
                <div class="row mt-2">
                    <div class="col-4 ">
                        <label class="form-label">Kontrakt upprättat: </label>

                        <label class="form-label"><strong><?php echo $lghInfo->datumKontrakt ?></strong></label>
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
                                if ($lghInfo->datumKontrakt != null){
                                    $dtdat = date_create($lghInfo->datumKontrakt);
                                    $dt = date_format($dtdat, "Y-m-d");
                                    echo "
                                        <tr class='row-cols-auto'>
                                            <td><label class='form-control'>" . $lghInfo->kontraktNamn . " </label></td>
                                            <td><label class='form-control'>" . $dt . " </label></td>
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
                                <input type="hidden" value=<?php echo $lghInfo->hyresgastId ?> name="hdHyresgast"/>
                                <input type="hidden" value=<?php echo $lghInfo->lagenhetId ?> name="hdLagenhetId"/>
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
                            if ($lghInfo->datumKontrakt == null){
                                echo '<input type="button" id="btnAddKontraktDokument"value="Nytt" class="btn btn-success" />';
                            }
                        ?>
                        
                    </div>
                </div>

                <!--Nyckekvitton.-->
                <div class="row mt-2">
                    <div class="col-4 ">
                        <label class="form-label">Nyckelkvitton: </label>
                        
                        <label class="form-label"><strong><?php echo $lghInfo->datumNyckelKvitto ?></strong></label>
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