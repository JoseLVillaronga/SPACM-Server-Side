<?php
require_once 'config.php';

//unset($_SESSION['paisC']);
//unset($_SESSION['auth']);
//unset($_SESSION['nombre']);
//unset($_SESSION['usuario']);
//unset($_SESSION['empresa']);
//unset($_SESSION['grupo']);
//unset($_SESSION['Conexion']);

$telnet = new PHPTelnet();
//echo "<pre>";
//print_r($_SESSION);
//echo "<br />";
// if the first argument to Connect is blank,
// PHPTelnet will connect to the local host via 127.0.0.1
$result = $telnet->Connect('10.100.2.252','admin','admin');

if ($result == 0) {
	$telnet->DoCommand("\n", $result);
	$telnet->DoCommand("\n", $result);
	// NOTE: $result may contain newlines
	$telnet->DoCommand('enable', $result);
	$telnet->DoCommand('admin', $result);
	//echo $result;
	// NOTE: $result may contain newlines
	$telnet->DoCommand('system reboot', $result);
//	$result=str_replace("show cable modem\n", "", $result);
//	$result=str_replace("Interface     Prim Connect    Timing Rec   Ip Address      Mac Address\n", "", $result);
//	$result=str_replace("              Sid  State      Offset Power                            \n", "", $result);
//	$result=str_replace("\nn", "", (str_replace("MOT#", "", $result)));
//	echo str_replace("\rr", "", $result);
	// say Disconnect(0); to break the connection without explicitly logging out
	$telnet->DoCommand('y', $result);
//	$telnet->DoCommand('logout', $result);
	echo str_replace("\r","",str_replace("\n","",str_replace("                        ","",str_replace("                                                ","",$result)))).", ".date('Y-m-d H:i:s').",\n";
	//$telnet->Disconnect();
	//echo "</pre>";
	sleep(3);
	header("location: cmts.php");
	exit;
}else{
	//echo "<pre>";
	print_r($result).", ".date('Y-m-d H:i:s').",\n";
	sleep(3);
	header("location: cmts.php");
	exit;
	//echo "</pre>";
}
?>