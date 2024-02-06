<?php
      if (!isset($_SESSION)) { session_start(); }
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";
      
      if (!isset($_GET['page'])) 
      {
          $page = 1;
      } else {
          $page = $_GET['page'];
      }

      $db = new DbManager();
      $result_per_page = 12;

      $page_first_result = ($page - 1) * $result_per_page;
      $num_rows = $db->getLagenhetCount();
      $number_of_page = ceil($num_rows / $result_per_page);

    

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
            <div class="container" >
                <div class="row mt-3">
                    <div class="col-2">
                        <label id="lblFastighet" class="label-primary">Välj fastighet</label>
                        <select id="fastighetId" class="form-select" name="job_fastighet">
                            <option value="1">T7</option>
                            <option value="2">U9</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <table class="table table-hover table-striped " id="lagenhetTable">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="table-primary">Lägenhet Nr</th>
                                    <th scope="col" class="table-primary">Fastighet</th>
                                    <th scope="col" class="table-primary">Yta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                            //Läser data ur databas.

                            $data = $db->query("SELECT * from tidlog_lagenhet order by lagenhet_nr asc LIMIT " . $page_first_result . ',' . $result_per_page)->fetchAll();
                            

                            foreach ($data as $row) {
                                $yta = $row["yta"];
                                $lagenhetNo = $row["lagenhet_nr"];
                                $lagenhetId = $row["lagenhet_id"];

                                $fastighet = $row["fastighet_id"] == "1" ? "T7" : "U9";

                                echo "<tr id='$lagenhetId' ><td>" . $lagenhetNo . "</td><td>"
                                    . $fastighet . "</td><td>"
                                    . $yta . "</td></tr>";
                            }
                            ?>
                         </tbody>
                        </table>
                    </div>
                    <div class="mt-1">
                            <!-- <form action="addlagenhet.php" method="POST" id="frmInput">
                                <div class="d-inline-flex align-bottom p-1 gap-2">
                                
                                    <div class="form-group">
                                        <label id="lblLagenhetNo" class="label-primary">Lägenhet Nr</label>
                                        <input id="lagenhetNo" type="text" name="lagenhet_nr" class="form-control" >
                                    </div>
                                
                                
                                    <div class="form-group">
                                        <label id="lblDatum" class="label-primary">Yta</label>
                                        <input id="lagenhetYta" type="text" name="lagenhet_yta" class="form-control" >                                            
                                    </div>
                                
                                    <div class="form-group col-sm-4">
                                        <br />
                                        <input type="button" id="btnSave" class="btn btn-primary btn-send" value="Spara">                                          
                                    </div>
                                </div>
                            </form> -->

                            <div class="mt-3">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <?php
                                        $pageLink = "";

                                        $total_pages = ceil($num_rows / $result_per_page);

                                        if ($total_pages > 1) {

                                            if ($page >= 2) {
                                                echo "<li class='page-item'><a class='page-link' href='lagenhet.php?page=" . ($page - 1) . "'>Föregående</a></li>";
                                            }
                                            for ($i = 1; $i <= $total_pages; $i++) {
                                                if ($i == $page) {
                                                    echo "<li class='page-item active'><a class='page-link' href='lagenhet.php?page=" . $i . "'>" . $i . "</a></li>";
                                                } else {
                                                    echo "<li class='page-item'><a class='page-link' href='lagenhet.php?page=" . $i . "'>" . $i . "</a></li>";
                                                }
                                            }

                                            if ($total_pages > $page) {
                                                echo "<li class='page-item'><a class='page-link' href='lagenhet.php?page=" . ($page + 1) . "'>Nästa</a></li>";
                                            }
                                        }
                                        ?>
                                    </ul>

                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
</html>