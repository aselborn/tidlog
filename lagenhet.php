<?php
      if (!isset($_SESSION)) { session_start(); }
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";
      
      $isPostBack = false;
    
    if (isset($_GET['fastighetId'])){
        $isPostBack = true;
        $fastighetId = intval($_GET['fastighetId']);
    }

      if (!isset($_GET['page'])) 
      {
          $page = 1;
      } else {
          $page = $_GET['page'];
      }

      $db = new DbManager();
      $result_per_page = 16;

      $page_first_result = ($page - 1) * $result_per_page;
      $num_rows = $db->getLagenhetCount($fastighetId);
      $fastighetNamn = $db->get_fastighet_namn($fastighetId);
      $number_of_page = ceil($num_rows / $result_per_page);


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Lägenheter</title>
    </head>

    <?php include("./pages/sidebar.php") ?>

    <body>
            
    <div class="main ">

        <div class="container-fluid mt-5" >
                
                <div class="row mt-2">
                
                    <div class="d-inline-flex">
                        <h3><strong>Lägenheter, fastigheten <?php echo $fastighetNamn?></strong></h3>
                    </div>
                
                    <div class="col">
                        <table class="table table-hover table-striped " id="lagenhetTable">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="table-primary">Lägenhet Nr</th>
                                    <th scope="col" class="table-primary">Hyra</th>
                                    <th scope="col" class="table-primary">Parkering Nr</th>
                                    <th scope="col" class="table-primary">VindNr</th>
                                    <th scope="col" class="table-primary">KällareNr</th>
                                    <th scope="col" class="table-primary">Kontrakt har</th>
                                    <th scope="col" class="table-primary">I andra hand</th>
                                    <!-- <th scope="col" class="table-primary">Yta</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                            //Läser data ur databas.

                          
                                $data = $db->query(
                                    "
                                        SELECT tkr.enamn as kenamn, tkr.fnamn as kfnamn, tkr.andra_hand, 
                                        th.hyresgast_id, th.fnamn, th.enamn, tf.fastighet_id, tl.lagenhet_id, tl.yta, tl.hyra,
                                        tl.lagenhet_nr, tp.parknr,
                                        tv.nummer as vindNr, tk.nummer as kallareNr from tidlog_lagenhet tl 
                                        inner join tidlog_fastighet tf on tf.fastighet_id = tl.fastighet_id
                                        left outer join tidlog_hyresgaster th on th.hyresgast_id = tl.hyresgast_id
                                        left outer join tidlog_parkering tp on tp.park_id = tl.park_id 
                                        left outer join tidlog_vind tv on tv.vind_id = tl.vind_id
                                        left outer join tidlog_kallare tk on tk.kallare_id = tl.kallare_id
                                        left outer join tidlog_kontrakt tkr on tkr.lagenhet_id = tl.lagenhet_id
                                        where tf.fastighet_id = " . $fastighetId . " and tkr.datum_uppsagd IS null
                                    order by lagenhet_nr asc LIMIT " . $page_first_result . ',' . $result_per_page)->fetchAll();
                         
                               

                            foreach ($data as $row) {
                                $hyresgastId = $row["hyresgast_id"];

                                $yta = $row["yta"];
                                $lagenhetNo = $row["lagenhet_nr"];
                                $lagenhetId = $row["lagenhet_id"];
                                $iAndraHand = $row["andra_hand"] == null ? 0 : 1;

                                $fastighet = $row["fastighet_id"] == "1" ? "T7" : "U9";

                                $hyrsAv = ($row["fnamn"] . " " .  $row["enamn"]) == " " ?
                                    "Ledig" : $row["fnamn"] . " " . " " .  $row["enamn"];


                                $hyrsIAndrahandAv = "";
                                if ($iAndraHand == 1){
                                    $hyrsIAndrahandAv = $row["fnamn"] . " " . $row["enamn"];
                                }

                                
                                $parkering = $row["parknr"]  == null ? "" : $row["parknr"];
                                $vindNr = $row["vindNr"] == null ? "" : $row["vindNr"];
                                $kallareNr = $row["kallareNr"] == null ? "" : $row["kallareNr"];
                                $hyra = $row["hyra"];

                                $link = "<tr id='$lagenhetId'><td>
                                <a href='lghinfo.php?lagenhetNo=" . $lagenhetNo . "'>
                                    <div style='height:100%;width:100%'>
                                        " . $lagenhetNo . "
                                    </div>
                                </a>
                                <td>". $hyra . "</td>
                                <td>". $parkering . "</td>
                                <td>". $vindNr . "</td>
                                <td>". $kallareNr . "</td>
                                <td>";

                                if ($hyrsAv != "Ledig" && $hyresgastId != null){
                                    $link .= "<a href='hyrginfo.php?hyresgast_id=" . $hyresgastId . "'>
                                                <div style='height:100%;width:100%'>
                                                " . $hyrsAv . "
                                                </div>
                                            </a>";
                                } else if ($hyrsAv != "Ledig" && $hyresgastId ==  null) {
                                    $link .= "<a href='nyhyresgast.php'>
                                                <div style='height:100%;width:100%'>
                                                " . $hyrsAv . "
                                                </div>
                                            </a>";
                                } else {
                                    $hyrsAv != "Ledig";
                                        $link .= "<a href='nyhyresgast.php'>
                                                    <div style='height:100%;width:100%'>
                                                    " . $hyrsAv . "
                                                    </div>
                                                </a>";
                                }

                                $link .= "<td>$hyrsIAndrahandAv</td>";
                                $link .= "</td>
                                
                                </tr>";

                                echo $link;


                                //echo "<li class='page-item'><a class='page-link' href='lagenhet.php?page=" . $lagenhetNo . "'>" . $lagenhetNo . "</a></li>";
                            }
                            ?>
                         </tbody>
                        </table>
                    </div>
                    <div class="mt-1">
                         

                            <div class="mt-3">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <?php
                                        $pageLink = "";

                                        $total_pages = ceil($num_rows / $result_per_page);

                                        if ($total_pages > 1) {

                                            if ($page >= 2) {
                                                echo "<li class='page-item'><a class='page-link' href='lagenhet.php?page=" . ($page - 1) . "&fastighetId=" . $fastighetId . "'>Föregående</a></li>";
                                            }
                                            for ($i = 1; $i <= $total_pages; $i++) {
                                                if ($i == $page) {
                                                    echo "<li class='page-item active'><a class='page-link' href='lagenhet.php?page=" . $i . "&fastighetId=" . $fastighetId . "'>" . $i . "</a></li>";
                                                } else {
                                                    echo "<li class='page-item'><a class='page-link' href='lagenhet.php?page=" . $i . "&fastighetId=" . $fastighetId . "'>" . $i . "</a></li>";
                                                }
                                            }

                                            if ($total_pages > $page) {
                                                echo "<li class='page-item'><a class='page-link' href='lagenhet.php?page=" . ($page + 1) . "&fastighetId=" . $fastighetId . "'>Nästa</a></li>";
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