<?php
header("Content-Type: text/html; charset=utf-8");
ini_set('max_execution_time', 3600);
ini_set('max_input_time', -1);
ini_set('memory_limit', '-1');
ini_set("session.cookie_lifetime","43200");
ini_set("session.gc_maxlifetime","43200");
date_default_timezone_set('America/Argentina/Buenos_Aires');
session_start();
error_reporting(E_ALL ^ E_NOTICE  ^ E_WARNING);
require_once 'PHPExcel/Classes/PHPExcel.php';
require_once 'Net/SSH2.php';
require_once 'Math/BigInteger.php';
require_once 'Crypt/Hash.php';
require_once 'Crypt/Rijndael.php';
include_once "ARIA/lib/core.inc.php";
include_once "ARIA/lib/Routeros_Api.php";
function miAutoCargador($nombreClase){
	require_once ("clases/" . $nombreClase . ".php");
}
spl_autoload_register('miAutoCargador');

$const=Db::listarLocal("SELECT * FROM constantes");
$_SESSION['nombre']=$const[0]['nombre'];
$_SESSION['cmts']=$const[0]['cmts'];
$_SESSION['vlan']=$const[0]['vlan'];
$_SESSION['usu_id']=$const[0]['usu_id'];

function movile(){
	if(strstr($_SERVER['HTTP_USER_AGENT'],"Android")){
		return true;
	}elseif(strstr($_SERVER['HTTP_USER_AGENT'],"iphone") OR strstr($_SERVER['HTTP_USER_AGENT'],"iPhone")){
		return true;
	}elseif(strstr($_SERVER['HTTP_USER_AGENT'],"ipod")){
		return true;
	}elseif(strstr($_SERVER['HTTP_USER_AGENT'],"ipad")){
		return true;
	}elseif(strstr($_SERVER['HTTP_USER_AGENT'],"XBLWP7")){
		return true;
	}else{
		return false;
	}
}
function navegador(){
	if(strstr($_SERVER['HTTP_USER_AGENT'],"Mozilla")){
		return true;
	}elseif(strstr($_SERVER['HTTP_USER_AGENT'],"Chrome")){
		return true;
	}else{
		return false;
	}
}

function dataCmFromCmts($ipcm, $maccm)
{
	$salir=array();
	if(!$dataCmtsFromIP=dataCmtsFromIP($ipcm)) return($salir);	
	$ret=snmp_limpiar(@snmpget($dataCmtsFromIP['ip'], $dataCmtsFromIP['comunidad'], 'DOCS-IF-MIB::docsIfCmtsCmPtr.'.macToDec($maccm)));
	if(is_numeric($ret) and $ret>0) 
	{
		$salir['value']=snmp_limpiar(snmpget($dataCmtsFromIP['ip'], $dataCmtsFromIP['comunidad'], 'DOCS-IF-MIB::docsIfCmtsCmStatusValue.'.$ret));
		$salir['mac']=snmp_limpiar(snmpget($dataCmtsFromIP['ip'], $dataCmtsFromIP['comunidad'], 'DOCS-IF-MIB::docsIfCmtsCmStatusMacAddress.'.$ret));
		$salir['ip']=snmp_limpiar(snmpget($dataCmtsFromIP['ip'], $dataCmtsFromIP['comunidad'], 'DOCS-IF-MIB::docsIfCmtsCmStatusIpAddress.'.$ret));
		$salir['snr']=snmp_limpiar(snmpget($dataCmtsFromIP['ip'], $dataCmtsFromIP['comunidad'], 'DOCS-IF-MIB::docsIfCmtsCmStatusSignalNoise.'.$ret));
		$salir['docsis']=snmp_limpiar(snmpget($dataCmtsFromIP['ip'], $dataCmtsFromIP['comunidad'], 'DOCS-IF-MIB::docsIfCmtsCmStatusDocsisRegMode.'.$ret));
		//$salir['rx']=snmp_limpiar(snmpget($dataCmtsFromIP['ip'], $dataCmtsFromIP['comunidad'], 'DOCS-IF-MIB::docsIfCmtsCmStatusRxPower.'.$ret));
	}
	return($salir);
}
function dataCmtsFromIP($ip)
{
	$temp=explode('.', $ip);
	switch ($temp[0].'.'.$temp[1]) {
		case '10.40': return(array("ip"=>$_SESSION['cmts'], 'comunidad'=>'sdfs87234bt'));
	}
	return false;
}
function macSinDots($mac_con_dots) {
	$mac_con_dots=explode(":",$mac_con_dots);
	$mac_sin_dots="";
	for ($i=0;$i<sizeof($mac_con_dots);$i++) {
		if(strlen($mac_con_dots[$i])==2) $mac_sin_dots.=$mac_con_dots[$i];
		else $mac_sin_dots.="0".$mac_con_dots[$i];
	}
	return($mac_sin_dots);
}
function macToDec($maccm)
{
	$tempmac =hexdec($maccm[0].$maccm[1]);
	$tempmac.=".".hexdec($maccm[2].$maccm[3]);
	$tempmac.=".".hexdec($maccm[4].$maccm[5]);
	$tempmac.=".".hexdec($maccm[6].$maccm[7]);
	$tempmac.=".".hexdec($maccm[8].$maccm[9]);
	$tempmac.=".".hexdec($maccm[10].$maccm[11]);
	return($tempmac);
}


