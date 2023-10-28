<?php
require_once 'config.php';
$ot=$_GET['ot'];
$mensaje=$_GET['mensaje'];
$p_id=$_GET['p_id'];
$lp_id=$_GET['lp_id'];
$connexion=new mysqli("192.168.81.21","jlvillaronga","teccamsql365","teccam");
$query="UPDATE teccam.prueba_resultados_docsis
		SET
		pr_firmware = '".utf8_decode($mensaje)."',
		pr_ot = ".$ot."
		WHERE p_id = ".$res[0]->p_id." AND pl_id = ".$res[0]->lp_id;
mysqli_query($connexion, $query);
$connexion->close();
echo "OK";
