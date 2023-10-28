<?php
require_once 'config.php';
$ip=$_GET['ip'];
$queryD="SELECT * FROM docsis WHERE ip_host = '".$ip."' ORDER BY d_id DESC LIMIT 1";
$modems=Db::listarServer($queryD);
$res=json_encode($modems);
echo $res;