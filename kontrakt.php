<?php
      if (!isset($_SESSION)) { session_start(); }
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";
      require_once "./code/datum_helper.php";

    
      $db = new DbManager();
      $dtHelper = new DatumHelper();

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
      $num_rows = $db->getContratCount($fastighetId);
      $number_of_page = ceil($num_rows / $result_per_page);

      $lagenheter = $db->query("select * from tidlog_lagenhet order by lagenhet_nr")->fetchAll();
      
      $kontrakt = $db->query("
        SELECT h.hyresgast_id,  h.enamn, h.fnamn,  l.lagenhet_nr, tf.fastighet_id, tk.kontrakt_id,
        tk.datum , tk.datum_uppsagd , tk.kontrakt, tk.andra_hand, tk.enamn as efternamn, tk.fnamn as fornamn
          FROM  tidlog_hyresgaster h 
            inner join tidlog_lagenhet l on l.hyresgast_id = h.hyresgast_id 
            inner join tidlog_fastighet tf on tf.fastighet_id = l.fastighet_id
            inner join tidlog_kontrakt tk on tk.lagenhet_id = l.lagenhet_id

            where tf.fastighet_id = " . $fastighetId . "
        order by lagenhet_nr  LIMIT 
        " . $page_first_result . ',' . $result_per_page)->fetchAll();

    $fastighetNamn = $db->get_fastighet_namn($fastighetId);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Tidigare Kontrakt</title>
    </head>

    <body>
        <input type="hidden" id="hidFastighetId" name="HidFastighetId" value=<?php echo $fastighetId; ?> />
        <?php include("./pages/sidebar.php") ?>

        <div class="main">
            <div class="container-fluid mt-4" >
            <hr />    
                <h2>Sparade kontrakt för <?php echo $fastighetNamn ?></h2>
                
                <div class="row mt-3">
                    <div class="col">
                        <table class="table table-hover table-striped " id="hyresgastTable">
                            <thead class="table-dark">
                                <tr>
                                    
                                    <th scope="col" class="table-primary"></th>
                                    <th scope="col" class="table-primary">Namn</th>
                                    <th scope="col" class="table-primary">Efternamn</th>
                                    <th scope="col" class="table-primary">Lägenhet Nr</th>
                                    <th scope="col" class="table-primary">Giltligt från</th>
                                    <th scope="col" class="table-primary">Giltligt till</th>
                                    <th scope="col" class="table-primary">Kontrakt</th>
                                    <th scope="col" class="table-primary">Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php 
                                    //iconer finns här : https://www.flaticon.com/
                                    foreach($kontrakt as $row)
                                    {
                                        $statusText = "";
                                        $hyresgastId = $row["hyresgast_id"];
                                        $kontraktId = $row["kontrakt_id"];
                                        $namn = $row["fornamn"] == null ? $row["fnamn"] : $row["fornamn"];
                                        $enamn = $row["efternamn"] == null ? $row["enamn"] : $row["efternamn"];

                                        $lagenhetNo = $row["lagenhet_nr"];
                                        
                                        $giltFran = $row["datum"];
                                        $giltligTill = $row["datum_uppsagd"] == null ? "" : $dtHelper->GetDatum($row["datum_uppsagd"]);

                                        if ($row["andra_hand"] == 1)
                                            $statusText = "<label class='text-bg-warning'><span>Andra Hand</span></label>";

                                        if ($row["andra_hand"] == 0 && $giltligTill == null)
                                            $statusText = "<label class='text-bg-info'><span>Aktuellt kontrakt</span></label>";

                                        if ($row["datum_uppsagd"] != null && $row["andra_hand"] == 0){
                                            $statusText = "<label class='text-bg-success'><span>Avslutat kontrakt</span></label>";
                                        }

                                        $lnk = "./bilder/contract.png";
                                        $lnkPdf = "/bilder/pdf-file.png";
                                        
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
                                            . "<td>" . $dtHelper->GetDatum($giltFran) . "</td>"
                                            . "<td>" . $giltligTill . "</td>"
                                            . "<td>
                                                <a href='visakontrakt.php?kontraktId=" . $kontraktId . "'>
                                                    <div style='display:table-cell; vertical-align:middle; text-align:center'>
                                                        <img src= .$lnkPdf . ></a>
                                                    </div>
                                                </td>"
                                            . "<td>" . $statusText . "</td>"
                                            . "</tr>";

                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-1">
                        <form action="<?php echo "nyttkontrakt.php?fastighetId=$fastighetId" ?>"  method="POST">
                            <input type="submit" value="Nytt kontrakt" id="btnNyttKontrakt" class="btn btn-success" />
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
                                                echo "<li class='page-item'><a class='page-link' href='kontrakt.php?page=" . ($page - 1) . "&fastighetId=" . $fastighetId . "'>Föregående</a></li>";
                                            }
                                            for ($i = 1; $i <= $total_pages; $i++) {
                                                if ($i == $page) {
                                                    echo "<li class='page-item active'><a class='page-link' href='kontrakt.php?page=" . $i . "&fastighetId=" . $fastighetId . "'>" . $i . "</a></li>";
                                                } else {
                                                    echo "<li class='page-item'><a class='page-link' href='kontrakt.php?page=" . $i . "&fastighetId=" . $fastighetId . "'>" . $i . "</a></li>";
                                                }
                                            }

                                            if ($total_pages > $page) {
                                                echo "<li class='page-item'><a class='page-link' href='kontrakt.php?page=" . ($page + 1) . "&fastighetId=" . $fastighetId . "'>Nästa</a></li>";
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