function traerCpeFromCmts()
{
	$salir=array();
	//snmpbulkwalk -v2c -c public 10.100.2.252 -mall 
	$array=@snmp2_real_walk($_SESSION['cmts'] ,"public", "RDN-CMTS-MIB::rdnCmToCpeIpAddress");
	if(is_array($array))
	{
		while (list($key, $valor) = each ($array)) 
		{ 
			$temp=explode('.', $key);
			if(isset($temp[2])) 
			{
				@$salir[$temp[1]].= snmp_limpiar($valor)." ";
			}
		}
	}
	return($salir);
}
function ipHostDHCP($mac,$ARRAY){
	//$arrayDHCP;
	foreach($ARRAY as $hosts){
		$arr=explode(":",$hosts['agent-remote-id']);
		$check=array();
		$arr2=explode("/",substr($hosts['agent-circuit-id'],17,25));
		$arr2=$arr2[0];
		$arr2=explode("-",$arr2);
		foreach($arr as $key => $value){
			if(strlen($value)=="1"){
				//$check[]="0".$value;
				array_push($check,"0".$value);
			}else{
				//$check[]=$value;
				array_push($check,$value);
			}
		}
		$check2=array();
		foreach($arr2 as $key2 => $value2){
			if(strlen($value2)=="1"){
				array_push($check2,"0".$value2);
			}else{
				array_push($check2,$value2);
			}
		}
		$check=implode("", $check);
		$check2=implode("", $check2);
		if($check==$mac OR $check2==$mac){
			return $hosts['address'];
		}
	}
	//return $arrayDHCP;
}
function ipMTA($ip){
	$des=snmpwalkoid($ip, "public", ".1.3.6.1.2.1.4.20.1.1");
	$cpe="";
	foreach($des as $key => $value){
	    if(strpos($value,"10.41.192") OR strpos($value,"10.38.192")){}else{continue;}
	    $cpe.=str_replace("IpAddress: ", "", $value)." &nbsp;";
	}
	return $cpe;
}
function serialCM($ip){
	//$a=new SNMP(SNMP::VERSION_1, $ip, "public");
	$des=snmp_get($ip,".1.3.6.1.2.1.69.1.1.4.0");
	return $des;
}


