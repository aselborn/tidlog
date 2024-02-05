<?php
      if (!isset($_SESSION)) { session_start(); }
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";

      $db = new DbManager();
      $lagenheter = $db->query("select * from tidlog_lagenhet where lagenhet_id not in (select lagenhet_id from tidlog_hyresgaster)")->fetchAll();
      $hyresgaster = $db->query("SELECT * FROM  tidlog_hyresgaster h inner join tidlog_lagenhet l on h.lagenhet_id = l.lagenhet_id")->fetchAll();

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
                                    <th scope="col" class="table-primary">Efternamn</th>
                                    <th scope="col" class="table-primary">Lägenhet Nr</th>
                                    <th scope="col" class="table-primary">Telefon</th>
                                    <th scope="col" class="table-primary">Epost</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    foreach($hyresgaster as $row)
                                    {
                                        $namn = $row["fnamn"];
                                        $enamn = $row["enamn"];
                                        $lagenhetNo = $row["lagenhet_nr"];
                                        $epost = $row["epost"];
                                        $telefon = $row["telefon"];

                                        echo "<tr><td>" . $namn . "</td>"
                                            . "<td>" . $enamn . "</td>"
                                            . "<td>" . $lagenhetNo . "</td>"
                                            . "<td>" . $telefon . "</td>"
                                            . "<td>" . $epost . "</td>"
                                            . "</tr>";

                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-1">
                        
                        <form action="./code/addhyresgast.php" method="POST" id="frmAddHyresgast">
                            
                            <div class="d-inline-flex align-bottom p-1 gap-2">
                            
                                <div class="form-group">
                                    <label id="lblFnamn" class="label-primary">Förnamn</label>
                                    <input id="fnamn" type="text" name="fnamn" class="form-control" style="width:200px">
                                    <div class="invalid-feedback">
                                        Vänligen ange ett namn
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label id="lblEnamn" class="label-primary">Efternamn</label>
                                    <input id="enamn" type="text" name="enamn" class="form-control" style="width:200px" >
                                </div>

                                <div class="form-group">
                                    <label id="lblLagenhetNo" class="label-primary" >Lägenhet Nr</label>
                                    
                                    <select id="lagenhetId" class="form-select" name="lagenhet" style="width:130px">
                                        <?php 

                                            foreach($lagenheter as $row)
                                            {
                                                echo "<option value='" .$row["lagenhet_id"] ."'>" .$row["lagenhet_nr"].  "</option>";
                                            }

                                        ?>
                                        <!-- <option value="T7">T7</option>
                                        <option value="U9">U9</option> -->
                                    </select>

                                </div>
                                
                                <div class="form-group">
                                    <label id="lblTelefon" class="label-primary">Telefon</label>
                                    <input id="telefon" type="text" name="telefon" class="form-control" style="width:200px">
                                </div>

                                <div class="form-group">
                                    <label id="lblEpost" class="label-primary">Epost</label>
                                    <input id="epost" type="text" name="epost" class="form-control" style="width:250px" >
                                </div>

                                <div class="form-group col-sm-4">
                                    <br />
                                    <input type="button"  class="btn btn-primary btn-send" value="Spara" id="btnSparaHyresgast"> 
                                </div>
                            
                            
                            </div>
                        
                        </form>
                        
                    </div>
                </div>
            </div>
        </body>
</html>