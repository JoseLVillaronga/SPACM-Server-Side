<?php
require_once 'config.php';
$connexion=new mysqli("192.168.81.21","jlvillaronga","teccamsql365","teccam");
$modems=cableModemsSPACM(traerModemsFromCmts(),traeIPCMs());
$query4="";
$ip="10.41.193.3";
foreach($modems as $filaCMTS){
	$ip2=explode(".",$filaCMTS['IP Host']);
	$ip2=intval($ip2[0]).".".intval($ip2[1]).".".intval($ip2[2]).".".intval($ip2[3]);
	if($ip==str_replace(" &nbsp","",$filaCMTS['IP Host'])){
		$query4="UPDATE teccam.prueba_resultados_docsis
				SET
				pr_mac_docsis = '".$filaCMTS['MAC DOCSIS']."',
				pr_ip_docsis = '".$filaCMTS['IP DOCSIS']."',
				pr_cmts_rx_power = '".$filaCMTS['Rx Power en el CMTS']."',
				pr_cmts_snr = '".$filaCMTS['SNR en el CMTS']."',
				pr_microreflexiones = '".$filaCMTS['Microreflexiones']."',
				pr_status = '".$filaCMTS['Status']."',
				pr_version_docsis = '".$filaCMTS['Version DOCSIS']."',
				pr_ip_host = '".$filaCMTS['IP Host']."'
				WHERE p_id = 87 AND pl_id = 400";
	}
}
mysqli_query($connexion, $query4);
echo "<pre>";
echo $query4."<br><br>";
print_r($modems);
echo "<br>";
echo $ip;
echo "</pre>";
