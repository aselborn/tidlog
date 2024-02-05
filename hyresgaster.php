<?php
      if (!isset($_SESSION)) { session_start(); }
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";

      $db = new DbManager();

      if (!isset($_GET['page'])) 
      {
          $page = 1;
      } else {
          $page = $_GET['page'];
      }

      $result_per_page = 6;

      $page_first_result = ($page - 1) * $result_per_page;
      $num_rows = $db->getLagenhetCount();
      $number_of_page = ceil($num_rows / $result_per_page);

      
      //$lagenheter = $db->query("select * from tidlog_lagenhet where lagenhet_id not in (select lagenhet_id from tidlog_hyresgaster)")->fetchAll();
      $lagenheter = $db->query("select * from tidlog_lagenhet order by lagenhet_nr")->fetchAll();
      $hyresgaster = $db->query("SELECT * FROM  tidlog_hyresgaster h inner join tidlog_lagenhet l on h.lagenhet_id = l.lagenhet_id order by lagenhet_nr  LIMIT " . $page_first_result . ',' . $result_per_page)->fetchAll();
      

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Hyresgäster</title>
    </head>

    <body>
        
        <?php include("./pages/sidebar.php") ?>

        <div class="col-sm  min-vh-100 border">
            <h2>Hyresgäster</h2>
            <hr />
            <div class="container border" >
                <div class="row mt-3">
                    <div class="col-2">
                        <label id="lblFastighet" class="label-primary">Välj fastighet</label>
                        <select id="cboFastighet" class="form-select" name="job_fastighet">
                            <option value="T7">T7</option>
                            <option value="U9">U9</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <table class="table table-hover table-striped " id="hyresgastTable">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="table-primary">Namn</th>
                                    <th scope="col" class="table-primary">Efternamn</th>
                                    <th scope="col" class="table-primary">Lägenhet Nr</th>
                                    <th scope="col" class="table-primary">Telefon</th>
                                    <th scope="col" class="table-primary">Epost</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    foreach($hyresgaster as $row)
                                    {
                                        $hyresgastId = $row["hyresgast_id"];
                                        $namn = $row["fnamn"];
                                        $enamn = $row["enamn"];
                                        $lagenhetNo = $row["lagenhet_nr"];
                                        $telefon = $row["telefon"];
                                        $epost = $row["epost"];
                                        
                                        
                                        echo "<tr id=' $hyresgastId'><td>" . $namn . "</td>"
                                            . "<td>" . $enamn . "</td>"
                                            . "<td>" . $lagenhetNo . "</td>"
                                            . "<td>" . $epost . "</td>"
                                            . "<td>" . $telefon . "</td>"
                                            . "</tr>";

                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-1">
                        
                        <form action="./code/addhyresgast.php" method="POST" id="frmAddHyresgast">
                            
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

                                <div class="form-group">
                                    <label id="lblLagenhetNo" class="label-primary" >Lägenhet Nr</label>
                                    
                                    <select id="lagenhetId" class="form-select" name="lagenhet" style="width:130px">
                                        <?php 

                                            foreach($lagenheter as $row)
                                            {
                                                echo "<option value='" .$row["lagenhet_id"] ."'>" .$row["lagenhet_nr"].  "</option>";
                                            }

                                        ?>
                                        <!-- <option value="T7">T7</option>
                                        <option value="U9">U9</option> -->
                                    </select>

                                </div>
                                
                                <div class="form-group">
                                    <label id="lblTelefon" class="label-primary">Telefon</label>
                                    <input id="telefon" type="text" name="telefon" class="form-control" style="width:200px">
                                </div>

                                <div class="form-group">
                                    <label id="lblEpost" class="label-primary">Epost</label>
                                    <input id="epost" type="text" name="epost" class="form-control" style="width:250px" >
                                </div>

                                <!-- <div class="form-group col-sm-4">
                                    <br />
                                    <input type="button"  class="btn btn-primary btn-send" value="Spara" id="btnSparaHyresgast"> 
                                </div> -->
                                <div class="form-group col-sm-4">
                                    <br />
                                    <input type="button"  class="btn btn-primary btn-send" value="Uppdatera" id="btnUppdatera"> 
                                </div>
                            
                            </div>
                        
                        </form>
                        
                    </div>

                    <div class="mt-3">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <?php
                                        $pageLink = "";

                                        $total_pages = ceil($num_rows / $result_per_page);

                                        if ($total_pages > 1) {

                                            if ($page >= 2) {
                                                echo "<li class='page-item'><a class='page-link' href='hyresgaster.php?page=" . ($page - 1) . "'>Föregående</a></li>";
                                            }
                                            for ($i = 1; $i <= $total_pages; $i++) {
                                                if ($i == $page) {
                                                    echo "<li class='page-item active'><a class='page-link' href='hyresgaster.php?page=" . $i . "'>" . $i . "</a></li>";
                                                } else {
                                                    echo "<li class='page-item'><a class='page-link' href='hyresgaster.php?page=" . $i . "'>" . $i . "</a></li>";
                                                }
                                            }

                                            if ($total_pages > $page) {
                                                echo "<li class='page-item'><a class='page-link' href='hyresgaster.php?page=" . ($page + 1) . "'>Nästa</a></li>";
                                            }
                                        }
                                        ?>
                                    </ul>

                                </nav>
                        </div>

                </div>
            </div>
        </body>
</html>