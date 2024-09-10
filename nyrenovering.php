<?php

 if (!isset($_SESSION)) { session_start(); }

    require_once "./code/dbmanager.php";
    require_once "./code/managesession.php";
    require_once "./code/objHyresgast.php";
    require_once "./code/datum_helper.php";

    $db = new DbManager();
    $datumHelper = new DatumHelper();
    $fastighetId = $_GET['fastighetId'];
    $lagenheter = $db->query("select lagenhet_nr, lagenhet_id from tidlog_lagenhet l inner join tidlog_fastighet tf on l.fastighet_id =tf.fastighet_id  
        where tf.fastighet_id = " . $fastighetId . "
        order by l.lagenhet_nr")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Spara ny renovering</title>
    </head>
    <body>
       
        <!-- <input type="hidden" id="hidlagenhetNo" name="HidLagenhetNo" value="<?php echo $lagenhetNo ?>" > -->
        <?php include("./pages/sidebar.php") ?>
        
        <div class="main">
            <div class="container-fluid mt-5" >
                <br />
                <div class="d-inline-flex ">
                    <h2>
                        <strong>Registrera en ny renovering</strong>
                    </h2>
                </div>
                <div class="row mt-1">
                    <form  action=<?php echo "./code/uploadkontrakt.php?fastighetId=$fastighetId" ?> method="post" enctype="multipart/form-data">
                        <div class="d-inline-flex align-bottom p-1 gap-2">
                            

                            <div class="form-group">
                                <label id="lblLagenhetNo" class="label-primary" >Lägenhet Nr</label>

                                
                                <select id="lagenhetId" class="form-select" name="lagenhet" style="width:150px">
                                    <!-- <option value="0">Välj lägenhet</option> -->
                                    <?php 

                                        foreach($lagenheter as $row)
                                        {
                                            //echo "<option value='" .$row["lagenhet_id"] ."'>" .$row["lagenhet_nr"].  "</option>";
                                            echo "<option name='".$row["lagenhet_nr"] . "' value='" .$row["lagenhet_id"] ."'>" .$row["lagenhet_nr"].  "</option>";
                                        }

                                    ?>
                                </select>
                            </div>
                            
                            
                            <div class="form-group">
                                <label id="lblGiltTill" class="label-primary">Påbörjad</label>
                                <input id="giltFran" required type="date" name="dtFom" value="<?php echo $datumHelper->GetTodayDatum(); ?>" class="form-control"  >
                                
                            </div>


                            <div class="form-group">
                                <label id="lblGiltTill" class="label-primary">Färdig</label>
                                <input id="giltTill" required type="date" value="<?php echo $datumHelper->GetTodayDatum(); ?>" name="dtTom" class="form-control"  >
                            </div>

                              

                            <div class="form-group">
                                <!-- <label id="lblEpost" class="label-primary">Scannat kontrakt</label> -->
                                <!-- <input id="epost" type="text" name="epost" class="form-control"  > -->
                                <label id="lblEpost" class="label-primary">Befintlig Wordfil</label>
                                <label class="label-primary" file-upload>
                                    <input type="file" required name="pdfkontrakt" id="file_kontrakt" accept="application/pdf" id="btnAddKontraktBlob" value="ladda..." class="btn btn-outline-success btn rounded-5" />
                                </label>
                            </div>

                            

                        </div>
                         
                        <div class="row">
                            <div class="d-inline-flex align-bottom p-1 gap-2">
                                <div class="form-group col-sm-4">
                                    <input type="submit" name="spara_gammalt_kontrakt"  class="btn btn-outline-success btn rounded-5" value="Spara"> 
                                </div>

                            </div>
                        </div>

                    </form>

                </div>
                
            </div>
        </div>
    </body>
</html>