function traerModemsFromCmts()
{
	$salir=array();
	//snmpbulkwalk -v2c -c public 10.100.2.252 -mall 
	$array=@snmp2_real_walk($_SESSION['cmts'] ,"public", "DOCS-IF-MIB::docsIfCmtsCmStatusTable");
	if(is_array($array))
	{
		$i=0;$last="DOCS-IF-MIB::docsIfCmtsCmStatusMacAddress";
		foreach ($array as $key => $valor)
		{ 
			$temp=explode('.', $key);
			if($temp[0]!=$last) 
			{
				$i++;
				$last=$temp[0];
			}
			$salir[$temp[1]-1][$i]=snmp_limpiar($valor);
			$salir[$temp[1]-1][$i+1]=$temp[count($temp)-1];
		}
	}
	return($salir);
}
function traerModemsFromCmts2()
{
	$salir=array();
	//snmpbulkwalk -v2c -c public 10.100.2.252 -mall 
	$array=@snmp2_real_walk($_SESSION['cmts'] ,"public", "DOCS-IF-MIB::docsIfCmtsCmStatusTable");
	if(is_array($array))
	{
		$i=0;$last="DOCS-IF-MIB::docsIfCmtsCmStatusMacAddress";
		while (list($key, $valor) = each ($array)) 
		{ 
			$temp=explode('.', $key);
			if($temp[0]!=$last) 
			{
				$i++;
				$last=$temp[0];
			}
			$salir[$temp[1]-1][$i]=snmp_limpiar($valor);
			$salir[$temp[1]-1][$i+1]=$temp[count($temp)-1];
		}
	}
	return($salir);
}
function traerLogFromCM($ip)
{
	$salir=array();
	//snmpbulkwalk -v2c -c public 10.100.2.252 -mall 
	$array=@snmp2_real_walk($ip ,"public", ".1.3.6.1.2.1.69.1.5.8.1","1000000","7");
	//print_r($array);
	if(is_array($array))
	{

		$i=0;$last="DOCS-IF-MIB::docsIfCmtsCmStatusMacAddress";
		while (list($key, $valor) = each ($array)) 
		{ 
			$temp=explode('.', $key);
			if($temp[0]!=$last) 
			{
				$i++;
				$last=$temp[0];
			}
			$salir[$temp[1]-1][$i]=snmp_limpiar($valor);
			$salir[$temp[1]-1][$i+1]=$temp[count($temp)-1];
		}

	}
        echo "<pre>";
        print_r($modems);
        echo "</pre>";
	//print_r($salir);
	return($salir);
}
function horaHexadecimalAISO($hexstring){
	$hexstring=array_filter(explode(" ", trim($hexstring)));

//$hexstring="\x07\xDF\x06\x0C\x0F\x14\x23\x00";

  $date = "";

  //$p = unpack( "H*", $hexstring[0].$hexstring[1] );  // year (2 byte)
  $date .= hexdec( $hexstring[0].$hexstring[1] )."-";

  //$p = unpack( "H*", intval($hexstring[2]) );  // month (1 byte)
  $date .= sprintf( "%02s", hexdec( $hexstring[2] ) )."-";

  //$p = unpack( "H*", $hexstring[3] );   // day (1 byte)
  $date .= sprintf( "%02s", hexdec( $hexstring[3] ) )." ";

  //$p = unpack( "H*", intval($hexstring[4]) );  // hour (1 byte)
  $date .= sprintf( "%02s", hexdec( $hexstring[4] ) ).":";

  //$p = unpack( "H*", $hexstring[5] );  // minute (1 byte)
  $date .= sprintf( "%02s", hexdec( $hexstring[5] ) ).":";
  $date .= sprintf( "%02s", hexdec( $hexstring[6] ) ).",";
  $date .= sprintf( "%02s", hexdec( $hexstring[7] ) );

  return $date;
}
function tipoDeAlertaNumerico($numero){
	if($numero==1){
		return "Alerta";
	}elseif($numero==2){
		return "Crítico";
	}elseif($numero==3){
		return "Error";
	}elseif($numero==4){
		return "Peligro";
	}elseif($numero==5){
		return "Aviso";
	}elseif($numero==6){
		return "Información";
	}elseif($numero==7){
		return "Depuración";
	}elseif($numero==0){
		return "Emergencia";
	}
}
function traerLogFromCM2($ip)
{
	$salir=array();
	//snmpbulkwalk -v2c -c public 10.100.2.252 -mall 
	$array=@snmp2_real_walk($ip ,"public", ".1.3.6.1.2.1.69.1.5.8.1","1000000","7");
	//print_r($array);
	if(is_array($array))
	{
			
		$hora=array();
		$texto=array();
		$tipo=array();
		$num=array();
		foreach ($array as $key => $value) {
			if(strstr($key, "SNMPv2-SMI::mib-2.69.1.5.8.1.2")){
				$hora[]=$value;
			}
			if(strstr($key, "SNMPv2-SMI::mib-2.69.1.5.8.1.7")){
				$texto[]=htmlspecialchars($value);
			}
			if(strstr($key, "SNMPv2-SMI::mib-2.69.1.5.8.1.5")){
				$tipo[]=$value;
			}
			if(strstr($key, "SNMPv2-SMI::mib-2.69.1.5.8.1.3")){
				$num[]=explode(".",$key)[7];
			}
		}
		$i=0;
		$resultado=array();
		foreach ($hora as $fila) {
			$texto2=explode(":",$texto[$i]);
			$texto3=$texto2[1];
			if(isset($texto2[2])){$texto3.=$texto2[2];}
			if(isset($texto2[3])){$texto3.=$texto2[3];}
			if(isset($texto2[4])){$texto3.=$texto2[4];}
			if(isset($texto2[5])){$texto3.=$texto2[5];}
			if(isset($texto2[6])){$texto3.=$texto2[6];}
			if(isset($texto2[7])){$texto3.=$texto2[7];}
			if(isset($texto2[8])){$texto3.=$texto2[8];}
			if(isset($texto2[9])){$texto3.=$texto2[9];}
			if(isset($texto2[10])){$texto3.=$texto2[10];}
			if(isset($texto2[11])){$texto3.=$texto2[11];}
			if(isset($texto2[12])){$texto3.=$texto2[12];}
			if(isset($texto2[13])){$texto3.=$texto2[13];}
			if(isset($texto2[14])){$texto3.=$texto2[14];}
			if(isset($texto2[15])){$texto3.=$texto2[15];}
			if(isset($texto2[16])){$texto3.=$texto2[16];}
			if(isset($texto2[17])){$texto3.=$texto2[17];}
			if(isset($texto2[18])){$texto3.=$texto2[18];}
			if(isset($texto2[19])){$texto3.=$texto2[19];}
			$resultado[]=array(
				"Hora"=>horaHexadecimalAISO(explode(":",$hora[$i])[1]),
				"Texto"=>$texto3,
				"Tipo"=>tipoDeAlertaNumerico(trim(explode(":",$tipo[$i])[1])),
				"ID"=>$num[$i]
			);
			$i=$i+1;
		}

	}
        //echo "<pre>";
        //print_r($resultado);
        //echo "</pre>";
	//print_r($salir);
	return($resultado);
}
function ping($host, $port, $timeout) 
{ 
  $tB = microtime(true); 
  $fP = fSockOpen($host, $port, $errno, $errstr, $timeout); 
  if (!$fP) { return "down"; } 
  $tA = microtime(true); 
  return round((($tA - $tB) * 1000), 0)." ms"; 
}
function traeIPCMs(){
	$API = new Routeros_Api();
	$API->debug = false;
	if ($API->connect('192.168.81.1', 'admin', 'teccammt0810')){
		$API->write('/ip/dhcp-server/lease/print');
		$READ = $API->read(false);
		$ARRAY = $API->parse_response($READ);
		$API->disconnect();
		return $ARRAY;
	}else{
		$ARRAY[]['agent-remote-id']="";
		return $ARRAY;
	}
}
function cableModemsSPACM($modems=array(),$ARRAY){
	foreach ($modems as $modem) {
		if($modem[7]=="8" OR $modem[7]=="registrationComplete(6)"){$modem[7]="Operational";}
		if($modem[16]=="3" OR $modem[13]=="docsis11(2)"){
		  $modem[13]="v. 2";
		}elseif($modem[16]=="4"){
		  $modem[13]="v. 3";
		}else{
		  $modem[13]="v. 1";
		}
		if(strlen($modem[0])>4){
			$m[]=array("MAC DOCSIS" => macSinDots($modem[0]),
					   "IP DOCSIS" => $modem[1],
					   "Rx Power en el CMTS" => $modem[4],
					   "SNR en el CMTS" => $modem[11],
					   "Microreflexiones" => $modem[12],
					   "Status" => $modem[7],
					   "Version DOCSIS" => $modem[13],
					   "IP Host" => ipHostDHCP(macSinDots($modem[0]), $ARRAY)
					  );
		}
	}
	return $m;
}
function cmDataSPACM($ip){
	if(!empty($ip)){
		$session = new SNMP(SNMP::VERSION_1, $ip, "public");
		$tx=explode(":",$session->get("SNMPv2-SMI::transmission.127.1.2.2.1.3.2"));
		$rx=explode(":",$session->get("SNMPv2-SMI::transmission.127.1.1.1.1.6.3"));
		$time=explode(":",$session->get(".1.3.6.1.2.1.1.3.0"));
		$sysName=explode(":",$session->get(".1.3.6.1.2.1.1.5.0"));
		$sysDesc=explode(":",htmlspecialchars($session->get(".1.3.6.1.2.1.1.1.0")));
		$firmware=explode(":",$session->get(".1.3.6.1.2.1.69.1.3.5.0"));
		$mer=explode(":", $session->get("SNMPv2-SMI::transmission.127.1.1.4.1.5.3"));
		$pc_link=explode(":",$session->get("IF-MIB::ifOperStatus.1"));
		$usb_link=explode(":", $session->get("IF-MIB::ifOperStatus.5"));
		$frec_ds=explode(":", $session->get("SNMPv2-SMI::transmission.127.1.1.1.1.2.3"));
		$frec_us=explode(":", $session->get("SNMPv2-SMI::transmission.127.1.1.2.1.2.4"));
		$nroSerie=explode(":", $session->get(".1.3.6.1.2.1.69.1.1.4.0"));
		$data=array("Uptime"=>$time[1].":".$time[2].":".$time[3],
		"SysName"=>$sysName[1],
		"SysDesc"=>$sysDesc[1]." :".$sysDesc[2]." :".$sysDesc[3]." :".$sysDesc[4]." :".$sysDesc[5]." :".$sysDesc[6],
		"Firmware"=>$firmware[1],
		"TX"=>$tx[1],
		"RX"=>$rx[1],
		"MER"=>$mer[1],
		"Link PC"=>$pc_link[1],
		"Link USB"=>$usb_link[1],
		"Frec DS"=>$frec_ds[1],
		"Frec US"=>$frec_us[1],
		"Nro.Serie"=>$nroSerie[1]);
		return $data;		
	}else{
		$data=array("Uptime"=>null,
		"SysName"=>null,
		"SysDesc"=>null,
		"Firmware"=>null,
		"TX"=>null,
		"RX"=>null,
		"MER"=>null,
		"Link PC"=>null,
		"Link USB"=>null,
		"Frec DS"=>null,
		"Frec US"=>null,
		"Nro.Serie"=>null);
		return $data;
	}
}
