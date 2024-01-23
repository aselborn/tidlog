<?php
    if (!isset($_SESSION)) { session_start(); }
    require_once "./config.php";
    require_once "./dbmanager.php";
    

    $jobId = $_POST['jobId'];
    $form_data = array();

    if ($jobId == '') {
        header("Location: index.php");
    }

    $db = new DbManager();
    $db->delete_jobid($jobId);

    echo json_encode($form_data);
?>