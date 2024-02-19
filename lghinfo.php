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
    
    $lghInfo = new InfoLagenhet($lagenhetNo);


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Lägenhetinformation</title>
    </head>
    <body>
        <?php include("./pages/sidebar.php") ?>

        <div class="col-sm  min-vh-100 border">
            <h2>Lägenhet</h2>
            <hr />
            <div class="container border" >
                <strong>Information om lägenhet nr <?php echo $lghInfo->lagenhetNo ?></strong>

                
                
                <div class="row mt-3">
                    <div class="col-5">
                        <label class="form-label">Nuvarande lägenhets innehavare:</label>
                        <label class="form-label"><strong><?php echo $lghInfo->innehavare ?></strong></label>
                    </div>
                </div>

            </div>
        </div>
    </body>
</html>