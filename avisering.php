<?php
      if (!isset($_SESSION)) { session_start(); }
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";
      require_once "./code/datum_helper.php";

      $db = new DbManager();
      $dtHelper = new DatumHelper();

      $isPostBack = false;
      if (!isset($_GET['page'])) 
      {
          $page = 1;
      } else {
          $page = $_GET['page'];
      }

      if (isset($_GET['fastighetId'])){
        $isPostBack = true;
        $fastighetId = intval($_GET['fastighetId']);
      }

      if (isset($_GET['year']) || isset($_GET['month'])){
        $month = intval($_GET['month']);
        $yr = intval($_GET['year']);
        $isPostBack=true;
      } else {
        $month = intval(date('m'));
        $yr = intval(date('Y'));
      }

      $result_per_page = 15;
      
      $page_first_result = ($page - 1) * $result_per_page;
      $num_rows = $db->getfakturaCountPerFastighet($yr, $month, $fastighetId);
      $number_of_page = ceil($num_rows / $result_per_page);

    $fastighetNamn = $db->get_fastighet_namn($fastighetId);

    $fakturor = $db->get_faktura_underlag($yr, $month, $fastighetId, $page_first_result, $result_per_page);
    $periodHyra = $db->get_perioden_hyra($yr, $month, $fastighetId);
    
    foreach($periodHyra as $period)
    {
        $totalt_perioden_hyra = intval($period["period_hyra"]);
        $totalt_perioden_park = intval($period["period_parkering"]);
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Avisering</title>
    </head>

    <body>
        <?php 
            if ($isPostBack){
                echo 
                "
                    <input type='hidden' id='hdYear' value='" .$yr . "' />
                    <input type='hidden' id='hdMonth' value='" .$month . "' />
                    <input type='hidden' id='hdFastighet' value='" .$fastighetId . "'/>
                ";
            }
        ?>
        <?php include("./pages/sidebar.php") ?>
    <div class="main">

        <div class="container-fluid mt-4" >
        <hr />    
        <h2>Skapa hyresavier, för fastigheten <?php echo $fastighetNamn; ?></h2>
            
            <div class="row ">
                
                    <div class="col-2">
                        <label  class="label-primary">Månad</label>
                        <div class="form-control">
                        <select class="form-select" id="selectedMonthFaktura">
                            <option value="1" >Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Mars</option>
                            <option value="4">April</option>
                            <option value="5">Maj</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Augusti</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">December</option>

                        </select>
                        </div>
                        
                        
                    </div>
                    <div class="col-2">
                        <label  class="label-primary">År</label>
                        <div class="form-control">
                        <select class="form-select" id="selectedYearFaktura">
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                            <option value="2030">2030</option>
                        </select>
                        </div>
                    </div>

                    <div class="col-2 mt-2">
                        <br />
                        
                        
                        <!-- <input type="button" class="btn btn-success " id="btnSelectPeriod" name="visa period" value="Visa Period"> -->
                        <input type="button" class="btn btn-success d-none" id="btnSelectPeriodPostBack" name="visa period" value="Visa Period">
                        
                    </div>

                    <div class="col-2 mt-2">
                        <br />
                        <input type="button" class="btn btn-primary " id="btnSkapaFakturaUnderlag" name="skapaFaktura" value="Skapa underlag för period">
                    </div>
            </div>
            
                <table id="tblAvisering" class="table table-hover table-striped mt-3">

                    <thead>
                        <tr>
                            <th scope="col" class="table-primary">Hyresgäst</th>
                            <th scope="col" class="table-primary">Lägenhet</th>
                            <th scope="col" class="table-primary">Fakt.Nr</th>
                            <th scope="col" class="table-primary">Period</th>
                            <th scope="col" class="table-primary">Hyra</th> 
                            <th scope="col" class="table-primary">Parkering</th> 
                            <th scope="col" class="table-primary">Totalt</th> 
                            <th scope="col" class="table-primary">Faktura</th>
                            <th scope="col" class="table-primary"></th>
                            <th scope="col" class="table-primary">Status</th>
                            <th scope="col" class="table-primary">Skickad</th>
                            <th scope="col" class="table-primary">Betald</th>
                        </tr>
                    </thead>
                    <?php $totalHyra = 0; $totalParkering=0; $tableRows = 0; $status = null; $skickad = null; $hyraT7=0; $hyraU9=0;?>
                    <tbody>

                        <?php 
                            foreach($fakturor as $row)
                            {
                                $tableRows++;
                                $hasFakturor=true;
                                $fakturaId= $row["faktura_id"];
                                $hyresgastId = $row["hyresgast_id"];
                                $avgift = $row["avgift"] == null ? "0" : $row["avgift"];
                                $total = $avgift + $row["hyra"];
                                $totalParkering += $avgift;
                                $period = $row["faktura_year"] . "-" . $row["faktura_month"];
                                $lnkPdf = "/bilder/pdf-file.png";
                                $picOk = "/bilder/check_ok.png";
                                $picSendMail = "/bilder/send_mail.png";
                                $picFail = "/bilder/fail.png";
                                $theFaktura = $row["fakturaExists"];
                                
                                $status = $row["status"] == null ? null : $row["status"];
                                $skickad = $row["status_skickad"];
                                $inbetald = $row["inbetald"] == null ? null : $dtHelper->GetDatum($row["inbetald"]);

                                $totalHyra += intval($row["hyra"]);

                                if ($row["fastighet_id"] == 1)
                                    $hyraT7 += intval($row["hyra"]);

                                if ($row["fastighet_id"] == 2)
                                    $hyraU9 += intval($row["hyra"]);
                                
                                echo 
                                "<tr>
                                    <td>" . $row['fnamn'] . " " . $row['enamn']  .  "</td>
                                    <td>" . $row['lagenhet_nr'] .  "</td>
                                    <td>" . $row['fakturanummer'] .  "</td>
                                    <td>" . $period .  "</td>
                                    <td>" . $row['hyra'] .  "</td>
                                    <td>" . $row['avgift']  .  "</td>
                                    <td>" . $total .  "</td>";
                                    
                                    if ($theFaktura == 1){
                                        echo 
                                        "<td >
                                            <a href='visafaktura.php?fakturaId=" . $row["faktura_id"] . "'>
                                                <div >
                                                    <img src= .$lnkPdf class='mx-auto d-block' ></a>
                                                </div>
                                        </td>
                                        <td>
                                            <input type='button' value='Skicka faktura' skickad='" . $skickad . "' faktura='" .$fakturaId . "' hyresgast='" . $hyresgastId . "' name='skicka_pdf' class='btn btn-sm btn-outline-success rounded-5 binder_faktura_skicka'>
                                        </td>
                                        ";
                                        if ($status != null){
                                            echo 
                                            "<td>
                                                <div>
                                                    <img src= .$picOk class='mx-auto d-block' >
                                                </div>
                                            </td>
                                            <td>
                                                " . $skickad . "
                                            </td>";
                                        }
                                        if ($inbetald != null){
                                            echo 
                                            "
                                                <td>
                                                    " . $inbetald . "
                                                </td>
                                            ";
                                        }

                                    } else {
                                        echo "
                                        <td>
                                            <input type='button' value='Skapa faktura' skickad='" . $skickad . "' faktura='" .$fakturaId . "' hyresgast='" . $hyresgastId . "' name='skapa_pdf' class='btn btn-outline-success btn-sm rounded-5 thebinder'>
                                        </td>
                                       ";
                                    }
                                        
                                echo "</tr>";
                            }

                        ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="row">Total hyra</th>
                                <td>Perioden Hyra: <strong><?php echo $totalt_perioden_hyra ?></strong></td>
                                <td>Parkering: <strong><?php echo $totalt_perioden_park ?></strong></td>
                        </tr>
                    </tfoot>
                </table>

                 

                <!-- <form  action="./code/createpdf.php" method="post" enctype="multipart/form-data">
                    <input type="submit" value="Skapa Faktura" id="btnPdf" class="btn btn-success" ></input>
                </form> -->

                <div class="mt-3">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <?php
                                        $pageLink = "";

                                        $total_pages = ceil($num_rows / $result_per_page);

                                        if ($total_pages > 1) {

                                            if ($page >= 2) {
                                                echo "<li class='page-item'><a class='page-link' href='avisering.php?page=" . ($page - 1) . "&fastighetId=" . $fastighetId . "&year=" . $yr . "&month=" . $month . "'>Föregående</a></li>";
                                            }
                                            for ($i = 1; $i <= $total_pages; $i++) {
                                                if ($i == $page) {
                                                    echo "<li class='page-item active'><a class='page-link' href='avisering.php?page=" . $i . "&fastighetId=" . $fastighetId . "&year=" . $yr . "&month=" . $month . "'>" . $i . "</a></li>";
                                                } else {
                                                    echo "<li class='page-item'><a class='page-link' href='avisering.php?page=" . $i . "&fastighetId=" . $fastighetId . "&year=" . $yr . "&month=" . $month . "'>" . $i . "</a></li>";
                                                }
                                            }

                                            if ($total_pages > $page) {
                                                echo "<li class='page-item'><a class='page-link' href='avisering.php?page=" . ($page + 1) . "&fastighetId=" . $fastighetId . "&year=" . $yr . "&month=" . $month . "'>Nästa</a></li>";
                                            }
                                        }
                                        ?>
                                    </ul>

                                </nav>
                        </div>
            </div>
<!--Flera sidor.-->
            <?php echo "<input type='hidden' id='hdRowCount' value='" .$tableRows . "' />" ?>
        </div>
    </div>
    </body>
</html>