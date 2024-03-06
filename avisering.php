<?php
      if (!isset($_SESSION)) { session_start(); }
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";

      $db = new DbManager();
      $isPostBack = false;

      if (isset($_GET['year']) || isset($_GET['month'])){
        $month = intval($_GET['month']);
        $yr = intval($_GET['year']);
        $isPostBack=true;
      } else {
        $month = intval(date('m'));
        $yr = intval(date('Y'));
      }

      
    //   $fakturor = $db->query("select * from tidlog_faktura tf 
    //   inner join tidlog_hyresgaster th on tf.hyresgast_id = th.hyresgast_id 
    //   inner join tidlog_lagenhet tl on tl.lagenhet_id = tf.lagenhet_id 
    //   left outer join tidlog_parkering tp on tp.park_id =tl.park_id 
    //   WHERE tf.faktura_year = ? and tf.faktura_month = ?", array($yr, $month))->fetchAll();

    $fakturor = $db->get_faktura_underlag($yr, $month);

      if (!isset($_GET['page'])) 
      {
          $page = 1;
      } else {
          $page = $_GET['page'];
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
                ";
            }
        ?>
        <?php include("./pages/sidebar.php") ?>

        <div class="col-sm  min-vh-100 border">
            <h2>Skapa hyresavier</h2>
            <hr />
            <div class="container " >
            
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
                        <input type="button" class="btn btn-success " id="btnSelectPeriodPostBack" name="visa period" value="Visa Period">
                        
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
                            <th scope="col" class="table-primary">Skicka</th>
                        </tr>
                    </thead>
                    <?php $totalHyra = 0; $totalParkering=0;?>
                    <tbody>

                        <?php 
                            foreach($fakturor as $row)
                            {
                                $fakturaId= $row["faktura_id"];
                                $hyresgastId = $row["hyresgast_id"];
                                $avgift = $row["avgift"] == null ? "0" : $row["avgift"];
                                $total = $avgift + $row["hyra"];
                                $totalParkering += $avgift;
                                $period = $row["faktura_year"] . "-" . $row["faktura_month"];
                                $lnkPdf = "/bilder/pdf-file.png";
                                $theFaktura = $row["fakturaExists"];
                                $totalHyra += intval($row["hyra"]);

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
                                        <input type='button' value='Skicka faktura' faktura='" .$fakturaId . "' hyresgast='" . $hyresgastId . "' name='skicka_pdf' class='btn  btn-link binder_faktura_skicka'>
                                        </td>
                                        ";
                                        

                                    } else {
                                        echo "
                                        <td>
                                            <input type='button' value='Skapa faktura' faktura='" .$fakturaId . "' hyresgast='" . $hyresgastId . "' name='skapa_pdf' class='btn btn-primary thebinder'>
                                        </td>";
                                    }
                                        
                                echo "</tr>";
                            }
                        ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="row">Total hyra</th>
                                <td>Perioden Hyra: <strong><?php echo $totalHyra ?></strong></td>
                                <td>Perioden Parkering: <strong><?php echo $totalParkering ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
                <form  action="./code/createpdf.php" method="post" enctype="multipart/form-data">
                    <input type="submit" value="Skapa PDF" id="btnPdf" class="btn btn-success" ></input>
                </form>
                
            </div>
        </body>
</html>