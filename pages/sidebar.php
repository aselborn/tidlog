<?php 

    define('MY_ROOT_PATH', $_SERVER['SERVER_NAME']. '/tidlog/');

    $path = $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
    $docRoot = $_SERVER['HTTP_HOST'];
    
    $sf = $_SERVER['PHP_SELF'];
    
    // switch($_SERVER['SERVER_NAME']){
    //     case 'localhost':
    //             define('MY_ROOT_PATH', $_SERVER['SERVER_NAME']);
    //         break;

    //         case 'www.selborn.se':
    //             define('MY_ROOT_PATH',$_SERVER['SERVER_NAME']);
    //         break;
    //   }

      
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tidlog</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css" /> -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="./style/tidlog.css">
        <link rel="stylesheet" href="./style/style.css">
        

        <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="../js/totable.js"></script>
        <script src="../js/index.js"></script>

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
                    <li>
                        <a href="settings.php" class="nav-link py-3 px-2" title="Inställnigar" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="inställningar">
                            <i class="bi-people fs-1"></i>
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