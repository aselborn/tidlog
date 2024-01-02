<?php
# Initialize the session
$isSession = session_start();

require_once "./managesession.php"

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User login system</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/main.css">
  <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon">
</head>

<body>
  <div class="container mt-4">
    <div class="row">
      <div class="col">
        <label class="label-primary form-label">Utförda jobb.</label>
      </div>
      <hr />
      <!-- <div class="col-4 border">.col-4<br>Since 9 + 4 = 13 &gt; 12, this 4-column-wide div gets wrapped onto a new line as one contiguous unit.</div>
      <div class="col-6 border">.col-6<br>Subsequent columns continue along the new line.</div> -->

    <div class="row">
      <div class="col">
        <table class="table">
          <thead>Tidlogg</thead>
          <th>Datum</th>
          <th>Timmar</th>
          <th>Beskrivning</th>
          <?php 
          
            for ($i = 1; $i < 10; $i++) {
              echo "<tr>" . "<td><span class=align-middle>middle</span></td> <td><span class=align-middle>2</span></td> <td>en kommentar</td>" . "</tr>";
              
            }
          ?>
        </table>
      </div>
    </div>

    </div>
  </div>
    <!-- <div class="alert alert-success my-5">
      Welcome ! You are now signed in to your account.
    </div>
    
    <div class="row justify-content-center">
      <div class="col-lg-5 text-center">
        <img src="./img/blank-avatar.jpg" class="img-fluid rounded" alt="User avatar" width="180">
        <h4 class="my-4">Hello, <?= htmlspecialchars($_SESSION["username"]); ?></h4>
        
        <a href="./logout.php" class="btn btn-primary">Logga ut</a>
      </div>
    </div>
  </div> -->
</body>

</html>