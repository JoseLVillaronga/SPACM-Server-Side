<?php
require_once 'config.php';
$usu=new Usuario($_SESSION['usuario']);
$obj=new Prueba($_GET['id']);
$obj->setFechaFinal(date("Y-m-d H:i:s"));
$obj->setHabilitado("0");
$obj->actualizaDb();
$ev=new Evento($auth);
$virt="101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140";
$virt=explode(",", $virt);
$ev->activar("6",$virt);
header("location: tests-lista.php");
exit;