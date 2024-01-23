<?php 
    if (!isset($_SESSION)) { session_start(); }
    include_once "./config.php";
    include_once "./dbmanager.php";

    $errors = [];
    $data = [];

    $form_data = array();

    

    if (empty($_POST['job_date'])) {
        $errors['job_date'] = 'Datum måste anges.';
    }

    if (empty($_POST['job_hour'])) {
        $errors['job_hour'] = 'Tid.';
    }

    if (empty($_POST['job_description'])) {
        $errors['job_description'] = 'Beskrivning.';
    }

    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    } else {
        $data['success'] = true;
        $data['message'] = 'Success!';
    }


    $form_data["job_date"] = $_POST['job_date'];
    $form_data["job_hour"] = $_POST['job_hour'];
    $form_data["job_fastighet"] = $_POST['job_fastighet'];
    $form_data["job_description"] = $_POST['job_description'];
    $form_data["job_username"] = $_POST['job_username'];

    $sql = "INSERT INTO tidlog_jobs (job_date, job_hour, job_fastighet, job_description, job_username)";
    $sql .= "VALUES (?, ?, ?, ?, ?)";

    $stmt = $link->prepare($sql);
    $stmt->bind_param("sssss", $jobdate, $jobhour,$jobfastighet, $jobdescription,$jobusername);

    $jobdate=$form_data["job_date"];
    $jobhour=$form_data["job_hour"];
    $jobfastighet=$form_data["job_fastighet"];
    $jobdescription=$form_data["job_description"];
    $jobusername= $form_data["job_username"];

    $startDate = strtotime(date('Y-m-d', strtotime($jobdate) ) );
    $currentDate = strtotime(date('Y-m-d'));

    try {
        if (strlen($jobdescription) == 0){
            throw new Exception("Du måste ange en arbetsbeskrivning!");
        }

        if ($startDate > $currentDate) {
            throw new Exception("Du kan inte registrera i framtiden.");
        }

        $stmt->execute();
        $stmt->close();
        echo  json_encode($form_data);

    } catch (Exception $e) {
        echo json_encode(array('error' => $e->getMessage()));
    }

?>