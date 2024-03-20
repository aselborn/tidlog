<?php
      if (!isset($_SESSION)) { session_start(); }
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";
      
    //   if (!isset($_GET['page'])) 
    //   {
    //       $page = 1;
    //   } else {
    //       $page = $_GET['page'];
    //   }

       $db = new DbManager();
       $yr = 2024;
       $mn = 3;

       $hyresdata = $db->query(
        "
            select th.fnamn, th.enamn ,  tf.fakturanummer , tf.faktura_month , tf.faktura_year ,
            tl.hyra , tp.avgift , tl.lagenhet_nr, th.hyresgast_id, tf.faktura_id
            from tidlog_lagenhet tl
              inner join tidlog_hyresgaster th on tl.hyresgast_id = th.hyresgast_id 
              inner join tidlog_faktura tf on tf.hyresgast_id =th.hyresgast_id 
              left outer join tidlog_parkering tp on tp.park_id = tl.park_id
       where tf.faktura_year = ? and tf.faktura_month = ? and tf.faktura is not null 
       ", array($yr, $mn))->fetchAll();
    //   $result_per_page = 12;

    //   $page_first_result = ($page - 1) * $result_per_page;
    //   $num_rows = $db->getLagenhetCount();
    //   $number_of_page = ceil($num_rows / $result_per_page);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Hyreskoll</title>
    </head>

    <body>
        <input type="hidden" id="hidUserName" name="HidUsername" value="<?php echo $_SESSION["username"] ?>">
        <?php include("./pages/sidebar2.php") ?>

            <div class="container ">
                <h2>Kontroll av inkommande hyra</h2>
                <hr />
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

                    <div class="col-2">
                        <label  class="label-primary">Fastighet</label>
                        <div class="form-control">
                        <select id="fastighetId" class="form-select" name="job_fastighet">
                            <option value="1">T7</option>
                            <option value="2">U9</option>
                        </select>
                        </div>
                    </div>
                   

            </div>

            <div class="row mt-2">
                <table class="table table-hover table-striped mt-3" id="tblHyreskoll">
                    <thead>
                        <tr>
                            <th>Lägenhet</th>
                            <th>Hyresgäst</th>
                            <th>Aktuell hyra</th>
                            <th>Parkering</th>
                            <th>Belopp inbetalt</th>
                            <th>Datum inbetalt</th>
                            <th>Skillnad</th>
                            <th>Spara</th>
                            <th>Registrerad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($hyresdata as $row) 
                            {
                                $hyresgastId = $row["hyresgast_id"];
                                $lagenhetNo = $row["lagenhet_nr"];
                                $hyresgast = $row["fnamn"] . " " . $row["enamn"];
                                $hyra = $row["hyra"];
                                $park = $row["avgift"];
                                $fakturaId = $row["faktura_id"];
                                $dt = date_format(new DateTime(), "Y-m-d");

                                echo 
                                "
                                    <tr id='$hyresgastId'>
                                        <td>
                                            $lagenhetNo 
                                        </td>
                                        <td>
                                            $hyresgast  
                                        </td>
                                        <td>
                                            <label id='lblHyra" . $hyresgastId . "' >$hyra</label>
                                        </td>
                                        <td>
                                        <label id='lblPark" . $hyresgastId . "' >$park</label>
                                        </td>
                                        <td>
                                            <input type='number' style='width:100px' class='binderBelopp' id='$hyresgastId' />
                                        </td>
                                        <td>
                                            <input type='date'  value='$dt' id='dtInbetald" . $hyresgastId . "' />
                                        </td>
                                        <td>
                                            <label id='lblDiff" . $hyresgastId . "'  ><strong></strong></label>
                                        </td>
                                        <td>
                                            <input type='button' id='btnSparaInbetalning" . $hyresgastId . "' value='Spara' 
                                            faktura='" .$fakturaId . "' hyresgast='" . $hyresgastId . "' name='spara_inbetalning' 
                                            class='btn btn-sm btn-outline-success  btn-sm rounded-5 binderSpara binderHyreskoll' disabled>
                                        </td>
                                       
                                    </tr>
                                ";
                            }
                        ?>
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>

        
    </body>
</html>