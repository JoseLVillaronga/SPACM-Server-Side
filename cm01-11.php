<?php
require_once 'config.php';
$p_id=$_GET['p_id'];
$lp_id=$_GET['lp_id'];
$ot=$_GET['ot'];
$connexion=new mysqli("192.168.81.21","jlvillaronga","teccamsql365","teccam");
$query="UPDATE teccam.prueba_resultados_docsis
		SET
		pr_fecha_final = '".date("Y-m-d H:i:s")."',
		pr_ot = ".$ot."
		WHERE p_id = ".$p_id." AND pl_id = ".$lp_id;
mysqli_query($connexion, $query);
$error=mysqli_error($connexion);
$connexion->close();
echo json_encode($error);