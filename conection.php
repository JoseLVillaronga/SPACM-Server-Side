<?php

/**
 * @author Ogolfen
 * @copyright 2013
 */
require_once "include/geoiploc.php";
if(is_null($_SESSION['paisC'])){
	$ip = $_SERVER['REMOTE_ADDR'];
	$_SESSION['paisC'] = getCountryFromIP($ip,"code");
}
$host="127.0.0.1";
$usuario="dbuser";
$clave="dbpassword";
$base="cdr";
$port="3306";
if($_SERVER['SERVER_NAME']=="192.168.1.16" OR $_SERVER['SERVER_NAME']=="127.0.0.1"){
	$host="127.0.0.1";
	$port="3306";
}elseif($_SESSION['paisC'] == "ZZ" AND $_SERVER['SERVER_NAME']!="192.168.1.16"){
	$host="192.168.1.16";
	$port="3306";
}elseif($_SERVER['SERVER_NAME']=="vps.teccam.net"){
	$host="127.0.0.1";
	$port="3306";
}else{
	$lab=gethostbyname("laboratorio.teccam.net");
	$host=$lab;
	$_SESSION['Conexion']['Host']=$lab;
	$_SESSION['Conexion']['Port']="63406";
	$port="63406";
}
if($_SESSION['empresa'] == "7"){
	$base="test";
}elseif($_SESSION['empresa'] == "36"){
	$base="uy";
}
$db = mysqli_connect($host,$usuario,$clave,$base,$port);
mysqli_query($db,"SET NAMES 'utf8'");
if(!$db) {
	die("Error al conectar con MySQL");
	}
?>