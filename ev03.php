<?php
require_once 'config.php';
$ax=$_GET['ax'];
$usu=json_decode($_GET['usu']);
$fecha=date("Y-m-d H:i:s");
foreach($usu as $key => $value){
	$con=Conexion::conectarServer();
	$fecha=date('Y-m-d H:i:s');
	$query="INSERT INTO evento
			(ev_id,
			ev_activo,
			ax_id,
			ev_fecha,
			usu_id)
			VALUES
			(null,
			1,
			:ajax,
			:fecha,
			:usu)";
	$stmt = $con -> prepare($query);
	$stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
	$stmt->bindParam(':ajax', $ax, PDO::PARAM_INT);
	$stmt->bindParam(':usu', $value, PDO::PARAM_INT);
	$stmt -> execute();
	$errorSql = $stmt->errorInfo();
}
$res=json_encode($errorSql);
echo $res;
