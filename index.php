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
    
    <input type="hidden" id="hidUserName" name="HidUsername" value="<?php echo $_SESSION["username"]?>">
    
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <label class="label-primary form-label">Utförda jobb av
                    <strong><?= htmlspecialchars($_SESSION["username"]);?></strong> </label>
            </div>

            <div class="row">
                <div class="col">
                    <table class="table" id="jobTable">
                        <thead>Tidlogg</thead>
                        <th>Datum</th>
                        <th>Timmar</th>
                        <th>Beskrivning</th>
                        <tbody>
                        <?php 
                          $db = new DbManager();
                          $data = $db->query("select * from users")->fetchAll();
                          for ($i = 1; $i < 10; $i++) {
                            echo "<tr>" . "<td>2020-01-01</td> <td>2</td> <td>en kommentar</td>" . "</tr>\n";
              
                          }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <hr />
            <form action="addtime.php" method="POST" id="frmInput">
                <div class="row">

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
                    <div class="col-md-12 mt-4">
                        <input type="submit" class="btn btn-success btn-send" value="Spara.">
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
   
</body>

<script>
$(document).ready(function() {
   
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

        addToTable(data);

    });

    event.preventDefault();
  });

});
</script>

</html>