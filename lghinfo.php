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
    $parkeringar = $db->query("select * from tidlog_parkering tp2 where tp2.park_id not in (
        select park_id from tidlog_parkering tp where park_id in (select park_id from tidlog_lagenhet tl)) ")->fetchAll();

    $lghInfo = new InfoLagenhet($lagenhetNo);
    

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Lägenhetinformation</title>
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
                                    <th scope="col" class="table-primary">Tidigare hyra</th>
                                    <th scope="col" class="table-primary">Hyran ändrad</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                

            </div>
        </div>
    </body>
</html>