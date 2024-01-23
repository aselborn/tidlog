<?php
      if (!isset($_SESSION)) { session_start(); }
      require_once "../code/managesession.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Sammanställning</title>
    </head>

    <body>
        <?php include("sidebar.php") ?>

        <div class="col-sm  min-vh-100 border">
            <h2>Sammanställning</h2>
            <hr />
        </div>
    </body>
</html>