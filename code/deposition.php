<?php

    if (!isset($_SESSION)) { session_start(); }
    include_once "./config.php";
    include_once "./dbmanager.php";


    $db = new DbManager();

    $hyresgastId = $_POST['hdHyresgast'];
    $depositionId = $_POST['hdDepositionid'];

    //SPARA ny deposition.
    if ($depositionId == 0)
    {
        //Spara ny
        $belopp = intval($_POST["deposition_belopp"]);
        $depositionDatum = $_POST["deposition_datum"];

        $hyresgastId = $_POST['hdHyresgast'];
        $lagenhetId = $_POST['hdLagenhetId'];
        $kommentar = $_POST['deposition_kommentar'];

        $db->spara_deposition($hyresgastId, $depositionDatum, $belopp, $lagenhetId, $kommentar);

    } 
    if ($depositionId != 0)
    {

        $beloppAter = intval ($_POST['deposition_ater_belopp']);
        $depositionAterDatum = $_POST['deposition_ater_datum'];
        $hyresgastId = $_POST['hdHyresgast'];
        $lagenhetId = $_POST['hdLagenhetId'];
        $depositionId = $_POST['hdDepositionid'];
        $kommentar = $_POST['deposition_ater_kommentar'];
        
        $db->uppdatera_deposition($depositionId, $depositionAterDatum, $beloppAter, $kommentar);
        

    }

    header("Location: ../hyrginfo.php?hyresgast_id=".$hyresgastId  );
?>
