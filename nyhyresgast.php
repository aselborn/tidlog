<?php

    
 if (!isset($_SESSION)) { session_start(); }

    require_once "./code/dbmanager.php";
    require_once "./code/managesession.php";
    require_once "./code/objHyresgast.php";

    $db = new DbManager();
    $lagenheter = $db->query("select * from tidlog_lagenhet l where l.hyresgast_id  is null ")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Hyresgäst</title>
    </head>
    <body>
        <!-- <input type="hidden" id="hidlagenhetNo" name="HidLagenhetNo" value="<?php echo $lagenhetNo ?>" > -->
        <?php include("./pages/sidebar.php") ?>

        <div class="col-sm  min-vh-100 border">
            <h2>Hyresgäst</h2>
            <hr />
            <div class="container border" >
                <div class="d-inline-flex">
                    <h3>
                        <strong>Skapa en ny hyresgäst</strong>
                    </h3>
                </div>
                <div class="row mt-1">
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
                                    <option value="0">Välj lägenhet</option>
                                    <?php 

                                        foreach($lagenheter as $row)
                                        {
                                            echo "<option value='" .$row["lagenhet_id"] ."'>" .$row["lagenhet_nr"].  "</option>";
                                        }

                                    ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label id="lblAdress" class="label-primary">Adress</label>
                                <input id="adress" type="text" name="adress" class="form-control" style="width:100px" >
                            </div>


                            <div class="form-group">
                                <label id="lblEpost" class="label-primary">Epost</label>
                                <input id="epost" type="text" name="epost" class="form-control" style="width:250px" >
                            </div>

                            <div class="form-group">
                                <label id="lblTelefon" class="label-primary">Telefon</label>
                                <input id="telefon" type="text" name="telefon" class="form-control" style="width:200px">
                            </div>

                            <div class="form-group">
                                <label id="lblAndraHand" class="label-primary">Andra Hand</label>
                                <!-- <input id="telefon" type="text" name="telefon" class="form-control" style="width:200px"> -->
                            </div>

                            
                            <div class="form-group col-sm-4">
                                <br />
                                <input type="button"  class="btn btn-primary btn-send" value="Spara" id="btnNyHyresgast"> 
                            </div>
                        
                        </div>
                </div>
            </div>
        </div>
    </body>
</html>