<?php 
    if (!isset($_SESSION)) { session_start(); }
    include_once "./config.php";
    include_once "./dbmanager.php";

    $jobhour = $_POST['job_hour'];
    $savedBy = $_POST['HidClickedUserName'];
    $jobdate = $_POST['job_date'];
    $jobfastighet = $_POST['job_fastighet'];
    $jobdescription = $_POST['job_description'];
    $jobusername = $_SESSION['username'];

    if (strlen($savedBy) > 0){
        //Update
        $db = new DbManager();
        $jobId = $_POST['HidClickedJobId'];
        $db->update_jobid($jobId, $jobdate, $jobhour, $jobfastighet, $jobdescription);
    } else{
        //Save
        $sql = "INSERT INTO tidlog_jobs (job_date, job_hour, job_fastighet, job_description, job_username)";
        $sql .= "VALUES (?, ?, ?, ?, ?)";

        $stmt = $link->prepare($sql);
        $stmt->bind_param("sssss", $jobdate, $jobhour,$jobfastighet, $jobdescription,$jobusername);
        $stmt->execute();
        $stmt->close();
    }

    // header("Location: ../avimeddelande.php?page=1&fastighetId=".$fastighetId  );
    header("Location: ../index.php");
?>