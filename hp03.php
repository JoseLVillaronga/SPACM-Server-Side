<?php
require_once 'config.php';
$lpId=$_GET['lpId'];
$estado=$_GET['estado'];
$fecha=$_GET['fecha'];
$usuario=$_GET['usuario'];
$con=new mysqli("192.168.81.21","jlvillaronga","teccamsql365","teccam");
$query="INSERT INTO `prueba_historico`
		(`lp_id`,
		`ps_id`,
		`ph_fecha`,
		`cli_usuario`)
		VALUES
		(".$lpId.",
		".$estado.",
		'".$fecha."',
		'".$usuario."')";
mysqli_query($con, $query);
$errorSql = mysqli_error($con);
$errorSql[]=mysqli_insert_id($con);
$con->close();
echo "[]";