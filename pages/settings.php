<?php
    if (!isset($_SESSION)) { session_start(); }
    require_once "../code/managesession.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Inställningar</title>
    </head>

    <body>
        <?php include("../sidebar.php") ?>

        <div class="col-sm  min-vh-100 border">
            <h2>Inställningar för ditt konto <strong><?= htmlspecialchars($_SESSION["username"]); ?></strong></h2>
            <hr />
            <div class="container mt-4 ">

                <div class="container py-5">
                    <div class="card card-outline-secondary">
                        <div class="card-header">
                            <h3 class="mb-0">Hantera lösenord</h3>
                            <div class="card-body">
                                <form class="form" role="form" autocomplete="off">
                                    <div class="form-group">
                                        <label for="lblChangePwd" class="form-control-lg">Nuvarande lösenord</label>
                                        <input type="password" class="form-control" id="idCurrentPassword"></input>
                                    </div>
                                </form>
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