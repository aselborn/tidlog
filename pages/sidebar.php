<?php 

    define('MY_ROOT_PATH', $_SERVER['SERVER_NAME']. '/tidlog/');

    $path = $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
    $docRoot = $_SERVER['HTTP_HOST'];
    
    $sf = $_SERVER['PHP_SELF'];
    
    $usr = $_SESSION["username"];
      
?>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"> -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link rel="stylesheet" href="./style/tidlog.css">
<link rel="stylesheet" href="./style/sidebar.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />

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

<script src="./js/sidebar.js"></script>
<script src="./js/common.js"></script>
<script src="./js/index.js"></script>
<script src="./js/settings.js"></script>
<script src="./js/report.js"></script>
<script src="./js/lagenhet.js"></script>
<script src="./js/hyresgast.js"></script>
<script src="./js/lghinfo.js"></script>
<script src="./js/hyrginfo.js"></script>
<script src="./js/avisering.js"></script>




<nav class="sidebar">
      <a href="#" class="logo">FastighetSystem</a>

      <div class="menu-content">
        <ul class="menu-items">
          <div class="menu-title">Välj funktion i menyn</div>

          <li class="item">
            <!-- <a href="#">Tidsregistrering</a> -->
            <a href="index.php">Registrera tid</a>
          </li>

          <li class="item">
            <div class="submenu-item">
              <span>Lägenheter</span>
              <i class="fa-solid fa-chevron-right"></i>
            </div>

            <ul class="menu-items submenu">
              <div class="menu-title">
                <i class="fa-solid fa-chevron-left"></i>
                    Tillbaka till menyn
              </div>
              <li class="item">
              <a href="lagenhet.php?fastighetId=1">Tryckaren 7</a>
              </li>
              <li class="item">
                <a href="lagenhet.php?fastighetId=2">Uttern 9</a>
               </li>
            </ul>
          </li>
          <li class="item">
            <div class="submenu-item">
              <span>Hyresgäster</span>
              <i class="fa-solid fa-chevron-right"></i>
            </div>

            <ul class="menu-items submenu">
              <div class="menu-title">
                <i class="fa-solid fa-chevron-left"></i>
                Your submenu title
              </div>
              <li class="item">
                <a href="#">Second sublink</a>
              </li>
              <li class="item">
                <a href="#">Second sublink</a>
              </li>
              <li class="item">
                <a href="#">Second sublink</a>
              </li>
              <li class="item">
                <a href="#">Second sublink</a>
              </li>
              <li class="item">
                <a href="#">Second sublink</a>
              </li>
              <li class="item">
                <a href="#">Second sublink</a>
              </li>
              <li class="item">
                <a href="#">Second sublink</a>
              </li>
              <li class="item">
                <a href="#">Second sublink</a>
              </li>
              <li class="item">
                <a href="#">Second sublink</a>
              </li>
              <li class="item">
                <a href="#">Second sublink</a>
              </li>
              <li class="item">
                <a href="#">Second sublink</a>
              </li>
              <li class="item">
                <a href="#">Second sublink</a>
              </li>
              <li class="item">
                <a href="#">Second sublink</a>
              </li>
              <li class="item">
                <a href="#">Second sublink</a>
              </li>
              <li class="item">
                <a href="#">Second sublink</a>
              </li>
              <li class="item">
                <a href="#">Second sublink</a>
              </li>
              <li class="item">
                <a href="#">Second sublink</a>
              </li>
              <li class="item">
                <a href="#">Second sublink</a>
              </li>
              <li class="item">
                <a href="#">Second sublink</a>
              </li>
              <li class="item">
                <a href="#">Second sublink</a>
              </li>
              <li class="item">
                <a href="#">Second sublink</a>
              </li>
            </ul>
          </li>

          <li class="item">
            <a href="#">Your second link</a>
          </li>

          <li class="item">
            <a href="#">Your third link</a>
          </li>
        </ul>
      </div>
    </nav>

    <nav class="navbar">
      <i class="fa-solid fa-bars" id="sidebar-close"></i>
    </nav>
