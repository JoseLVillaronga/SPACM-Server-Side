<?php
require_once 'config.php';
$query="SELECT * FROM cdr.empresas";
$res=Db::listarCDR($query);
if(count($res) > 10){
	$connexion=new mysqli("192.168.81.21","jlvillaronga","teccamsql365","teccam");
	$query3="TRUNCATE teccam.empresas";
	$query2="INSERT INTO `teccam`.`empresas`
			(`emp_id`,
			`emp_razon_social`,
			`emp_cuit`,
			`emp_direccion`,
			`emp_telefono`,
			`emp_categoria`,
			`emp_email`,
			`emp_web`,
			`emp_contacto_comercial`,
			`emp_tel_cc`,
			`emp_email_cc`,
			`emp_contacto_administrativo`,
			`emp_tel_ca`,
			`emp_email_ca`)
			VALUES ";
	foreach($res as $fila){
		$res2[]="(".$fila['emp_id'].",
			'".utf8_decode($fila['emp_razon_social'])."',
			'".utf8_decode($fila['emp_cuit'])."',
			'".utf8_decode($fila['emp_direccion'])."',
			'".utf8_decode($fila['emp_telefono'])."',
			'".utf8_decode($fila['emp_categoria'])."',
			'".utf8_decode($fila['emp_email'])."',
			'".utf8_decode($fila['emp_web'])."',
			'".utf8_decode($fila['emp_contacto_comercial'])."',
			'".utf8_decode($fila['emp_tel_cc'])."',
			'".utf8_decode($fila['emp_email_cc'])."',
			'".utf8_decode($fila['emp_contacto_administrativo'])."',
			'".utf8_decode($fila['emp_tel_ca'])."',
			'".utf8_decode($fila['emp_email_ca'])."')";
	}
	$query2.=implode(",", $res2);
	mysqli_query($connexion, $query3);
	mysqli_query($connexion, $query2);
	$connexion->close();
}