<?php
require_once 'config.php';
$pId=$_GET['pId'];
$lpId=$_GET['lpId'];
$connexion=new mysqli("192.168.81.21","jlvillaronga","teccamsql365","teccam");
$query="INSERT INTO `teccam`.`prueba_resultados_docsis`
		(`p_id`,
		`pl_id`)
		VALUES
		(".$pId.",
		".$lpId.")";
mysqli_query($connexion, $query);
$connexion->close();