<?php
# Initialize the session
if (!isset($_SESSION)) { session_start(); }

require_once "./code/managesession.php";
require_once "./code/dbmanager.php";
// require('./pages/depends.html');

if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

$db = new DbManager();
$result_per_page = 12;

$page_first_result = ($page - 1) * $result_per_page;
$num_rows = $db->getRowCount();


$number_of_page = ceil($num_rows / $result_per_page);

?>
<!DOCTYPE html>
<html>
    
    <title>Tidsregistrering</title>
    <body>
        <?php require('./pages/sidebar.php'); ?>;

        <input type="hidden" id="hidUserName" name="HidUsername" value="<?php echo $_SESSION["username"] ?>">

        <div class="main">
            <div class="container-fluid mt-4" >

                <div class="row mt-2">
                    <div class="d-inline-flex">
                        <h3>Tidsregistrering för <strong><?=  htmlspecialchars($_SESSION["username"]); ?></strong> </label></h3>
                    </div>
                </div>
                <div class="row ">

                        <div class="col">
                            <table class="table table-sm  table-hover" id="jobTable">
                                <thead class="bg-light sticky-top top-0">
                                    <tr>
                                        
                                        <th scope="col" style="width: 120px;" class="table-primary">Datum</th>
                                        <th scope="col" style="width: 120px;" class="table-primary">Utfört av</th>
                                        <th scope="col" class="table-primary">Timmar</th>
                                        <th scope="col" class="table-primary">Fastighet</th>
                                        <th scope="col" class="table-primary">Beskrivning</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    //Läser data ur databas.

                                    //$data = $db->query("select * from jobs where job_username = ? order by job_date desc ", array($_SESSION["username"]))->fetchAll();
                                    $data = $db->query("select * from tidlog_jobs order by job_date desc LIMIT " . $page_first_result . ',' . $result_per_page)->fetchAll();
                                    $lnk = "./bilder/clock.png";
                                    foreach ($data as $row) {
                                        $dtdat = date_create($row["job_date"]);
                                        $dt = date_format($dtdat, "Y-m-d");
                                        $jobId = $row["JobId"];

                                        $jobHour = str_replace(".0", "", $row["job_hour"]);

                                        echo "
                                            <tr id='$jobId' >
                                                
                                                <td style='width: 100px;'>" . $dt . "</td>
                                                <td>". $row["job_username"] . "</td>
                                                <td>". $jobHour  . "</td>
                                                <td>". $row["job_fastighet"] . "</td>
                                                <td>". $row["job_description"] . "</td>
                                            </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    <!--formulär för inmatning-->
                    <form method="POST" action="./code/timereg.php">
                        <div class="row mt-1">
                            <input type="hidden" id="hidClickedUserName" name="HidClickedUserName" value="">
                            <input type="hidden" id="hidClickedJobId" name="HidClickedJobId" value="">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label id="lblDatum" class="label-primary">Datum</label>
                                    <input id="job_date" type="date" name="job_date" class="form-control" placeholder="Ange datum" value="<?php echo date('Y-m-d'); ?>" required="required" data-error="Datum måste anges.">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label id="lblTimmar" class="label-primary">Timmar</label>
                                    <select id="job_hour" class="form-select" name="job_hour">
                                        <option value="0.5">0.5</option>
                                        <option value="1">1</option>
                                        <option value="1.5">1.5</option>
                                        <option value="2">2</option>
                                        <option value="2.5">2.5</option>
                                        <option value="3">3</option>
                                        <option value="3.5">3.5</option>
                                        <option value="4">4</option>
                                        <option value="4.5">4.5</option>
                                        <option value="5">5</option>
                                        <option value="5.5">5.5</option>
                                        <option value="6">6</option>
                                        <option value="6.5">6.5</option>
                                        <option value="7">7</option>
                                        <option value="7.5">7.5</option>
                                        <option value="8">8</option>
                                        <option value="8.5">8.5</option>
                                        <option value="9">9</option>
                                        <option value="9.5">9.5</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label id="lblFastighet" class="label-primary">Fastighet</label>
                                    <select id="job_fastighet" class="form-select" name="job_fastighet">
                                        <option value="T7">T7</option>
                                        <option value="U9">U9</option>
                                        <option value="Annat">Annan verksamhet</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="form_message">Beskrivning</label>
                                    <textarea id="job_description" name="job_description" class="form-control" placeholder="Ange en beskrivning" rows="3" required="required" data-error="Vänligen beskriv vad du gjort"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>
                            <div class="col-md-5 mt-4 ">
                                <input type="submit" id="btnSparaTidReg" class="btn btn-primary btn-send" value="Spara">
                                <input type="submit" id="btnNew" class="btn btn-primary btn-send disabled" value="Registrera ny">
                                <input type="button" id="btnDelete" class="btn btn-warning btn-send disabled" value="Radera">

                            </div>
                            <div class="col-md-3 mt-4 ">
                                <label id="lblMissingData" class="text-danger form-label invisible">Data saknas, kan inte spara.</label>
                            </div>
                            <!-- <div class="col-md-4 mt-4 text-end ">

                                <input type="button" id="btnLogOut" class="btn btn-primary btn-send float-right" value="Logga ut">
                            </div> -->
                        </div>

                    </form>
                    <div class="mt-3">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <?php
                                $pageLink = "";

                                $total_pages = ceil($num_rows / $result_per_page);

                                if ($total_pages > 1) {

                                    if ($page >= 2) {
                                        echo "<li class='page-item'><a class='page-link' href='index.php?page=" . ($page - 1) . "'>Föregående</a></li>";
                                    }
                                    for ($i = 1; $i <= $total_pages; $i++) {
                                        if ($i == $page) {
                                            echo "<li class='page-item active'><a class='page-link' href='index.php?page=" . $i . "'>" . $i . "</a></li>";
                                        } else {
                                            echo "<li class='page-item'><a class='page-link' href='index.php?page=" . $i . "'>" . $i . "</a></li>";
                                        }
                                    }

                                    if ($total_pages > $page) {
                                        echo "<li class='page-item'><a class='page-link' href='index.php?page=" . ($page + 1) . "'>Nästa</a></li>";
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