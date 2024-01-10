<?php
# Initialize the session
$isSession = session_start();

require_once "./managesession.php";
require_once "./dbmanager.php";



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
    
</head>

<body>
    
<!-- <nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item active"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">Next</a></li>
  </ul>
</nav> -->

    <input type="hidden" id="hidUserName" name="HidUsername" value="<?php echo $_SESSION["username"]?>">
    
    <div class="container mt-4">
        <div class="row text-align-center">
        <h2>Registrera jobb nedan</h2>
        </div>
        <div class="row">
            <div class="col">
                <label class="label-primary form-label">Utförda av
                    <strong><?= htmlspecialchars($_SESSION["username"]);?></strong> </label>
            </div>

            <div class="row">
              <div class="col-md-4">
                <label class="label-text">Ange år.</label>
              </div>
            </div>

            <div class="row">

                <div class="col">
                    <table class="table table-hover table-striped" id="jobTable">
                        <thead class="table-dark">Tidlogg</thead>
                        <th scope="col" class="table-primary">Datum</th>
                        <th scope="col"  class="table-primary">Utfört av</th>
                        <th scope="col" class="table-primary">Timmar</th>
                        <th scope="col" class="table-primary">Fastighet</th>
                        <th scope="col" class="table-primary">Beskrivning</th>
                        <tbody>
                        <?php 
                          //Läser data ur databas.
                          $db = new DbManager();
                          $ant_tim = 0;
                          //$data = $db->query("select * from jobs where job_username = ? order by job_date desc ", array($_SESSION["username"]))->fetchAll();
                          $data = $db->query("select * from tidlog_jobs order by job_date desc ")->fetchAll();
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
                        <input type="submit" id="btnSave" class="btn btn-primary btn-send" value="Spara">
                        <input type="button" id="btnNew" class="btn btn-primary btn-send disabled" value="Registrera ny">
                        <input type="button" id="btnDelete" class="btn btn-warning btn-send disabled" value="Radera" >
                    </div>
                    <div class="col-md-4 mt-4 text-end ">
                        <input type="button" id="btnLogOut" class="btn btn-primary btn-send float-right" value="Logga ut">
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
   
</body>

<script>
$(document).ready(function() {
   
    var jobId = "";

    $("#frmInput").submit(function (event) {
    var formData = {
      job_date: $("#job_date").val(),
      job_hour: $("#job_hour").val(),
      job_fastighet: $("#job_fastighet").val(),
      job_description: $("#job_description").val(),
      job_username : $("#hidUserName").val()
    };

    $.ajax({
        type: "POST",
        url: "addtime.php",
        data: formData,
        dataType: "json",
        encode: true,
    }).done(function (data) {
        console.log(data);

        window.location.reload();

    });
    event.preventDefault();

  });

 
  //en användare klickar på en rad. hämta data för den raden.
   $(document).on('click', "#jobTable tbody tr", function(){

      jobId = $(this).closest('tr').attr('id');

      var formdata = {"jobId" : jobId};
      $.ajax({
        type: "POST",
        url: "getrecord.php",
        data: formdata,
        dataType: "json",
        encode: true,
    }).done(function (data) {

        console.log(data);
        $("#job_date").val(data.job_date);
        $("#job_hour").val(data.job_hour) ;
        $("#job_fastighet").val(data.job_fastighet);
        $("#job_description").val(data.job_description)  ;
    });

   });

    //RADERA
    $("#btnDelete").on('click', function(){

        var formdata = {"jobId" : jobId};
        $.ajax({
            type: "POST",
            url: "delete.php",
            data: formdata,
            dataType: "json",
            encode: true,
        }).done(function (data) {

            console.log(data);
            window.location.reload();
        });

    });

   //logga ut
   $("#btnLogOut").on('click', function(e){
        window.location.href = "./logout.php";
   });
   //Markera den rad som användaren klickar på.
   $('table tr').each(function(a,b){

    var jobId = ($(this).attr('id'));

    $(b).click(function(){
         $('table tr').css('background','#ffffff');
         $(this).css('background','#37bade'); //Denna färg sätts.

         $("#btnSave").prop("value", "Uppdatera");

         $("#btnDelete").removeClass('disabled');
         $("#btnDelete").addClass('enabled');

         $("#btnNew").removeClass('disabled');
         $("#btnNew").addClass('enabled');
         
    });

    $("#btnSave").prop("value", "Spara");

    $("#btnDelete").removeClass('enabled');
    $("#btnDelete").addClass('disabled');

    $("#btnNew").removeClass('enabled');
    $("#btnNew").addClass('disabled');

  });

  $("#btnNew").on('click', function(){
    window.location.reload();
  });

});
</script>

</html>