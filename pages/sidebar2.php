<?php 

    define('MY_ROOT_PATH', $_SERVER['SERVER_NAME']. '/tidlog/');

    $path = $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
    $docRoot = $_SERVER['HTTP_HOST'];
    
    $sf = $_SERVER['PHP_SELF'];
    
    $usr = $_SESSION["username"];
      
?>
    <script
        src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <script src="./js/common.js"></script>
    <script src="./js/index.js"></script>
    <script src="./js/settings.js"></script>
    <script src="./js/report.js"></script>
    <script src="./js/lagenhet.js"></script>
    <script src="./js/hyresgast.js"></script>
    <script src="./js/lghinfo.js"></script>
    <script src="./js/hyrginfo.js"></script>
    <script src="./js/avisering.js"></script>
    <script src="./js/sidebar-accordion.js"></script>

    <link rel="stylesheet" href="./style/accordion.css">
    <link rel="stylesheet" href="./style/tidlog.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

   
    <link rel="icon" type="image/x-icon" href="./bilder/favicon.ico">
   
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    
        <aside class="sidebar">
            <div id="leftside-navigation" class="nano">
            <ul class="nano-content">
                <li>
                    <a href="index.php"><i class="fa fa-lg fa-dashboard"></i><span>Meny</span></a>
                </li>
                <li class="sub-menu">
                    <a href="javascript:void(0);"><i class="fa fa-lg  bi-clock"></i><span>Tidsregistrering</span><i class="arrow fa fa-angle-right pull-right"></i></a>
                    <ul>
                        <li>
                            <a href="index.php">Registrera tid</a>
                        </li>
                        <li>
                            <a href="report.php">Sammanställning</a>
                        </li>
                 
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:void(0);"><i class="fa fa-lg bi bi-building"></i><span>Lägenheter</span><i class="arrow fa fa-angle-right pull-right"></i></a>
                    <ul>
                        <li>
                            <a href="lagenhet.php?page=1&fastighetId=1">Tryckaren 7</a>
                        </li>

                        <li>
                            <a href="lagenhet.php?fastighetId=2">Uttern 9</a>
                        </li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:void(0);"><i class="fa fa-lg bi-people"></i><span>Hyresgäster</span><i class="arrow fa fa-angle-right pull-right"></i></a>
                    <ul>
                        <li>
                            <a href="hyresgaster.php?page=1&fastighetId=1">Tryckaren 7</a>
                        </li>
                        <li>
                            <a href="hyresgaster.php?page=1&fastighetId=2">Uttern 9</a>
                        </li>
                    </ul>
                </li>
                <li class="sub-menu active">
                    <a href="javascript:void(0);"><i class="fa fa-lg bi-p-circle"></i><span>Parkeringsplatser</span><i class="arrow fa fa-angle-right pull-right"></i></a>
                    <ul>
                    <li class="active"><a href="parking.php?fastighetId=1">Tryckaren 7</a>
                    </li>
                    <li><a href="parking.php?fastighetId=2">Uttern 9</a>
                    </li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:void(0);"><i class="fa fa-lg fa-bar-chart-o"></i><span>Ekonomi</span><i class="arrow fa fa-angle-right pull-right"></i></a>
                    <ul>
                    <li><a href="avisering.php?page=1&fastighetId=1">Avisering av hyror</a>
                    </li>
                    <li><a href="hyreskoll.php?page=1&fastighetId=2">Kontroll av hyror</a>
                    </li>
                    <li><a href="skapa_faktura.php">Skapa faktura</a></li>
                    </ul>
                </li>
                
                <li class="sub-menu">
                    <a href="logout.php"><i class="fa fa-lg bi-door-open "></i><span>Logga ut</span></a>
                </li>
                
            </ul>

        </div>
    </aside>
