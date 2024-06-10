<?php
    //Registrera inbetalning!
    if (!isset($_SESSION)) { session_start(); }
    require_once "dbmanager.php";
    require_once "managesession.php";


    $data = json_decode( $_POST['inbet'], true);

    $db = new DbManager();

    foreach($data as $item){
        
        $faktId = $item["fakturaId"];
        $summa = $item["radSumma"];
        $dtInbet =  date('Y-m-d', strtotime($item["datum"]));

        $db->registrera_inbetalning($faktId, $summa, $dtInbet);
        
    }

    echo json_encode(['reg_inbet' => 'true']);

?>