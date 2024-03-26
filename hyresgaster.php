<?php
      if (!isset($_SESSION)) { session_start(); }
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";

      $db = new DbManager();

      if (isset($_GET['fastighetId']))
      {
        $isPostBack = true;
        $fastighetId = intval($_GET['fastighetId']);
      }
      if (!isset($_GET['page'])) 
      {
          $page = 1;
      } else {
          $page = $_GET['page'];
      }

      $result_per_page = 12;
      
      $page_first_result = ($page - 1) * $result_per_page;
      $num_rows = $db->getHyresgastCount($fastighetId);
      $number_of_page = ceil($num_rows / $result_per_page);

      $lagenheter = $db->query("select * from tidlog_lagenhet order by lagenhet_nr")->fetchAll();
      $hyresgaster = $db->query("
        SELECT h.hyresgast_id, h.adress, h.epost, h.enamn, h.fnamn, h.telefon, l.lagenhet_nr, tf.fastighet_id FROM  tidlog_hyresgaster h 
            inner join tidlog_lagenhet l on l.hyresgast_id = h.hyresgast_id 
            inner join tidlog_fastighet tf on tf.fastighet_id = l.fastighet_id
            where tf.fastighet_id = " . $fastighetId . "
        order by lagenhet_nr  LIMIT 
        " . $page_first_result . ',' . $result_per_page)->fetchAll();

    $fastighetNamn = $db->get_fastighet_namn($fastighetId);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Hyresgäster</title>
    </head>

    <body>
        <input type="hidden" id="hidFastighetId" name="HidFastighetId" value=<?php echo $fastighetId; ?> />
        <?php include("./pages/sidebar.php") ?>

        <div class="main">
            <div class="container-fluid" >
                <h2>Nuvarande hyresgäster, boendes på <?php echo $fastighetNamn ?></h2>
                <hr />
                <div class="row mt-3">
                    <div class="col">
                        <table class="table table-hover table-striped " id="hyresgastTable">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="table-primary"></th>
                                    <th scope="col" class="table-primary">Namn</th>
                                    <th scope="col" class="table-primary">Efternamn</th>
                                    <th scope="col" class="table-primary">Lägenhet Nr</th>
                                    <th scope="col" class="table-primary">Uppgång</th>
                                    <th scope="col" class="table-primary">Epost</th>
                                    <th scope="col" class="table-primary">Telefon</th>
                                    <th scope="col" class="table-primary"></th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php 
                                    //iconer finns här : https://www.flaticon.com/
                                    foreach($hyresgaster as $row)
                                    {
                                        $hyresgastId = $row["hyresgast_id"];
                                        $namn = $row["fnamn"];
                                        $enamn = $row["enamn"];
                                        $lagenhetNo = $row["lagenhet_nr"];
                                        $telefon = $row["telefon"];
                                        $epost = $row["epost"];
                                        $upg = $row["adress"];
                                        $lnk = "./bilder/people.png";
                                        
                                        echo "<tr id='$hyresgastId'>
                                            <td>
                                            <div>
                                                <img src='". $lnk . "' alt='' />
                                            </div>
                                            </td>
                                            <td>" . $namn . "</td>"
                                            . "<td>" . $enamn . "</td>"
                                            . "<td><a href='lghinfo.php?lagenhetNo=" . $lagenhetNo . "'>
                                            <div  class='align-items-center'>
                                                " . $lagenhetNo . "</a>
                                            </div></td>"
                                            . "<td>" . $upg . "</td>"
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
                                                echo "<li class='page-item'><a class='page-link' href='hyresgaster.php?page=" . ($page - 1) . "&fastighetId=" . $fastighetId . "'>Föregående</a></li>";
                                            }
                                            for ($i = 1; $i <= $total_pages; $i++) {
                                                if ($i == $page) {
                                                    echo "<li class='page-item active'><a class='page-link' href='hyresgaster.php?page=" . $i . "&fastighetId=" . $fastighetId . "'>" . $i . "</a></li>";
                                                } else {
                                                    echo "<li class='page-item'><a class='page-link' href='hyresgaster.php?page=" . $i . "&fastighetId=" . $fastighetId . "'>" . $i . "</a></li>";
                                                }
                                            }

                                            if ($total_pages > $page) {
                                                echo "<li class='page-item'><a class='page-link' href='hyresgaster.php?page=" . ($page + 1) . "&fastighetId=" . $fastighetId . "'>Nästa</a></li>";
                                            }
                                        }
                                        ?>
                                    </ul>

                                </nav>
                        </div>

                </div>
            </div>
        </div>
        
        </body>
</html>