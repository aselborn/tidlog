<?php
      if (!isset($_SESSION)) { session_start(); }
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Hyresgäster</title>
        
    </head>

    <body>
        
        <?php include("./pages/sidebar.php") ?>

        <div class="col-sm  min-vh-100 border">
            <h2>Hyresgäster</h2>
            <hr />
            <div class="container border" >
                <div class="row mt-3">
                    <div class="col-2">
                        <label id="lblFastighet" class="label-primary">Välj fastighet</label>
                        <select id="job_fastighet" class="form-select" name="job_fastighet">
                            <option value="T7">T7</option>
                            <option value="U9">U9</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <table class="table table-hover table-striped " id="jobTable">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="table-primary">Namn</th>
                                    <th scope="col" class="table-primary">Lägenhet Nr</th>
                                    <th scope="col" class="table-primary">Telefon</th>
                                    <th scope="col" class="table-primary">Epost</th>
                                </tr>
                            </thead>
                            <tbody>
                          
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <form action="addhyresgast.php" method="POST" id="frmInput">
                            
                        </form>
                    </div>
                </div>
            </div>
        </body>
</html>