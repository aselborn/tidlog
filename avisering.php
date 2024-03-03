<?php
      if (!isset($_SESSION)) { session_start(); }
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";

      $db = new DbManager();

      $fakturor = $db->query("select * from tidlog_faktura tf 
      inner join tidlog_hyresgaster th on tf.hyresgast_id = th.hyresgast_id 
      inner join tidlog_lagenhet tl on tl.lagenhet_id = tf.lagenhet_id 
      left outer join tidlog_parkering tp on tp.park_id =tl.park_id ")->fetchAll();

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
        
        <?php include("./pages/sidebar.php") ?>

        <div class="col-sm  min-vh-100 border">
            <h2>Avisering</h2>
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
                        
                        <!-- <input type="date" class="form-control" id="dtAviseringStart" name="dtFom"> -->
                    </div>
                    <div class="col-2">
                        <label  class="label-primary">År</label>
                        <div class="form-control">
                        <select class="form-select" id="selectedYearFaktura">
                            <option>2024</option>
                            <option>2025</option>
                            <option>2026</option>
                            <option>2027</option>
                            <option>2028</option>
                            <option>2029</option>
                            <option>2030</option>
                        </select>
                        </div>
                    </div>

                    <div class="col-2">
                        <label  class="label-primary">Skapa fakturor</label>
                        <input type="button" class="btn btn-success " id="btnSkapaFakturaUnderlag" name="skapaFaktura" value="Skapa underlag">
                    </div>
            </div>

                <table id="tblAvisering" class="table table-hover table-striped mt-3">

                    <tr>
                        <th scope="col" class="table-primary">Hyresgäst</th>
                        <th scope="col" class="table-primary">Lägenhet</th>
                        <th scope="col" class="table-primary">Hyra</th> 
                        <th scope="col" class="table-primary">Parkering</th> 
                        <th scope="col" class="table-primary">Totalt</th> 
                        <th scope="col" class="table-primary">Faktura</th>
                    </tr>
                    <?php $totalHyra = 0;?>
                    <tbody>

                        <?php 
                            foreach($fakturor as $row)
                            {
                                $avgift = $row["avgift"] == null ? "0" : $row["avgift"];
                                $total = $avgift + $row["hyra"];

                                $lnkPdf = "/bilder/pdf-file.png";
                                $theFaktura = $row["faktura"];
                                $totalHyra += intval($row["hyra"]);

                                echo 
                                "<tr>
                                    <td>" . $row['fnamn'] . " " . $row['enamn']  .  "</td>
                                    <td>" . $row['lagenhet_nr'] .  "</td>
                                    <td>" . $row['hyra'] .  "</td>
                                    <td>" . $row['avgift']  .  "</td>
                                    <td>" . $total .  "</td>";
                                    
                                    if ($theFaktura != null ){
                                        echo 
                                        "<td>
                                            <a href='visafaktura.php?fakturaId=" . $row["faktura_id"] . "'>
                                                <div style='height:100%;width:100%'>
                                                    <img src= .$lnkPdf  ></a>
                                                </div>
                                        </td>";
                                        

                                    } else {
                                        echo "<td></td>";
                                    }
                                        
                                echo "</tr>";
                            }
                        ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="row">Total hyra</th>
                                <td>Perioden : <strong><?php echo $totalHyra ?></strong></td>
                            </tr>
                    </tfoot>
                </table>
                <form  action="./code/createpdf.php" method="post" enctype="multipart/form-data">
                    <input type="submit" value="Skapa PDF" id="btnPdf" class="btn btn-success" ></input>
                </form>
                
            </div>
        </body>
</html>