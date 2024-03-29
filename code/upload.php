<?php 
    if (!isset($_SESSION)) { session_start(); }
    require_once "config.php";
    require_once "dbmanager.php";
    require_once "managesession.php";

    $dbM = new DbManager(); 
    $user = $_SESSION["username"];

    if(isset($_POST["submit"])){ 
        $status = 'error'; 
        if(!empty($_FILES["image"]["name"])) { 
            // Get file info 
            $fileName = basename($_FILES["image"]["name"]); 
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
             
            // Allow certain file formats 
            $allowTypes = array('jpg','png','jpeg','gif', 'JPG', 'JPEG', 'GIF', 'PNG'); 
            if(in_array($fileType, $allowTypes)){ 
                $image = $_FILES['image']['tmp_name']; 
                $imgContent = addslashes(file_get_contents($image)); 
             
                // Insert image content into database 
                //$insert = $db->query("UPDATE tidlog_jobs SET tidlog(image, created) VALUES ('$imgContent', NOW())"); 
                $insert= $dbM->update_user_image($user, $imgContent);
                if($insert){ 
                    $status = 'success'; 
                    $statusMsg = "File uploaded successfully."; 
                }else{ 
                    $statusMsg = "File upload failed, please try again."; 
                }  
            }else{ 
                $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
            } 
        }else{ 
            $statusMsg = 'Please select an image file to upload.'; 
        } 
    } 
     
    // Display status message 
    echo $statusMsg; 
?>
