<?php
      if (!isset($_SESSION)) { session_start(); }
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";

      $db = new DbManager();
      $parkeringar = $db->query("select * from tidlog_parkering ")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Parkeringar</title>
        
    </head>

    <body>
        
        <?php include("./pages/sidebar.php") ?>

        <div class="col-sm  min-vh-100 border">
            <h2>Parkeringar</h2>
            <hr />
            <div class="container border" >

            <div class="row mt-3">
                    <div class="col">
                        <table class="table table-hover table-striped " id="hyresgastTable">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="table-primary">Kortnummer</th>
                                    <th scope="col" class="table-primary">Avgift (kr/månad)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    foreach($parkeringar as $row)
                                    {
                                        $parkId = $row["park_id"];
                                        $KortNr = $row["parknr"];
                                        $avgift = $row["avgift"];
                                        
                                        echo "<tr id='$parkId'><td>" . $KortNr . "</td>"
                                            . "<td>" . $avgift . "</td>"
                                            . "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>

                    </div>

            </div>
        </div>
    </body>
</html>