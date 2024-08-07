<?php
# Initialize session
session_start();

# Check if user is already logged in, If yes then redirect him to index page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == TRUE) {
  echo "<script>" . "window.location.href='./'" . "</script>";
  exit;
}

# Include connection
require_once "./code/config.php";


# Define variables and initialize with empty values
$user_login_err = $user_password_err = $login_err = "";
$user_login = $user_password = "";


# Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty(trim($_POST["user_login"]))) {
    $user_login_err = "Vänligen ange användarnamn eller epostaddress.";
  } else {
    $user_login = trim($_POST["user_login"]);
  }

  if (empty(trim($_POST["user_password"]))) {
    $user_password_err = "Vänligen ange lösenord.";
  } else {
    $user_password = trim($_POST["user_password"]);
  }

  # Validate credentials 
  if (empty($user_login_err) && empty($user_password_err)) {
    # Prepare a select statement
    $sql = "SELECT id, username, password FROM tidlog_users WHERE username = ? OR email = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
      # Bind variables to the statement as parameters
      mysqli_stmt_bind_param($stmt, "ss", $param_user_login, $param_user_login);

      # Set parameters
      $param_user_login = $user_login;

      # Execute the statement
      if (mysqli_stmt_execute($stmt)) {
        # Store result
        mysqli_stmt_store_result($stmt);

        # Check if user exists, If yes then verify password
        if (mysqli_stmt_num_rows($stmt) == 1) {
          # Bind values in result to variables
          mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);

          if (mysqli_stmt_fetch($stmt)) {
            # Check if password is correct
            if (password_verify($user_password, $hashed_password)) {
              $ipAddr = $_SERVER['REMOTE_ADDR'];
              # Store data in session variables
              $_SESSION["id"] = $id;
              $_SESSION["username"] = $username;
              $_SESSION["loggedin"] = TRUE;
              $_SESSION["last_activity"] = time();
              $_SESSION["ip_adress"] = $ipAddr;

              //Logga inlogg!
              $today = new DateTime("now", new DateTimeZone('Europe/Stockholm'));
              $today = $today->format('Y-m-d H:i:s');
              $sqlLog =  "insert into tidlog_inlogg(username, ipadress, logdate) values(?, ?, ?);";

              if ($stmt_sql = mysqli_prepare($link, $sqlLog)) {
                mysqli_stmt_bind_param($stmt_sql, "sss", $username, $ipAddr, $today);
                mysqli_stmt_execute($stmt_sql);
              }

              # Redirect user to index page
              echo "<script>" . "window.location.href='./'" . "</script>";
              exit;
            } else {
              # If password is incorrect show an error message
              $login_err = "Användarnamnet eller lösenordet är felaktigt.";
            }
          }
        } else {
          # If user doesn't exists show an error message
          $login_err = "Felaktigt användarnamn eller lösenord.";
        }
      } else {
        echo "<script>" . "alert('Oops! Något gick fel, prova senare.');" . "</script>";
        echo "<script>" . "window.location.href='./login.php'" . "</script>";
        exit;
      }

      # Close statement
      mysqli_stmt_close($stmt);
    }
  }


  # Close connection
  mysqli_close($link);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tidlog, logga in</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
 
    <style>
        .tryckaren {
            /* background-color: transparent!; */
            background-image: url("./bilder/tryckaren-7.JPG");
            border-radius: 25px;
            background-position: center;
            padding: 20px; 
            background-repeat: no-repeat;
            background-size: cover;
            
        }

        .uttern {
            /* background-color: transparent!; */
            background-image: url("./bilder/uttern-9.JPG");
            background-repeat: no-repeat;
            background-position: center;
            
        }

        .logo-class{

            background-color: transparent!;
            background-image: url("../bilder/t7_logo.png");
            background-repeat: no-repeat;
            border-radius: 50px;
            
        }

    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4 ">
                
                <div class="row min-vh-100 justify-content-center align-items-center ">
                    
                    <div class="col-lg-7 ">
                        <?php
                            if (!empty($login_err)) {
                                echo "<div class='alert alert-danger'>" . $login_err . "</div>";
                            }
                        ?>
                        
                        <div class="form-wrap  rounded p-5 ">
                            <img src="./bilder/t7_logo_3.0.png" alt="center" width="150" height="100" style="align-content: center"; />
                            <h1>Logga in</h1>
                        
                            <!-- form starts here -->
                            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
                                <div class="mb-3">
                                <label for="user_login" class="form-label">Epost eller användarnamn</label>
                                <input type="text" class="form-control" name="user_login" id="user_login" value="<?= $user_login; ?>">
                                <small class="text-danger"><?= $user_login_err; ?></small>
                                </div>
                                <div class="mb-2">
                                <label for="password" class="form-label">Lösenord</label>
                                <input type="password" class="form-control" name="user_password" id="password">
                                <small class="text-danger"><?= $user_password_err; ?></small>
                                </div>
                                <!-- <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="togglePassword">
                                <label for="togglePassword" class="form-check-label">Show Password</label>
                                </div> -->
                                <div class="mb-3">
                                <input type="submit" class="btn btn-primary form-control" name="submit" value="Logga in">
                                </div>
                                <!-- <p class="mb-0">Registrera ett konto ? <a href="./code/register.php">Nytt konto</a></p> -->
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-8 border tryckaren">
                <!-- <div class="row flex-lg-column-reverse ">

                </div> -->
                
            </div>
        </div>
        
    </div>
</body>

</html>