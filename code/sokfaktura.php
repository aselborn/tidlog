<?php 
//Denna fil skall söka efter avier som inte är inbetalade.
if (!isset($_SESSION)) { session_start(); }
include_once "config.php";
include_once "dbmanager.php";
require "managesession.php";;



$totalbelopp = $_POST["inbetalt_belopp"];
$fakturaNr = $_POST["faktura_nummer"];
$belopp = $_POST["belopp"];
$efternamn = $_POST["efternamn"];
$lagenhetNo =$_POST["lagenhet"];

$db = new DbManager();



$data = $db->search_faktura($fakturaNr,  $belopp, $efternamn, $lagenhetNo);


$_SESSION["faktura_search"] = $data;

header("Location: ../inbetalning.php?fakturanummer=".$fakturaNr . "&totalbelopp=" .$totalbelopp . "&belopp=".$belopp . "&namn=" . $efternamn . "&lagenhetNo=" . $lagenhetNo);
?>