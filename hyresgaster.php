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
      $num_rows = $db->getHyresgastCount();
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
                                    <th scope="col" class="table-primary">Epost</th>
                                    <th scope="col" class="table-primary">Telefon</th>
                                    <th scope="col" class="table-primary"></th>
                                    
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
                                        
                                        
                                        echo "<tr id='$hyresgastId'><td>" . $namn . "</td>"
                                            . "<td>" . $enamn . "</td>"
                                            . "<td><a href='lghinfo.php?lagenhetNo=" . $lagenhetNo . "'>
                                            <div  class='align-items-center'>
                                                " . $lagenhetNo . "</a>
                                            </div></td>"
                                            . "<td>" . $epost . "</td>"
                                            . "<td>" . $telefon . "</td>"
                                            . "<td>
                                                <div class='align-items-center'>
                                                    <input type='button'  class='btn btn-link binder' hyresgast='" . $hyresgastId . "' value='Hantera hyresgäst'></input>
                                                </div>
                                                </td>"
                                            . "</tr>";

                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-1">
                        <form action="nyhyresgast.php" method="POST">
                            <input type="submit" value="Ny hyresgäst" id="btnNyHyresgäst" class="btn btn-success" />
                        </form>
                    </div>

                    <!--Flera sidor.-->
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