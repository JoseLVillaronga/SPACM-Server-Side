<?php
require_once 'config.php';
if(!empty($_SESSION['usuario']) AND $_SESSION['usuario']=="jlvillaronga"){
}else{
	header("location: login.php");
	exit;
}
$id=$_GET['id'];
$obj=new CMDocsis($id);
$obj->borraPorId($id);
header("location: cm-docsis-reg.php");
exit;