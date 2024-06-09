<?php 

# If user is not logged in then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
    echo "<script>" . "window.location.href='./logon.php';" . "</script>";
    exit;
  }
  
  //Kolla om sessionen löpt ut...
  if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 900) {
    // last request was more than 15 minutes ago
    session_unset(); // unset $_SESSION variable for the run-time
    session_destroy(); // destroy session data in storage
    header("Location: logon.php"); // redirect to login page
  }
  $_SESSION['last_activity'] = time(); // update last activity time stamp
  
  

?>