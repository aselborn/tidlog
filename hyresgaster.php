<?php
      if (!isset($_SESSION)) { session_start(); }
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";

      
  
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
                        <select id="job_fastighet" class="form-select" name="job_fastighet">
                            <option value="T7">T7</option>
                            <option value="U9">U9</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <table class="table table-hover table-striped " id="jobTable">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="table-primary">Namn</th>
                                    <th scope="col" class="table-primary">Lägenhet Nr</th>
                                    <th scope="col" class="table-primary">Telefon</th>
                                    <th scope="col" class="table-primary">Epost</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                            //Läser data ur databas.

                            //$data = $db->query("SELECT * from tidlog_jobs WHERE job_username = ? Order by job_date DESC LIMIT " .$page_first_result . "," .$result_per_page , array($user))->fetchAll() ;
                            

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
                    <div class="mt-3">
                        
                    </div>
                    </div>
                </div>
            </div>
        </body>
</html>