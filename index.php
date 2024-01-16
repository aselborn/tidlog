<?php
# Initialize the session
$isSession = session_start();

require_once "./managesession.php";
require_once "./dbmanager.php";

    if (!isset ($_GET['page']) ) {  
        $page = 1;  
    } else {  
        $page = $_GET['page'];  
    }  

    $db = new DbManager();
    $result_per_page = 5;

    $page_first_result = ($page-1) * $result_per_page; 
    $num_rows = $db->getRowCount();
    

    $number_of_page = ceil($num_rows / $result_per_page);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User login system</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    
    <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="./js/totable.js"></script>
    
    <script src="./js/index.js"></script>



</head>



<body>

    <input type="hidden" id="hidUserName" name="HidUsername" value="<?php echo $_SESSION["username"]?>">
    <input type="hidden" id="hidClickedUserName" name="HidClickedUserName" value="">
    
    <div class="container mt-4">
        <div class="row text-align-center">
        <h2>Registrera jobb nedan</h2>
        </div>
        <div class="row">
            <div class="col">
                <label class="label-primary form-label">Utförda av
                    <strong><?= htmlspecialchars($_SESSION["username"]);?></strong> </label>
            </div>

            <!-- <div class="row">
                <div class="col-md-6 border">
                    <div class ="d-flex w-25 ">
                        <select id="selYear" class="form-select bg-white  " >
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                    </select>  
                    <button type="input" name="byt" />
                    </div>
                </div>
            </div> -->

            <div class="row mt-4">

                <div class="col">
                    <table class="table table-hover table-striped" id="jobTable">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="table-primary">Datum</th>
                                <th scope="col"  class="table-primary">Utfört av</th>
                                <th scope="col" class="table-primary">Timmar</th>
                                <th scope="col" class="table-primary">Fastighet</th>
                                <th scope="col" class="table-primary">Beskrivning</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                          //Läser data ur databas.
                          
                          $ant_tim = 0;
                          //$data = $db->query("select * from jobs where job_username = ? order by job_date desc ", array($_SESSION["username"]))->fetchAll();
                          $data = $db->query("select * from tidlog_jobs order by job_date desc LIMIT " .$page_first_result. ',' .$result_per_page )->fetchAll();
                          
                          foreach ($data as $row) {
                            $dtdat = date_create($row["job_date"]);
                            $dt = date_format($dtdat,"Y-m-d");
                            $jobId = $row["JobId"];


                            echo "<tr id='$jobId' ><td>".$dt."</td><td>"
                            .$row["job_username"]."</td><td>"
                            .$row["job_hour"]."</td><td>"
                            .$row["job_fastighet"]."</td><td>"
                            .$row["job_description"]."</td></tr>";
                            
                            $ant_tim += $row["job_hour"];

                          }

                          

                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
              <div class="col-6">
                <strong>
                  <label id="lblInfo" class="label-primary">Totalt antal registrerade timmar under <?php echo date('M Y'); ?> : <?php echo $ant_tim ?></label>
                </strong>
              </div>
              <div class="col-6">
                <label id="lblInfo" class="label-primary">Totalt antal registrerade timmar : <?php echo "10" ?></label>
              </div>
            </div>

            
            <form action="addtime.php" method="POST" id="frmInput">
                <div class="row mt-4">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label id="lblDatum" class="label-primary">Datum</label>
                            <input id="job_date" type="date" name="job_date" class="form-control" placeholder="Ange datum"
                                value="<?php echo date('Y-m-d'); ?>" required="required"
                                data-error="Datum måste anges.">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label id="lblTimmar" class="label-primary">Timmar</label>
                            <select id="job_hour" class="form-select" name="job_hour">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
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
                            </select>
                        </div>
                    </div>
                </div>
                <!--Ny-->

                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label for="form_message">Beskrivning</label>
                            <textarea id="job_description" name="job_description" class="form-control"
                                placeholder="Ange en beskrivning" rows="6" required="required"
                                data-error="Vänligen beskriv vad du gjort"></textarea>
                            <div class="help-block with-errors"></div>
                        </div>

                    </div>
                    <div class="col-md-8 mt-4">
                        <input type="button" id="btnSave" class="btn btn-primary btn-send" value="Spara">
                        <input type="button" id="btnNew" class="btn btn-primary btn-send disabled" value="Registrera ny">
                        <input type="button" id="btnDelete" class="btn btn-warning btn-send disabled" value="Radera" >
                    </div>
                    <div class="col-md-4 mt-4 text-end ">
                        <input type="button" id="btnLogOut" class="btn btn-primary btn-send float-right" value="Logga ut">
                    </div>
                </div>
            </form>
            
        <div class="mt-3">
        <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php
                        $pageLink = "";
                        
                        $total_pages = ceil( $num_rows / $result_per_page );

                        if ($total_pages > 1){
                            
                            if ($page>=2){
                                echo "<li class='page-item'><a class='page-link' href='index.php?page=" .($page -1) . "'>Föregående</a></li>";
                            }
                            for ($i=1; $i<=$total_pages; $i++) {
                                if ($i == $page){
                                    echo "<li class='page-item active'><a class='page-link' href='index.php?page=" .$i . "'>" .$i . "</a></li>";
    
                                } else{
                                    echo "<li class='page-item'><a class='page-link' href='index.php?page=" .$i . "'>" .$i . "</a></li>";
                                }
                            }
    
                            if ($total_pages > $page ){
                                echo "<li class='page-item'><a class='page-link' href='index.php?page=" .($page +1) . "'>Nästa</a></li>";
                            }
                        }
                    ?>
                </ul>
              
            </nav>
        </div>
    </div>
    
   
</body>



</html>