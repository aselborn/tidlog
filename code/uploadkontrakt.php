<?php 
    if (!isset($_SESSION)) { session_start(); }
    require_once "config.php";
    require_once "dbmanager.php";
    require_once "managesession.php";

    $dbM = new DbManager(); 
    $kontraktNamn = $_POST["kontraktNamn"];
    $user = $_SESSION["username"];
    
    
    $datum = $_POST["dtFom"];
    $hyresgastId = $_POST["hdHyresgast"];
    $lagenhetid = $_POST["hdLagenhetId"];
    $lagenhetNo = $_POST["hdLagenhetNo"];

    if(isset($_POST["sparakontrakt"])){ 
        $status = 'error'; 
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
                $insert= $dbM->insert_new_kontrakt($lagenhetid, $hyresgastId, $datum, $pfdContent, $kontraktNamn);
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
    header("Location: ../hyrginfo.php?hyresgast_id=" . $hyresgastId ); // redirect to login page
?>
