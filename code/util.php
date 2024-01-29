<?php 

if (!isset($_SESSION)) { session_start(); }
    
include_once "config.php";
include_once "dbmanager.php";
require "managesession.php";

    $user = $_SESSION["username"];
    //util.php?user=anders&pwd=nisse
    
    $name_func = $_POST["nameOfFunction"];

    $db = new DbManager();   
    $reply_data = array();

    $pwd = $db->query("select password from tidlog_users where username = ? ", array($user))->fetchAll();
    $encodedPwd = $pwd[0]["password"];
    echo $encodedPwd;

    $user_password = 'kalleanka';

    function filter_report($start, $end, $fastighet)
    {
        //$reply_data("start") = $start;
        $reply_data("end") = $end;
        $reply_data("fastighet") = $fastighet;
        
        echo json_encode($reply_data);
    }
?>