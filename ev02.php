<?php
require_once 'config.php';
$id=$_GET['id'];
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
		0,
		1,
		:fecha,
		:usu)";
$stmt = $con -> prepare($query);
$stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
$stmt->bindParam(':usu', $id, PDO::PARAM_INT);
$stmt -> execute();
$errorSql = $stmt->errorInfo();
$res=json_encode($errorSql);
echo $res;