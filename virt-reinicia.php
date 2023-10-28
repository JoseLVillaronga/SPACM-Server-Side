<?php
require_once 'config.php';
if(!empty($_SESSION['usuario'])){
    $usu=new Usuario($_SESSION['usuario']);
}else{
	header("location: login.php");
	exit;
}
$id=$_GET['id'];
$ev=new Evento($usu);
$ev->activar("1",array($id));
header("location: virt-estado.php");
exit;