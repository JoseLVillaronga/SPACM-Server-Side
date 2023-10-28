<?php
require_once 'config.php';
$modCM=$_GET['modCM'];
$empId=$_GET['empId'];
$query="SELECT * FROM teccam.cable_modem_docsis WHERE emp_id = ".$empId." AND cmd_modelo = '".$modCM."'";
$res=Db::listarServer($query);
$res=json_encode($res);
echo $res;