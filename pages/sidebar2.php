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
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="./style/tidlog.css">
        
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="icon" type="image/x-icon" href="./bilder/favicon.ico">
        <script
            src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous">
        </script>

        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
        
        <!-- Sidebar Accordion CSS -->
        <link rel="stylesheet" href="style/sidebar-accordion.css">

        <!-- Sidebar Accordion JS -->
        <script src="js/sidebar-accordion.js"></script>

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

    <style>
        .btnMenu {
	display: none;
	padding: 20px;
	display: block;
	background: #1abc9c;
	color: #fff;
}
.btnMenu i.fa { float: right; }

.contenedor-menu {
	width: 10%;
	min-width: 200px;
	margin: 50px;
	display: inline-block;
	line-height: 18px;
}
.contenedor-menu .menu { width: 100%; }
.contenedor-menu ul { list-style: none; }
.contenedor-menu .menu li a {
	color: #494949;
	display: block;
	padding: 15px 20px;
	background: #e9e9e9;
}
.contenedor-menu .menu li a:hover { background: #16a085; color: #fff; } 
.contenedor-menu .menu i.fa { 
	font-size: 12px; 
	line-height: 18px; 
	float: right; 
	margin-left: 10px; 
}

.contenedor-menu .menu ul { display: none; }
.contenedor-menu .menu ul li a {
	background: #424242;
	color: #e9e9e9;
}

.contenedor-menu .menu .activado > a {
	background: #16a085;
	color: #fff;
}
</style>
<div class = "container-fluid">
    <div class="row">
        <div class="col-sm-auto bg-light sticky-top">
            
                
                    <a href="" class="btnMenu">Menu <i class="fa fa-bars"></i></a>

                    <ul class="menu">
                        <li><a href="#">Element 1</a></li>
                        <li><a href="#">Element 2 <i class="fa fa-chevron-down"></i></a>
                            <ul>
                                <li><a href="#">Sub-Element #1</a></li>
                                <li><a href="#">Sub-Element #2</a></li>
                                <li><a href="#">Sub-Element #3</a></li>
                                <li><a href="#">Sub-Element #4</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Element 3</a></li>
                        <li><a href="#">Element 4 <i class="fa fa-chevron-down"></i></a>
                            <ul>
                                <li><a href="#">Sub-Element #1</a></li>
                                <li><a href="#">Sub-Element #2</a></li>
                                <li><a href="#">Sub-Element #3</a></li>
                                <li><a href="#">Sub-Element #4</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Element 5</a></li>
                        <li><a href="#">Element 6</a></li>
                        <li><a href="#">Element 7 <i class="fa fa-chevron-down"></i></a>
                            <ul>
                                <li><a href="#">Sub-Element #1</a></li>
                                <li><a href="#">Sub-Element #2</a></li>
                                <li><a href="#">Sub-Element #3</a></li>
                                <li><a href="#">Sub-Element #4</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Element 8</a></li>
                    </ul>
            
        </div>
    </div>
</div>
    
   
</html>