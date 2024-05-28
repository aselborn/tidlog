<?php
if (!isset($_SESSION)) { session_start(); }
include_once "./config.php";
include_once "./dbmanager.php";




$hyresgastId = $_POST['hdHyresgast'];

if ($_POST["spara_deposition"] == "Spara ny deposition")
{
    //Spara ny
    $belopp = intval($_POST["deposition_belopp"]);
    $depositionDataum = $_POST["deposition_datum"];
} 


header("Location: ../hyrginfo.php?hyresgast_id=".$hyresgastId  );
?>
