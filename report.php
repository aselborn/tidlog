<?php
      if (!isset($_SESSION)) { session_start(); }
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";

      
    if (!isset($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

      $db = new DbManager();
      $user = $_SESSION['username'];
      
      $result_per_page = 12;
      $page_first_result = ($page - 1) * $result_per_page;
      $num_rows = $db->getRowCountForUser($user);
      $total_registrations = $db->total_registrations_for_user($user);

      $allUsers = $db->query("select id, username from tidlog_users")->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Sammanställning</title>
    </head>

    <body>
        <?php include("./pages/sidebar.php") ?>
        <?php echo '<input type="hidden" id="totalRowCount" value="' . htmlspecialchars(strval($total_registrations)) . '" />'."\n";?>    
        <div class="main">
            <div class="container-fluid mt-4" >
                <br>
                <h2>Sammanställning för användare : <strong><?= htmlspecialchars($_SESSION["username"]); ?></strong></h2>
                
                
                
                <div class="row mt-2">
                    <div class="col-10">
                        <div class="d-inline-flex p-1 gap-2">
                        <label for="cbo_job_user"class="label-primary">Användare</label>
                                <select id="cbo_job_user" class="form-select" name="job_user">
                                <?php 
                                     foreach($allUsers as $row)
                                     {
                                         echo "<option value='" .$row["id"] ."'>" .$row["username"].  "</option>";
                                     }
                                ?>
                                </select>
                            <label for="dtFom">Från</label>
                            <input type="text" class="form-control" id="dtFom" ></input>
                            <label for="dtTom">Till</label>
                            <input type="text" class="form-control" id="dtTom" ></input>
                            <label for="job_fastighet" class="label-primary">Fastighet</label>
                                    <select id="job_fastighet" class="form-select" name="job_fastighet">
                                        <option value="T7">T7</option>
                                        <option value="U9">U9</option>
                                        <option value="Alla">Alla</option>
                                    </select>
                            

                            <input type="button" id="btnFilter" class="btn btn-success" value="Filtrera">
                            <strong><label for="lblErrorLabel" class="form-label custom_error" id="lblErrorLabel"></label></strong>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <strong><label class="label-primary" id="lblTotalCount"></label></strong>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <table class="table table-hover table-striped " id="jobTable">
                            <thead class="table-dark">
                                <tr>
                                
                                    <th scope="col" class="table-primary">Datum</th>
                                    <th scope="col" class="table-primary">Timmar</th>
                                    <th scope="col" class="table-primary">Fastighet</th>
                                    <th scope="col" class="table-primary">Beskrivning</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //Läser data ur databas.

                                $data = $db->query("SELECT * from tidlog_jobs WHERE job_username = ? Order by job_date DESC LIMIT " .$page_first_result . "," .$result_per_page , array($user))->fetchAll() ;
                                $timT7 = 0;
                                $timU9=0;
                                $rowCount = 0;

                                $lnk = "./bilder/clock.png";

                                foreach ($data as $row) {
                                    $rowCount++;
                                    $dtdat = date_create($row["job_date"]);
                                    $dt = date_format($dtdat, "Y-m-d");
                                    $jobId = $row["JobId"];

                                    if (strcmp($row["job_fastighet"], "T7") == 0 ){
                                        $timT7 += $row["job_hour"];
                                    } else {
                                        $timU9 +=$row["job_hour"];
                                    }
                                   

                                    echo "
                                        <tr id='$jobId' >
                                            <td>" . $dt . "</td>
                                            <td>". $row["job_hour"] . "</td>
                                            <td>". $row["job_fastighet"] . "</td>
                                            <td>". $row["job_description"] . "</td>
                                        </tr>";
                                }

                                // echo '<input type="hidden" id="totalRowCount" value="' . htmlspecialchars(strval($rowCount)) . '" />'."\n";

                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="row">Totalt timmar</th>
                                    <td>T7 : <strong><?php echo $timT7 ?></strong></td>
                                    <td>U9 : <strong><?php echo $timU9 ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="mt-3" id="navigationDiv">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <?php
                                $pageLink = "";

                                $total_pages = ceil($num_rows / $result_per_page);

                                if ($total_pages > 1) {

                                    if ($page >= 2) {
                                        echo "<li class='page-item'><a class='page-link' href='report.php?page=" . ($page - 1) . "'>Föregående</a></li>";
                                    }
                                    for ($i = 1; $i <= $total_pages; $i++) {
                                        if ($i == $page) {
                                            echo "<li class='page-item active'><a class='page-link' href='report.php?page=" . $i . "'>" . $i . "</a></li>";
                                        } else {
                                            echo "<li class='page-item'><a class='page-link' href='report.php?page=" . $i . "'>" . $i . "</a></li>";
                                        }
                                    }

                                    if ($total_pages > $page) {
                                        echo "<li class='page-item'><a class='page-link' href='report.php?page=" . ($page + 1) . "'>Nästa</a></li>";
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