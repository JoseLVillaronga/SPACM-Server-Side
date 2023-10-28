<?php
require_once 'config.php';
$ip=$_GET['ip'];
$res=Db::listarLocal("SELECT * FROM docsis WHERE ip_host = '".$ip."' ORDER BY d_id DESC LIMIT 1");
$modems=array(
'MAC DOCSIS'=>$res[0]['mac_docsis'],
'IP DOCSIS'=>$res[0]['ip_docsis'],
'Rx Power en el CMTS'=>$res[0]['cmts_rx_power'],
'SNR en el CMTS'=>$res[0]['cmts_snr'],
'Microreflexiones'=>$res[0]['microreflexiones'],
'Status'=>$res[0]['status'],
'Version DOCSIS'=>$res[0]['version_docsis'],
'IP Host'=>$res[0]['ip_host']
);
$modems=json_encode($modems);
echo $modems;