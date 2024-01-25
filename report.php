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
      
      $result_per_page = 10;
      $page_first_result = ($page - 1) * $result_per_page;
      $num_rows = $db->getRowCountForUser($user);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Sammanställning</title>
        
    </head>

    <body>
        <?php include("./pages/sidebar.php") ?>

        <div class="col-sm  min-vh-100 border">
            <h2>Sammanställning för användare : <strong><?= htmlspecialchars($_SESSION["username"]); ?></strong></h2>
            <hr />
            <div class="container border" >
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
                            

                            foreach ($data as $row) {
                                $dtdat = date_create($row["job_date"]);
                                $dt = date_format($dtdat, "Y-m-d");
                                $jobId = $row["JobId"];


                                echo "<tr id='$jobId' ><td>" . $dt . "</td><td>"
                                    . $row["job_hour"] . "</td><td>"
                                    . $row["job_fastighet"] . "</td><td>"
                                    . $row["job_description"] . "</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
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