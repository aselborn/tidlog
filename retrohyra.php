<?php 
    if (!isset($_SESSION)) { session_start(); }

    require_once "./code/dbmanager.php";
    require_once "./code/managesession.php";
    require_once "./code/objLagenhet.php";

    if (!isset($_GET['lagenhetNo'])) {
        $lagenhetNo = 1;
    } else {
        $lagenhetNo = $_GET['lagenhetNo'];
    }
    
    $db = new DbManager();
    $lghInfo = new InfoLagenhet($lagenhetNo);
    $retroHyra = $db->query(
        "select * from tidlog_lagenhet tl 
        left outer join tidlog_retro_hyra trh  on tl.lagenhet_id = trh.lagenhet_id
        where trh.lagenhetNo = ?", array($lagenhetNo))->fetchAll();    

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Retro hyra</title>
    </head>
    
    <body>

        <input type="hidden" id="hidlagenhetNo" name="HidLagenhetNo" value="<?php echo $lagenhetNo ?>" >
        
        <?php include("./pages/sidebar.php") ?>

        <div class="col-sm  min-vh-100 border">
            <h2>Lägenhet</h2>
            <hr />
            <div class="container border" >
                <div class="row">
                    <div class="d-inline-flex">
                        <h3><strong>Information om lägenhet nr <?php echo $lghInfo->lagenhetNo ?></strong></h3>
                    </div>
                </div>
            
                <div class="row">
                    <div class="d-inline-flex">
                        <table class="table table table-striped w-auto" id="tblRetroHyra" >
                            <thead>
                                <tr>
                                    <th scope="col" class="table-primary">Nuvarande hyra</th>
                                    <th scope="col" class="table-primary">Tidigare hyra</th>
                                    <th scope="col" class="table-primary">Hyran ändrad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    foreach($retroHyra as $row)
                                    {
                                        $lagenhetId = $row["lagenhet_id"];
                                        $hyra =$row["hyra"];
                                        $hyra_retro = $row["hyra_retro"];
                                        $datum_changed = $row["sparad"];
                                        echo 
                                        "
                                            <tr id='$lagenhetId'>
                                                <td>" . $hyra . "</td>" . 
                                                "<td>" . $hyra_retro . "</td>" . 
                                                "<td>" . $datum_changed . "</td>" .
                                            "</tr>
                                        ";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                

            </div>
        </div>
    </body>
</html>