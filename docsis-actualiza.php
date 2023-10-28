<?php
require_once 'config.php';
$modems=cableModemsSPACM(traerModemsFromCmts(),traeIPCMs());
$con=new mysqli("192.168.81.21","jlvillaronga","teccamsql365","teccam");
$query="INSERT INTO teccam.docsis
(mac_docsis,
ip_docsis,
cmts_rx_power,
cmts_snr,
microreflexiones,
status,
version_docsis,
ip_host,
d_fecha) VALUES ";
foreach($modems as $fila){
	if($fila['Status']=="Operational"){
		$query2[]="
		('".$fila['MAC DOCSIS']."',
		'".$fila['IP DOCSIS']."',
		'".$fila['Rx Power en el CMTS']."',
		'".$fila['SNR en el CMTS']."',
		'".$fila['Microreflexiones']."',
		'".$fila['Status']."',
		'".$fila['Version DOCSIS']."',
		'".$fila['IP Host']."',
		'".date("Y-m-d H:i:s")."') ";
	}
}
$query.=implode(",", $query2);
mysqli_query($con, $query);
$con->close();