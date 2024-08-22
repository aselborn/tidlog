<?php 
    if (!isset($_SESSION)) { session_start(); }
    require_once "config.php";
    require_once "dbmanager.php";
    require_once "managesession.php";

    $dbM = new DbManager(); 

    $user = $_SESSION["username"];
    
    if ($user == null){
        echo "<script>location.href='../index.php';</script>"; 
        return;
    }
    
    $datum = $_POST["dtFom"];
    $dtTom = null;
    if (isset($_POST["dtTom"])){
        $dtTom = $_POST["dtTom"];
    }

    if (isset($_GET['fastighetId'])){
        $fastighetid = $_GET['fastighetId'];
    }

    

    if(isset($_POST["sparakontrakt"]) || isset($_POST['spara_gammalt_kontrakt'])){ 
        $status = 'error'; 
        
        $isNyttKontrakt = isset($_POST["sparakontrakt"]);

        if(!empty($_FILES["pdfkontrakt"]["name"])) { 
            // Get file info 
            $fileName = basename($_FILES["pdfkontrakt"]["name"]); 
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
             
            // Allow certain file formats 
            $allowTypes = array('pdf','PDF'); 
            if(in_array($fileType, $allowTypes)){ 
                $pdf = $_FILES['pdfkontrakt']['tmp_name']; 
                $pfdContent = addslashes(file_get_contents($pdf)); 
             
                // Insert image content into database 
                //$insert = $db->query("UPDATE tidlog_jobs SET tidlog(image, created) VALUES ('$imgContent', NOW())"); 
                if ($isNyttKontrakt){
                    $hyresgastId = $_POST["hdHyresgast"];
                    $lagenhetid = $_POST["hdLagenhetId"];
                    $lagenhetNo = $_POST["hdLagenhetNo"];
                    $fnamn = $_POST["hdFnamn"];
                    $enamn = $_POST["hdEnamn"];

                    $insert= $dbM->insert_new_kontrakt($lagenhetid, $hyresgastId, $datum, $pfdContent, $fnamn, $enamn);

                } else {
                    $lagenhetid = $_POST['lagenhet'];
                    $lagenhetNo = $dbM->GetLagenhetNoFromLagenhetId($lagenhetid);
                    $typ_av_kontrakt = $_POST['typ_av_kontrakt'];
                    $fnamn = $_POST["fnamn"];
                    $enamn = $_POST["enamn"];
                    
                    $insert = $dbM->insert_old_kontrakt($typ_av_kontrakt,$lagenhetid, $datum, $dtTom, $pfdContent, $fnamn, $enamn);
                }
                

                if($insert){ 
                    $status = 'success'; 
                    $statusMsg = "Filen laddades upp."; 
                }else{ 
                    $statusMsg = "Filen kunde inte laddas upp"; 
                }  
            }else{ 
                $statusMsg = 'Endast PDF:er'; 
            } 
        }else{ 
            $statusMsg = 'Välj fil att ladda upp!'; 
        } 
    } 
     
    // Display status message 
    //echo $statusMsg;
    if ($isNyttKontrakt)
        header("Location: ../hyrginfo.php?hyresgast_id=" . $hyresgastId ); // redirect to login page
    else
        header("Location: ../kontrakt.php?page=1&fastighetId=" . $fastighetid ); // redirect to login page
?>
