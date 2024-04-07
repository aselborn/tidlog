<?php 
    // header('Location:'.$_SERVER['SERVER_NAME'].'/extrafaktura.php');

    if (!isset($_SESSION)) { session_start(); }
    include_once "./config.php";
    include_once "./dbmanager.php";

    $db = new DbManager();

    $hyresgastId = $_POST['hyresgast'];
    $fastighetId = $_POST['HidFastighetId'];

    $alla = $_POST['allahyresgaster'];
    $fran = $_POST['giltlig_fran'];
    $till = $_POST['giltlig_till'];
    $meddelande = $_POST['meddelande_hyresgast'];

    $hyresgaster = $db->query(
        "select th.hyresgast_id, th.fnamn , th.enamn  from tidlog_hyresgaster th 
            inner join tidlog_lagenhet tl on tl.hyresgast_id  = th.hyresgast_id 
            where tl.fastighet_id = ? and adress != 'Lokal'
            ", array($fastighetId))->fetchAll();
    

    if ($alla == 1)
    {
        foreach($hyresgaster as $row)
        {
            $sql = "INSERT INTO tidlog_meddelande ( meddelande, hyresgast_id, giltlig_fran, giltlig_till)
            VALUES(?, ?, ?, ?);";
        
            $stmt = $link->prepare($sql);

            $stmt->bind_param("ssss", $meddelande, $row["hyresgast_id"],$fran, $till);
            $stmt->execute();
            $stmt->close();
        }

        

        
        

    
    }

    header("Location: ../avimeddelande.php?page=1&fastighetId=".$fastighetId  );
?>