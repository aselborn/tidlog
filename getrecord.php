<?php 

    include_once "./config.php";
    include_once "./dbmanager.php";
    

    $jobId = $_POST['jobId'];
    $form_data = array();

    $db = new DbManager();
    $data = $db->query("select * from tidlog_jobs where jobId = ? ", array($jobId))->fetchAll();

    foreach ($data as $row) {
        $dtdat = date_create($row["job_date"]);
        $dt = date_format($dtdat,"Y-m-d");

         $form_data["jobId"] = $row["JobId"];
         $form_data["job_date"] = $dt;
         $form_data["job_hour"] = $row["job_hour"];
         $form_data["job_fastighet"] = $row["job_fastighet"];
         $form_data["job_description"] = $row["job_description"];
    }

    echo json_encode($form_data);

?>