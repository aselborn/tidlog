<?php 

if (!isset($_SESSION)) { session_start(); }
    
include_once "config.php";
include_once "dbmanager.php";
require "managesession.php";

    $user = $_SESSION["username"];
    //util.php?user=anders&pwd=nisse
    $usr = $_POST["user"];
    $pwd = $_POST["pwd"];

    echo $usr;

    $db = new DbManager();   
    

    $pwd = $db->query("select password from tidlog_users where username = ? ", array($user))->fetchAll();
    $encodedPwd = $pwd[0]["password"];
    echo $encodedPwd;

    $user_password = 'kalleanka';

    // if (password_verify($user_password, $encodedPwd))
    // {
    //     echo "\nPassord är ok!";
    // } else {
    //     echo "\nPassord är INTE ok!";
    // }

    //$data = $db->query("Update tidlog_users SET password = ? WHERE userName = ?", array($jobId))->fetchAll();
?>