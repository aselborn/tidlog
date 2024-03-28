<?php 
    if (!isset($_SESSION)) { session_start(); }

    require_once "./code/dbmanager.php";
    require_once "./code/managesession.php";
    $db = new DbManager();
    $artiklar = $db->query(
        "Select * from tidlog_item order by artikel")->fetchAll();  

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Artikel</title>
    </head>
    <body>
        <!-- <input type="hidden" id="hidlagenhetNo" name="HidLagenhetNo" value="<?php echo $lagenhetNo ?>" > -->
        <?php include("./pages/sidebar.php") ?>
        
        <div class="main">
            <div class="container-fluid mt-5" >
                <br />
                <div class="d-inline-flex ">
                    <h2>
                        <strong>Artiklar</strong>
                    </h2>
                </div>
                <div class="row mt-1">
                <div class="d-inline-flex">
                        <table class="table table table-striped w-auto" id="tblArtikel" >
                            <thead>
                                <tr>
                                    <th scope="col" class="table-primary">Artikel</th>
                                    <th scope="col" class="table-primary">Pris</th>
                                    <th scope="col" class="table-primary">Kommentar</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                    foreach($artiklar as $row)
                                    {
                                        $itemId = $row["item_id"];
                                        $artikel =$row["artikel"];
                                        $pris = $row["pris"];
                                        $kommentar = $row["kommentar"];
                                        echo 
                                        "
                                            <tr id='$itemId'>
                                                <td>" . $artikel . "</td>" . 
                                                "<td>" . $pris . "</td>" . 
                                                "<td>" . $kommentar . "</td>" .
                                            "</tr>
                                        ";
                                    }
                                ?>
                            </tbody>
                        </table>
                </div>
                <div class="row mt-1">
                    <div class="d-inline-flex align-bottom p-1 gap-2">
                            
                            <div class="form-group">
                                <label id="lblArtikel" class="label-primary">Artikel</label>
                                <input id="artikel" type="text" name="artikel" class="form-control" style="width:200px">
                                <div class="invalid-feedback">
                                    Vänligen ange ett artikel
                                </div>
                            </div>

                            <div class="form-group">
                                <label id="lblPris" class="label-primary">Pris</label>
                                <input id="pris" type="number" name="pris" class="form-control" style="width:90px" >
                            </div>

                            
                            <div class="form-group">
                                <label id="lblkommentar" class="label-primary">Kommentar</label>
                                <input id="kommentar" type="text" name="kommentar" class="form-control" style="width:400px" >
                            </div>


                            
                            <div class="form-group col-sm-4">
                                <br />
                                <input type="button"  class="btn btn-primary btn-send" value="Spara" id="btnNyArtikel"> 
                            </div>
                        
                        </div>
                </div>
            </div>
        </div>
    </body>
</html>