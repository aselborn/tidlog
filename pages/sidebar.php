<?php 

    define('MY_ROOT_PATH', $_SERVER['SERVER_NAME']. '/tidlog/');

    $path = $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
    $docRoot = $_SERVER['HTTP_HOST'];
    $sf = $_SERVER['PHP_SELF'];
    $usr = $_SESSION["username"];
    
    require("depends.html");
?>

<nav class="sidebar">
      <a href="#" class="logo">T7 & U9</a>

      <div class="menu-content">
        <ul class="menu-items">
          <div class="menu-title">Välj funktion i menyn</div>

          <li class="item">
            <div class="submenu-item">
            <i class="fa fs-3 bi-clock"></i><span>Tidsregistrering</span>
                <i class="fa-solid fa-chevron-right"></i>
            </div>
            
            <ul class="menu-items submenu">
            <div class="menu-title">
                <i class="fa-solid fa-chevron-left"></i>
                    Tillbaka till menyn
              </div>
              <li class="item">
                <a href="index.php">Registrera tid</a>
              </li>

              <li class="item">
                <a href="report.php">Sammanställning</a>
               </li>  
            </ul>

          </li>

          <li class="item">
            <div class="submenu-item">
            <i class="fa fs-3 bi bi-building"></i><span>Lägenheter</span>
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
            <i class="fa fs-3 bi-people"></i><span>Hyresgäster</span>
              <i class="fa-solid fa-chevron-right"></i>
            </div>

            <ul class="menu-items submenu">
              <div class="menu-title">
                <i class="fa-solid fa-chevron-left"></i>
                Tillbaka till menyn
              </div>
              <li class="item">
                    <a href="hyresgaster.php?page=1&fastighetId=1">Tryckaren 7</a>
                    <!-- <a href="#">Tryckaren 7</a> -->
              </li>

              <li class="item">
                <a href="hyresgaster.php?page=1&fastighetId=2">Uttern 9</a>
              </li>
              
            </ul>
          </li>

          <li class="item">
            <div class="submenu-item">
            <i class="fa fs-3 gap-3 bi-p-circle"></i><span>Parkering</span>
              <i class="fa-solid fa-chevron-right"></i>
            </div>

            <ul class="menu-items submenu">
              <div class="menu-title">
                <i class="fa-solid fa-chevron-left"></i>
                Tillbaka till menyn
              </div>
              <li class="item">
                    <a href="parking.php?fastighetId=1">Tryckaren 7</a>
              </li>

              <li class="item">
                <a href="parking.php?fastighetId=2">Uttern 9</a>
              </li>
              
            </ul>
          </li>

          <!--artiklar-->
          <li class="item">
            <a href="artiklar.php"><i class="fa-solid fs-3 fa-paperclip"></i>Artiklar</a>
          </li>

          <!--Hyres avier-->
          <li class="item">
            <div class="submenu-item">
            <i class="fa fs-3 fa-bar-chart-o"></i><span>Hyresavisering</span>
              <i class="fa-solid fa-chevron-right"></i>
            </div>

            <ul class="menu-items submenu">
              <div class="menu-title">
                <i class="fa-solid fa-chevron-left"></i>
                Tillbaka till menyn
              </div>
              <li class="item">
                    <a href="avisering.php?page=1&fastighetId=1">Avisering T7</a>
              </li>

              <li class="item">
                <a href="avisering.php?page=1&fastighetId=2">Avisering U9</a>
              </li>

              <li class="item">
                <a href="extrafaktura.php?page=1&fastighetId=1">Extra artikel T7</a>
              </li>

              <li class="item">
                <a href="extrafaktura.php?page=1&fastighetId=2">Extra artikel U9</a>
              </li>
              
              <li class="item">
                <a href="avimeddelande.php?page=1&fastighetId=1">Meddelande T7</a>
              </li>

              <li class="item">
                <a href="avimeddelande.php?page=1&fastighetId=2">Meddelande U9</a>
              </li>

            </ul>
          </li>

          <!--Hyres KOLL-->
          <li class="item">
            <div class="submenu-item">
            <i class="fa fs-3 fa-money"></i><span>Inbetalningar</span>
              <i class="fa-solid fa-chevron-right"></i>
            </div>

            <ul class="menu-items submenu">
              <div class="menu-title">
                <i class="fa-solid fa-chevron-left"></i>
                Tillbaka till menyn
              </div>

              <li class="item">
                    <a href="inbetalning.php?page=1&fastighetId=1">Registrera inbetalning</a>
              </li>

              <li class="item">
                    <a href="extrainbetalning.php">Registrera Extra inbetalning</a>
              </li>


              <li class="item">
                    <a href="obetaldafakturor.php">Obetalda fakturor</a>
              </li>
              <li class="item">
                    <a href="felaktigafakturor.php">Felaktiga fakturor</a>
              </li>
              

              <!-- <li class="item">
                <a href="inbetalning.php?page=1&fastighetId=2">Registrera inbetalningar för U9</a>
              </li>

              <li class="item">
                <a href="visainbetalning.php?fastighetId=2">Visa inbetalningar för U9</a>
              </li> -->

            </ul>
          </li>

          <li class="item">
            <a href="settings.php"><i class="fa fs-3 fa-cog "></i>Inställningar</a>
          </li>

          <li class="item">
            <a href="logout.php"><i class="fa fs-3 gap-4 bi-door-open "></i><span>Logga ut</span></a>
          </li>
        </ul>
      </div>
    </nav>

    <nav class="navbar">
      <i class="fa-solid fa-bars" id="sidebar-close"></i>
    </nav>
