<?php 
    if (!isset($_SESSION)) { session_start(); }
    require_once "./code/dbmanager.php";
    require_once "./code/managesession.php";
    
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
                <strong>information om lägenhet</strong>
            </div>
        </div>
    </body>
</html>