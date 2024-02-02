<?php
      if (!isset($_SESSION)) { session_start(); }
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";
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
            <div class="container border" >
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
                        <table class="table table-hover table-striped " id="jobTable">
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

                            //$data = $db->query("SELECT * from tidlog_fastighet") ;
                            

                            // foreach ($data as $row) {
                            //     $dtdat = date_create($row["job_date"]);
                            //     $dt = date_format($dtdat, "Y-m-d");
                            //     $jobId = $row["JobId"];


                            //     echo "<tr id='$jobId' ><td>" . $dt . "</td><td>"
                            //         . $row["job_hour"] . "</td><td>"
                            //         . $row["job_fastighet"] . "</td><td>"
                            //         . $row["job_description"] . "</td></tr>";
                            //}
                            ?>
                         </tbody>
                        </table>
                    </div>
                    <div class="mt-1">
                        <form action="addtime.php" method="POST" id="frmInput">
                            
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
                            
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </body>
</html>