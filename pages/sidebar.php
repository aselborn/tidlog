<?php 

    define('MY_ROOT_PATH', $_SERVER['SERVER_NAME']. '/tidlog/');

    $path = $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
    $docRoot = $_SERVER['HTTP_HOST'];
    
    $sf = $_SERVER['PHP_SELF'];
    
    $usr = $_SESSION["username"];
      
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tidlog</title>
        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"> -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="./style/tidlog.css">
        <!-- <link rel="stylesheet" href="./style/style.css"> -->
        
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="icon" type="image/x-icon" href="./bilder/favicon.ico">
        <script
            src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous">
        </script>

        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>


        <script src="./js/common.js"></script>
        <script src="./js/index.js"></script>
        <script src="./js/settings.js"></script>
        <script src="./js/report.js"></script>
        <script src="./js/lagenhet.js"></script>
        <script src="./js/hyresgast.js"></script>
        <script src="./js/lghinfo.js"></script>
        <script src="./js/hyrginfo.js"></script>
        <script src="./js/avisering.js"></script>
        
    </head>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-auto bg-light sticky-top">
                <div class="d-flex flex-sm-column flex-row flex-nowrap bg-light align-items-center sticky-top">
                <a href="index.php" class="d-block p-3 link-dark text-decoration-none" title="Hem" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Icon-only">
                    <i class="bi-calendar-check fs-1"></i>
                </a>
                <ul class="nav nav-pills nav-flush flex-sm-column flex-row flex-nowrap mb-auto mx-auto text-center justify-content-between w-100 px-3 align-items-center">
                    <li class="nav-item">
                        <a href="report.php" class="nav-link py-3 px-2" title="Sammanställning" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Sammanställnig">
                            <i class="bi-card-text fs-1"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="report.php" class="nav-link py-3 px-2" title="Sammanställning" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Sammanställnig">
                            <i class="bi-card-text fs-1"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="lagenhet.php" class="nav-link py-3 px-2" title="Lägenheter" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Lägenheter">
                            <i class="bi bi-building fs-1"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="hyresgaster.php" class="nav-link py-3 px-2" title="Hyresgäster" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Hyresgäster">
                            <i class="bi bi-people fs-1"></i>
                        </a>
                    </li>

                    
                    <li class="nav-item">
                        <a href="parking.php" class="nav-link py-3 px-2" title="Parkering" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Parkering">
                            <i class="bi bi-p-circle-fill fs-1"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="avisering.php" class="nav-link py-3 px-2" title="Avisering" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Avisering">
                            <i class="bi bi-cash-coin fs-1"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="skapa_faktura.php" class="nav-link py-3 px-2" title="Skapa en faktura" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Skapa faktura">
                            <i class="bi bi-cash fs-1"></i>
                        </a>
                    </li>

                    

                    <li class="nav-item">
                        <a href="hyreskoll.php" class="nav-link py-3 px-2" title="Hyreskoll" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Hyreskoll">
                            <i class="bi bi-bank fs-1"></i>
                        </a>
                    </li>

                    <li>
                        <a href="settings.php" class="nav-link py-3 px-2" title="Inställnigar" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="inställningar">
                            <i class="bi bi-gear fs-1"></i>
                        </a>
                    </li>
                    <li>
                        <a href="logout.php" class="nav-link py-3 px-2" title="logga ut" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="logga ut">
                            <i class="bi-door-open fs-1"></i>
                        </a>
                    </li>
                    <!-- <li>
                        <a href="#" class="nav-link py-3 px-2" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="settings">
                            <i class="box-arrow-left fs-1"></i>
                        </a>
                    </li> -->
                </ul>
                
            </div>
    </div>
</html>