<?php
    if (!isset($_SESSION)) { session_start(); }
    require_once "./code/managesession.php";
    require_once "./code/dbmanager.php";

    $user = $_SESSION['username'];

    $db = new DbManager();
    //$usrImg = $db->get_user_image($user);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Inställningar</title>
    </head>

    <body>
        <?php include("./pages/sidebar.php") ?>

        <div class="col-sm  min-vh-100 border">
            <h2>Inställningar för ditt konto <strong><?= htmlspecialchars($_SESSION["username"]); ?></strong></h2>
            <hr />
            <div class="container mt-4 ">

                <div class="container py-5">
                    <div class="col-6">
                        <div class="card card-outline-secondary">
                            <div class="card-header">
                                <h3 class="mb-0">Hantera lösenord</h3>
                                <div class="card-body">
                                    <form class="form" role="form" autocomplete="off" method="POST" action="util.php?user=anders&pwd=nisse">
                                        <div class="form-group">
                                            <label for="lblChangePwd" class="form-control-sm">Nuvarande lösenord</label>
                                            <input type="password" class="form-control" id="idCurrentPassword"></input>
                                            <label for="lblChangePwd" class="form-control-sm">Nytt Lösenord</label>
                                            <input type="password" class="form-control" id="idNewPassword"></input>
                                            <input type="button" class="button btn-success mt-2" id="btnChange" onclick="ChangePassword(<?php echo $_SESSION['username'] ?>);" value="Ändra Lösenord"></input>
                                            <hr />
                                            <label for="lblChangePwd" class="form-control-sm">Min bild</label>
                                            <!-- <img src='data:image;base64,".base64_encode($row["image"])."' style='height:180px;width:200px;margin-left:22px;' </img> -->
                                            <?php 
                                            
                                                //echo '<img src="data:image/jpeg;base64,' . base64_encode($usrImg['Media']) . '" alt="Uploaded Image">';
                                            ?>
                                        </div>
                                    </form>
                                    <form id="frmUploadImage" action="./code/upload.php" method="post" enctype="multipart/form-data">
                                        <label>Välj en profilbild:</label>
                                        <input type="file" name="image" id="fileData" accept="image/*">
                                        <input type="submit" name="submit" value="Ladda upp" id="btnUpladImage">
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                </div>
                
    

                <!-- <div class="row" >
                    <label for="lblChangePwd" class="form-control-lg">Ändra lösenord</label>
                </div>
                <div class="row row-cols-2">
                    <div class="col border ">
                        <label for="lblUserName" class="form-control-sm">Nuvarande lösenord</label>
                        <input type="text" class="form-control-sm"></input>
                    </div>
                </div>
                <div class="row row-cols-2">
                    <div class="col">
                        <label for="lblUserName" class="form-control-sm">Nytt lösenord</label>
                        <input type="text" class="form-control-sm"></input>
                        <input type="button" id="btnChangePassword" class="btn btn-warning btn-send " value="Ändra">
                    </div>
                </div>
            </div> -->
        </div>
    </body>
    <script>
        $(document).ready(function(e) {
            $("#btnChange").on('click', function(){

                var usr = "<?php echo $_SESSION['username'] ?>"
                var oldPassword, newPassword;
                
                oldPassword = $("#idCurrentPassword").val();

                var old_pwd_ok = checkCurrentPassword(usr, oldPassword);

                if (!oldPassword){
                    alert('Du har angivit ett felaktigt befintligt lösenord. Testa igen.');
                    return;
                }

                ChangePassword(usr);
            });

            $("#frmUploadImage").on('submit', function(e){
                e.preventDefault();
                
                $.ajax({
                    type: 'POST',
                    url: './code/Upload.php',
                    dataType: 'json',
                    data: new FormData(this), contentType: false,
                        cach: false,
                        processData: false,

                    success: function(data){
                        alert('ok');
                    }

                });
                
            });

            // $("#btnUpladImage").on('click', function (){
            //     event.preventDefault();

            //     $.ajax({
            //         type: 'POST',
            //         url: './code/Upload.php',
            //         dataType: 'json',
            //         data: $(this).closest("form").serialize(),

            //         success: function (){
            //             alert('ok');
            //         }
            //     });
            // });
        });
        
    </script>
</html>