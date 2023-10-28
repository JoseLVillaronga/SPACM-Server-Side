<?php
require_once 'config.php';
$_SESSION['usuario']="jlvillaronga";
$evento=new EventoSRV();
$evento->ejecutar();
