<?php
require_once "config.php";
$auth=new Usuario($_SESSION['usuario']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Teccam S.R.L. SPACM</title>
	<link rel="shortcut icon" href="img/favicon.png">
    <link href="css/icon.css" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/<?php if($_SERVER['REQUEST_SCRIPT']=="/test-info2.php"){echo "materialize.min2.css";}else{echo "materialize.min.css";} ?>"  media="screen,projection"/>
    <!--Esrtilo propio-->
	<link href="css/style.css" rel="stylesheet">
    <script src="assets/js/bootstrap-collapse.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <link href="assets/js/google-code-prettify/prettify.css" rel="stylesheet">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body onload="modificar();<?php if($_SERVER['REQUEST_URI']=="/monitor.php"){echo "monitor();virtOper();";} ?>" onresize="modificar();" onkeydown="	if (event.keyCode == 27) window.open('','_self').close();" class="fondo9">
    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/<?php if($_SERVER['REQUEST_SCRIPT']=="/test-info2.php"){echo "materialize.min2.js";}else{echo "materialize.min.js";} ?>"></script>
    <script src="assets/js/google-code-prettify/prettify.js"></script>
    <script src="assets/js/application.js"></script>
    <script type="text/javascript" src="js/inicio-m.js"></script>
    <!--Resto de la página-->
    <!-- Dropdown Structure -->
	<ul id="dropdown1" class="dropdown-content" style="z-index: 30;">
	  <li><a href="tests-alta.php" class="waves-effect">Alta Tests</a></li>
	  <li><a href="tests-lista.php" class="waves-effect">Lista Tests</a></li>
	  <li><a href="test-remito2.php" class="waves-effect">Check Stock Activo</a></li>
	  <li><a href="pasa-devo.php?cant=0" class="waves-effect">Pasar a Devolución</a></li>
	</ul>
	<ul id="dropdown2" class="dropdown-content" style="z-index: 30;">
	  <li><a href="cmts.php" class="waves-effect">CMTS</a></li>
	  <li><a href="virt-estado.php" class="waves-effect">Estado Opers Virt</a></li>
	  <?php
	  if($_SESSION['usuario']=="jlvillaronga"){
	  	echo "<li><a href=\"cm-docsis-reg.php\" class=\"waves-effect\">Registro CM DOCSIS</a></li>";
	  }
	  ?>
	</ul>
	<ul id="dropdown3" class="dropdown-content" style="z-index: 30;">
	  <?php if($_SESSION['usuario']=="jlvillaronga"){echo "<li><a href=\"eventos-srv.php\" class=\"waves-effect\">Eventos SRV</a></li>";} ?>
	  <li><a href="eventos-virt.php" class="waves-effect">Eventos Virt</a></li>
	</ul>
	<!-- Menú Movil -->
	    <ul class="side-nav" id="mobile-demo">
			<li class="logo red accent-4" id="menu-lateral-logo">
				<div style="height: 100%;width: 100%;background-color: rgba(255,255,255,.6);">
	            	<object width="220" height="150" data="js/teccam.html" style="margin-left: 30px;"></object>
	            </div>
	        </li>
        <?php
        	if(!empty($_SESSION['usuario'])){
        		echo "<li><a href=\"search.php\"><i class=\"material-icons\">search</i></a></li>";
            	echo "<li><a href=\"index.php\">Inicio</a></li>";
				echo "<li>
				        <ul class=\"collapsible collapsible-accordion\">
				          <li>
				            <a class=\"collapsible-header waves-effect\" style=\"background-image: none;\">Mantenimiento<i class=\"material-icons\">arrow_drop_down</i></a>
				            <div class=\"collapsible-body\">
				              <ul>
				                <li><a href=\"cmts.php\" class=\"waves-effect\">CMTS</a></li>
				                <li><a href=\"virt-estado.php\" class=\"waves-effect\">Estado Opers Virt</a></li>";
						  if($_SESSION['usuario']=="jlvillaronga"){
						  	echo "<li><a href=\"cm-docsis-reg.php\" class=\"waves-effect\">Registro CM DOCSIS</a></li>";
						  }
				echo "</ul>
				            </div>
				          </li>
				        </ul>
			    	</li>";
				echo "<li>
				        <ul class=\"collapsible collapsible-accordion\">
				          <li>
				            <a class=\"collapsible-header waves-effect\" style=\"background-image: none;\">Tests<i class=\"material-icons\">arrow_drop_down</i></a>
				            <div class=\"collapsible-body\">
				              <ul>
				                <li><a href=\"tests-alta.php\" class=\"waves-effect\">Alta Tests</a></li>
				                <li><a href=\"tests-lista.php\" class=\"waves-effect\">Lista Tests</a></li>
				                <li><a href=\"test-remito2.php\" class=\"waves-effect\">Check Stock Activo</a></li>
				                <li><a href=\"pasa-devo.php?cant=0\" class=\"waves-effect\">Pasar a Devolución</a></li>
				              </ul>
				            </div>
				          </li>
				        </ul>
			    	</li>";
				if(!movile()){
					echo "<li><a href=\"monitor.php\">Monitor Opers Virt</a></li>";
				}else{
					echo "<li><a href=\"monitor.php\">Monitor Opers Virt</a></li>";
				}
				echo "<li>
				        <ul class=\"collapsible collapsible-accordion\">
				          <li>
				            <a class=\"collapsible-header waves-effect\" style=\"background-image: none;\">Eventos<i class=\"material-icons\">arrow_drop_down</i></a>
				            <div class=\"collapsible-body\">
				              <ul>
				                <li><a href=\"eventos-srv.php\" class=\"waves-effect\">Eventos SRV</a></li>
				                <li><a href=\"eventos-virt.php\" class=\"waves-effect\">Eventos Virt</a></li>
				              </ul>
				            </div>
				          </li>
				        </ul>
			    	</li>";
            }
        ?>
    </ul>
    <!-- Menú PC -->
    <div style="background-color: rgba(255,255,255,.65);">
    <div class="navbar-fixed">
        <nav class="indigo">
          <div class="nav-wrapper">
            <a href="logout.php" title="Log Out" class="brand-logo"><img id="logo-cartel" src="img/favicon.png"></a>
            <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <?php
                	//echo "<li><a href=\"javascript:window.open('test.php','_blank')\">Test</a></li>";
                	if(!empty($_SESSION['usuario'])){
                		echo "<li><a href=\"search.php\"><i class=\"material-icons\">search</i></a></li>";
                 		echo "<li><a href=\"index.php\">Inicio</a></li>";
						echo "<li style=\"z-index: 10;\"><a class=\"dropdown-button waves-effect waves-light\" href=\"#\" data-activates=\"dropdown2\">Mantenimiento<i class=\"material-icons right\">arrow_drop_down</i></a></li>";
						echo "<li style=\"z-index: 10;\"><a class=\"dropdown-button waves-effect waves-light\" href=\"#\" data-activates=\"dropdown1\">Tests<i class=\"material-icons right\">arrow_drop_down</i></a></li>";
						if(!movile()){
							echo "<li><a href=\"monitor.php\">Monitor Opers Virt</a></li>";
						}else{
							echo "<li><a href=\"monitor.php\">Monitor Opers Virt</a></li>";
						}
						echo "<li style=\"z-index: 10;\"><a class=\"dropdown-button waves-effect waves-light\" href=\"#\" data-activates=\"dropdown3\">Eventos<i class=\"material-icons right\">arrow_drop_down</i></a></li>";
					}
                ?>
            </ul>
          </div>
        </nav>
    </div>