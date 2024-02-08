<?php 
    if (!isset($_SESSION)) { session_start(); }

    require_once "./code/dbmanager.php";
    require_once "./code/managesession.php";
    
    if (!isset($_GET['lagenhetId'])) {
        $lagenhetId = 1;
    } else {
        $lagenhetId = $_GET['lagenhetId'];
    }
    
    $lghInfo = $lagenhetId;

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Lägenheter</title>
    </head>
    <body>
        <?php include("./pages/sidebar.php") ?>

        <div class="col-sm  min-vh-100 border">
            <h2>Lägenheter</h2>
            <hr />
            <div class="container border" >
                <strong>information om lägenhet <?php echo $lghInfo ?></strong>
            </div>
        </div>
    </body>
</html>