<?php
require_once 'config.php';
$id=$_GET['id'];
$pId=$_GET['pId'];
$ovId=$_GET['ovId'];
$fecha=$_GET['fecha'];
$usuario=$_GET['usuario'];
$estado=$_GET['estado'];
$con=new mysqli("192.168.81.21","jlvillaronga","teccamsql365","teccam");
$query = "UPDATE `lote_prueba`
			SET
			`lp_id` = ".$id.",
			`p_id` = ".$pId.",
			`lo_id` = ".$ovId.",
			`lp_fecha` = '".$fecha."',
			`cli_usuario` = '".$usuario."',
			`ps_id` = ".$estado."
			WHERE `lp_id` = ".$id;
mysqli_query($con, $query);
$errorSql = mysqli_error($con);
$con->close();
echo "[]";