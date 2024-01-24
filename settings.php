<?php
    if (!isset($_SESSION)) { session_start(); }
    require_once "./code/managesession.php";
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
                                    <form class="form" role="form" autocomplete="off">
                                        <div class="form-group">
                                            <label for="lblChangePwd" class="form-control-sm">Nuvarande lösenord</label>
                                            <input type="password" class="form-control" id="idCurrentPassword"></input>
                                            <label for="lblChangePwd" class="form-control-sm">Nytt Lösenord</label>
                                            <input type="password" class="form-control" id="idNewPassword"></input>
                                            <input type="button" class="button btn-success mt-2" id="btnChange" value="Ändra Lösenord"></input>
                                            <hr />
                                            <label for="lblChangePwd" class="form-control-sm">Min bild</label>
                                            
                                        </div>
                                    </form>
                                    <form action="./code/upload.php" method="post" enctype="multipart/form-data">
                                        <label>Välj en profilbild:</label>
                                        <input type="file" name="image">
                                        <input type="submit" name="submit" value="Ladda upp">
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
</html>