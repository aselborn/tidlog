<?php
if (!isset($_SESSION)) { session_start(); }
include_once "./config.php";
include_once "./dbmanager.php";




$hyresgastId = $_POST['hdHyresgast'];

header("Location: ../hyrginfo.php?hyresgast_id=".$hyresgastId  );
?>
