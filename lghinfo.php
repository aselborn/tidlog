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
    $parkeringar = $db->query("select * from tidlog_parkering ")->fetchAll();

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
                    
                    <!-- <div class="col-4 ">
                        <label class="form-label">Hyr i andrahand:</label>
                        <label class="form-label"><strong><?php echo $lghInfo->andrahand ?></strong></label>
                        
                        <input type="button" id="btnAndraHand" class="btn btn-success" value="Spara">
                    </div> -->

                    <div class="col-6 ">
                        
                            <div class="d-sm-inline-flex mt-2 "> 
                                <label class="form-label mx-2">Ange hyra: </label>
                                <input class="form-control-sm" type="number" style="width: 88px;" mx-2 id="txtNyHyra" />
                                <input type="button" id="btnNyHyra" class="btn btn-success" value="Spara">
                                <label class="form-label ">Nuvarande hyra:</label>
                                <label class="form-label"><strong><?php echo $lghInfo->hyra . " kr/mån" ?></strong></label>
                            </div>

                            <div class="d-sm-inline-flex  mt-2"> 
                                <label class="form-label mx-2">Parkering: </label>
                                <select id="cboParkering" class="form-select" name="Parkering" >
                                    <?php 

                                    foreach($parkeringar as $row)
                                    {
                                        echo "<option value='" .$row["park_id"] ."'>" .$row["parknr"].  "</option>";
                                    }

                                    ?>
                                    
                                </select>
                                
                                
                            </div>
                            <input type="button" id="btnParkering" class="btn btn-success " value="Spara">
                        
                            

                            
                        
                        <div class="col mt-1">
                            <label class="form-label mx-2">Total månadshyra : <?php echo $lghInfo->hyra + $lghInfo->parkering . " kr/månad" ?></label>
                        </div>
                    </div>
                </div>

                <!--Kontraktdetaljer-->
                <div class="row mt-2">
                    <div class="col-4 ">
                        <label class="form-label">Kontrakt upprättat: </label>
                        <label class="form-label"><strong><?php echo $lghInfo->datumKontrakt ?></strong></label>
                    </div>
                </div>

                <!--Renoveringar.-->
                <div class="row mt-2">

                </div>

            </div>
        </div>
    </body>
</html>