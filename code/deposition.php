<?php
if (!isset($_SESSION)) { session_start(); }
include_once "./config.php";
include_once "./dbmanager.php";


$db = new DbManager();

$hyresgastId = $_POST['hdHyresgast'];


//SPARA ny deposition.
if ($_POST["spara_deposition"] == "Spara ny deposition")
{
    //Spara ny
    $belopp = intval($_POST["deposition_belopp"]);
    $depositionDatum = $_POST["deposition_datum"];

    $hyresgastId = $_POST['hdHyresgast'];
    $lagenhetId = $_POST['hdLagenhetId'];
    $kommentar = $_POST['deposition_kommentar'];

    $db->spara_deposition($hyresgastId, $depositionDatum, $belopp, $lagenhetId, $kommentar);

} 
if ($_POST["uppdatera_deposition"] == "Uppdatera deposition")
{

    $beloppAter = intval ($_POST['deposition_ater_belopp']);
    $depositionAterDatum = $_POST['deposition_ater_datum'];
    $hyresgastId = $_POST['hdHyresgast'];
    $lagenhetId = $_POST['hdLagenhetId'];
    $depositionId = $_POST['hdDepositionid'];
    $kommentar = $_POST['deposition_ater_kommentar'];
    
    $db->uppdatera_deposition($depositionId, $depositionDatum, $beloppAter, $kommentar);
    

};

//UPPDATERA deposition.


header("Location: ../hyrginfo.php?hyresgast_id=".$hyresgastId  );
?>
