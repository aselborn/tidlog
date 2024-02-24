<?php
      if (!isset($_SESSION)) { session_start(); }
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";

      $db = new DbManager();
      $parkeringar = $db->query("select * from tidlog_parkering tp left outer join tidlog_lagenhet tl on tp.park_id = tl.park_id 
      order by tp.parknr ")->fetchAll();
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
                                    <th scope="col" class="table-primary">Uthyrd till lägenhet</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <?php 
                                    foreach($parkeringar as $row)
                                    {
                                        if ($row["parknr"]  == null)
                                            continue;

                                        $parkId = $row["park_id"];
                                        $KortNr = $row["parknr"];
                                        $avgift = $row["avgift"];
                                        $lagenhet_nr = $row["lagenhet_nr"] == null ? "Ledig parkering" : $row["lagenhet_nr"];
                                        
                                        if ($lagenhet_nr != "Ledig parkering"){
                                            echo "<tr id='$parkId'><td>" . $KortNr . "</td>"
                                            . "<td>" . $avgift . "</td>"
                                            . "<td> <a href='lghinfo.php?lagenhetNo=" . $lagenhet_nr . "'>
                                            <div style='height:100%;width:100%'>
                                                " . $lagenhet_nr . "</a>
                                            </div></td>"
                                            . "</tr>";
                                        } else {
                                            echo "<tr id='$parkId'><td>" . $KortNr . "</td>"
                                            . "<td>" . $avgift . "</td>"
                                            . "<td>" . $lagenhet_nr . "</td>"
                                            . "</tr>";
                                        }
                                    }
                                ?>
                                </tr>

                                <tr>

                                </tr>
                            </tbody>
                        </table>

                    </div>

            </div>
        </div>
    </body>
</html>