<?php 
    if (!isset($_SESSION)) { session_start(); }
    
    include_once "./code/config.php";
    include_once "./code/objHyresgastAnalys.php";
    require_once "./code/dbmanager.php";
    require_once "./code/managesession.php";
    require_once "./code/datum_helper.php";

    $db = new DbManager();
    $dtHelper = new DatumHelper();

    if (isset($_POST['HidHyresgastId2'])){
        
        $hyresgastId = $_POST["HidHyresgastId2"];

        $HyresAnalys = new HyresgastAnalys($hyresgastId);

    }
    
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Analys, hyresgäst <?php echo "namn?" ?></title>
    </head>

    <body>
        
        <?php include("./pages/sidebar.php") ?>
    
        <div class="main ">

            <div class="container-fluid mt-4" >
                <br/>
                    <!-- <h3>Hantera befintlig hyresgäst i lägenhet, <?php echo $hyresGInfo->lagenhetNo ?></h3> -->
                    <hr />
                    <span><h2>Analys Hyresgäst <?php echo $HyresAnalys->fnamn . ", " . $HyresAnalys->enamn ?></h2></span>
                    
                    <div class="row mt-3" >
                        <div class="col-auto">
                            <table id="tblAnalysHyresgast" class="table">
                                <thead>
                                    <tr >
                                        <th scope="col" class="table-primary">FakturaNr</th>
                                        <th scope="col" class="table-primary">FF.Dat</th>
                                        <th scope="col" class="table-primary">Belopp</th>
                                        <th scope="col" class="table-primary">Bet.dat</th>
                                        <th scope="col" class="table-primary">Diff.dagar</th>
                                        <th scope="col" class="table-primary">Diff.Belopp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $sumBelopp = 0;
                                        foreach($HyresAnalys->resultSet as $row)
                                        {
                                            $fakturaNr = $row["fakturaNummer"];
                                            $ffdat = $dtHelper->GetDatum($row["FF.dat"]);
                                            $belopp = $row["Belopp"];
                                            $betdat = $dtHelper->GetDatum($row["Betdat"]);
                                            $diffDagar = $row["diff_datum_days"];
                                            $diffBelopp = $row["Diff.Belopp"];

                                            $extra_belopp = $row["extrabelopp"] == null ? 0 : $row["extrabelopp"];
                                            $extra_datum  = $row["extradatum"] == null ? "" :  $dtHelper->GetDatum($row["extradatum"]); 

                                            $sumBelopp += $belopp + $extra_belopp;
                                            if ($extra_belopp == 0){
                                                echo 
                                                "
                                                    <tr>
                                                        <td>$fakturaNr</td>
                                                        <td>$ffdat</td>
                                                        <td>$belopp</td>
                                                        <td>$betdat</td>
                                                        <td>$diffDagar</td>
                                                        <td>$diffBelopp</td>
                                                    </tr>
                                                ";
                                            } else {
                                                echo 
                                                "
                                                <tr>
                                                    <td>$fakturaNr</td>
                                                    <td>$ffdat</td>
                                                    <td>$belopp</td>
                                                    <td>$betdat</td>
                                                    <td>$diffDagar</td>
                                                    <td>$diffBelopp</td>
                                                </tr>
                                                <tr>
                                                    <td>$fakturaNr</td>
                                                    <td>$ffdat</td>
                                                    <td>$extra_belopp</td>
                                                    <td>$extra_datum</td>
                                                    <td>$diffDagar</td>
                                                    <td>$diffBelopp</td>
                                                </tr>
                                                ";
                                            }
                                            
                                        }
                                        
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="row">Totalt </th>
                                        <td></td>
                                        <td><strong><?php echo $sumBelopp ?></strong></td>
                                        
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    
                    

            </div>
            
            
        </div>
    </body>
</html>
