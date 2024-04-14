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

    $parkeringar = $db->query(" select *   from tidlog_parkering tp 
    where tp.park_id not in 
    (select park_id from tidlog_lagenhet tl where park_id is not null)
    and tp.fastighet_id = ? ", array($lghInfo->fastighetId ) )->fetchAll();

    

    // $retroHyra = $db->query(
    //     "select * from tidlog_lagenhet tl 
    //     left outer join tidlog_retro_hyra trh  on tl.lagenhet_id = trh.lagenhet_id
    //     where trh.lagenhetNo = ? order by trh.giltlig_datum asc", array($lagenhetNo))->fetchAll();
    $retroHyra = $db->query(
             "select * from tidlog_retro_hyra trh  
         where trh.lagenhetNo = ? order by trh.giltlig_datum asc", array($lagenhetNo))->fetchAll();
    

    $retroCount = count($retroHyra);
   

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Lägenhetinformation</title>
    </head>
    
    <?php include("./pages/sidebar.php") ?>

    <body>
        <input type="hidden" id="hidlagenhetNo" name="HidLagenhetNo" value="<?php echo $lagenhetNo ?>" >
        <input type="hidden" id="hidLagenhetId" name="HidLagenhetId" value="<?php echo $lghInfo->lagenhetId; ?>" >
        
        
        <div class="main ">
            
            <div class="container-fluid mt-5" >
                <div class="row mt-2">
                    <div class="d-inline-flex ">
                        <h3><strong>Information om lägenhet nr <?php echo $lghInfo->lagenhetNo ?></strong></h3>
                    </div>
                </div>
            
                <div class="row">
                    <div class="d-inline-flex">
                        <table class="table table-sm table-striped w-auto" id="tblRetroHyra" >
                            <thead>
                                <tr>
                                    <th scope="col" class="table-primary">Tidigare</th>
                                    <th scope="col" class="table-primary">Hyra</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $items = sizeof($retroHyra);
                                    $cnt = 1;
                                    foreach($retroHyra as $row)
                                    {
                                        $dt = date_create($row["giltlig_datum"]);
                                        $giltlig_fram = date_format($dt, "Y-m-d");
                                        
                                        
                                        $lagenhetId = $row["lagenhet_id"];
                                        //$hyra =$row["hyra"];
                                        $hyra_retro = $row["hyra_retro"];
                                        // $datum_changed = $row["sparad"];
                                        // if ($cnt == $items)
                                        // {
                                        //     $hyra_retro = $hyra;
                                        // }
                                        echo 
                                        "
                                            <tr id='$lagenhetId'>
                                                <td>" . $giltlig_fram . "</td>" . 
                                                "<td>" . $hyra_retro . "</td>" . 
                                                // "<td>" . $datum_changed . "</td>" .
                                            "</tr>
                                        ";

                                        $cnt++;
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row mt-3">

                
                    
                    <div class="col-12 ">
                        <!--TABELL SOM ANGER HYRA OCH PARKERING-->
                        <table class="table table-striped w-auto">
                            <thead>
                                <tr >
                                    <th scope="col" class="table-primary">Lägenhet</th>
                                    <th scope="col" class="table-primary">Hyra</th>
                                    <th scope="col" class="table-primary">Ny Hyra</th>
                                    
                                    
                                    
                                    <?php 
                                        if ($lghInfo->parkering == 0){
                                            echo "<th scope='col' class='table-primary'>Välj parkering</th>";
                                        } else{
                                            echo "<th scope='col' class='table-primary'>Parkering</th>";
                                        }
                                    ?>

                                    <th scope="col" class="table-primary"></th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="row-cols-auto ">
                                    <td><?php echo "Nr : ". $lghInfo->lagenhetNo ?></td>
                                    <td><?php echo $lghInfo->hyra . " kr/mån" ?></td>
                                    <td class="mt-1 ">
                                        <input class="form-control-sm" style="width: 120px;" type="number" id="txtNyHyra" />
                                        <input class="form-control-sm" style="width: 120px;" type="date" id="dtGiltligFran" />
                                        <input type="button" id="btnNyHyra" class="btn btn-success" value="Spara">     
                                    </td>
                                    
                                    <!-- <td class="mt-1 ">
                                        
                                    </td> -->

                                    <td class="mt-1">
                                        <?php 
                                            if ($lghInfo->parkering == 0){
                                                
                                                echo '<select id="cboParkering" class="form-select" name="Parkering">';
                                                echo "<option value='Välj parkering'>--Välj--</option>";
                                                foreach($parkeringar as $row)
                                                {
                                                    echo "<option value='" .$row["park_id"] ."'>" .$row["parknr"].  "</option>";
                                                }
                                                echo '</select>';

                                            } else {
                                                echo "<label class='form-label' >". "parkering: " .   $lghInfo->parkNr . " -> " .  $lghInfo->parkering . " kr/mån" . " </label>";
                                                echo "<input type='hidden' id='hidPark' value = '" .$lghInfo->parkering . "' />";
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            if ($lghInfo->parkering > 0){
                                                echo "<input type='button' id='btnRemovePark' class='btn btn-success ' value='Ta bort'> ";
                                            }
                                        ?>
                                    </td>

                                  

                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="row">Total hyra</th>
                                    <td><strong><?php echo $lghInfo->hyra + $lghInfo->parkering . " kronor / månad." ?></strong></td>
                                    <td><strong><?php echo 12 *($lghInfo->hyra + $lghInfo->parkering ) . " kronor / år." ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>

                        
                    </div>
                    <!--moms-->
                    <!-- <div class="col-4 ">
                                            
                    </div> -->
                </div>
                

            </div>
        </div>
    </body>
</html>