<?php
    
    require_once "./config.php";
    require_once "./dbmanager.php";
    

    $jobId = $_POST['JobId'];
    $datum = $_POST['job_date'];
    
    $timma = $_POST['job_hour'];
    $fastighet = $_POST['job_fastighet'];
    $beskrivning = $_POST['job_description'];
    
    $form_data["job_date"] = $_POST['job_date'];
    $form_data["job_hour"] = $_POST['job_hour'];
    $form_data["job_fastighet"] = $_POST['job_fastighet'];
    $form_data["job_description"] = $_POST['job_description'];
    $form_data["job_username"] = $_POST['job_username'];

    if ($jobId == '') {
        header("Location: index.php");
    }

    $db = new DbManager();
    $db->update_jobid($jobId, $datum, $timma, $fastighet, $beskrivning);

    
    echo json_encode($form_data);
?>