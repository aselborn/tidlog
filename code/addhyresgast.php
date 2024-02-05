<?php 
    if (!isset($_SESSION)) { session_start(); }
    include_once "./config.php";
    include_once "./dbmanager.php";

    $errors = [];
    $data = [];

    $form_data = array();

    

    if (empty($_POST['lagenhet_id'])) {
        $errors['lagenhet_id'] = 'Lägenhet?';
    }

    if (empty($_POST['fnamn'])) {
        $errors['fnamn'] = 'Förnamn?.';
    }

    if (empty($_POST['enamn'])) {
        $errors['enamn'] = 'Efternamn?.';
    }

    if (empty($_POST['epost'])) {
        $errors['epost'] = 'Epost?.';
    }

    if (empty($_POST['telefon'])) {
        $errors['telefon'] = 'Telefon?.';
    }


    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    } else {
        $data['success'] = true;
        $data['message'] = 'Success!';
    }


    $form_data["lagenhet_id"] = $_POST['lagenhet_id'];
    $form_data["fnamn"] = $_POST['fnamn'];
    $form_data["enamn"] = $_POST['enamn'];
    $form_data["epost"] = $_POST['epost'];
    $form_data["telefon"] = $_POST['telefon'];
    

    $sql = "INSERT INTO tidlog_hyresgaster (lagenhet_id, fnamn, enamn, epost, telefon)";
    $sql .= "VALUES (?, ?, ?, ?, ?)";

    $stmt = $link->prepare($sql);
    $stmt->bind_param("sssss", $lagenhetId, $fnamn,$enamn, $epost,$telefon);

    $lagenhetId=$form_data["lagenhet_id"];
    $fnamn=$form_data["fnamn"];
    $enamn=$form_data["enamn"];
    $epost=$form_data["epost"];
    $telefon=$form_data["telefon"] ;


   
    try {
        

        $stmt->execute();
        $stmt->close();

        //echo  json_encode($form_data);

    } catch (Exception $e) {
        echo json_encode(array('error' => $e->getMessage()));
    }

?>