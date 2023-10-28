<?php
class Equipo {
	var $ip; var $mac; var $caido; var $servicio; var $error;
	var $sysObjectID; var $sysDescr; var $sysUpTime; var $sysName;    
	var $snmp_mibs;
	var $mibs; // Array con las mibs
	var $mibs_value; // Array con las value de las mibs

	function __construct($ip, $mac='', $poolear=true) {
		$this->ip=$ip;
		$this->mac=$mac;
		if(!$poolear) { return; }
		if(!$this->sysObjectID=snmp_get($ip, ".1.3.6.1.2.1.1.2.0")) 
			{ $this->caido=1; return; }

		if(!$this->sysDescr=snmp_get($ip, ".1.3.6.1.2.1.1.1.0")) 
			{ $this->caido=1; return; }

		if($this->sysUpTime=snmp_get($ip, ".1.3.6.1.2.1.1.3.0")) {
			$this->sysUpTime = explode(") ", $this->sysUpTime);
			$this->sysUpTime = str_replace("day", "d", $this->sysUpTime[1]);
		} else $this->sysUpTime='';

		if(!$this->sysName=snmp_get($ip, ".1.3.6.1.2.1.1.5.0")) 
			$this->sysName='';

		$this->caido=0;
//		$this->sysDescr = explode (" ",$this->sysDescr);
//		$this->sysDescr = $this->sysDescr[0].(isset($this->sysDescr[1])?" ".$this->sysDescr[1]:'');

		$this->mibs['Correcteds']='SNMPv2-SMI::transmission.127.1.1.4.1.3.3';
		$this->mibs['DocsisCap']='DOCS-IF-MIB::docsIfDocsisBaseCapability.0';
		$this->mibs['DocsisOper']='DOCS-IF-MIB::docsIfCmStatusDocsisOperMode.2';
		$this->mibs['Freq_BW_DS']='SNMPv2-SMI::transmission.127.1.1.1.1.3.3';
		$this->mibs['Freq_BW_US']='SNMPv2-SMI::transmission.127.1.1.2.1.3.4';
		$this->mibs['Freq_DS']='SNMPv2-SMI::transmission.127.1.1.1.1.2.3';
		$this->mibs['Freq_US']='SNMPv2-SMI::transmission.127.1.1.2.1.2.4';
		$this->mibs['LostSyncs']='SNMPv2-SMI::transmission.127.1.2.2.1.5.2';
		$this->mibs['MAC_1']='interfaces.ifTable.ifEntry.ifPhysAddress.1';
		$this->mibs['MAC_2']='interfaces.ifTable.ifEntry.ifPhysAddress.2';
		$this->mibs['MAC_PC']='SNMPv2-SMI::mib-2.17.4.3.1.1';
		$this->mibs['MER']='SNMPv2-SMI::transmission.127.1.1.4.1.5.3';
		$this->mibs['MicroRef']='SNMPv2-SMI::transmission.127.1.1.4.1.6.3';
		$this->mibs['OSVersion']='SNMPv2-SMI::mib-2.69.1.3.5.0';
		$this->mibs['QOS_DS']='SNMPv2-SMI::transmission.127.1.1.3.1.5';
		$this->mibs['QOS_US']='SNMPv2-SMI::transmission.127.1.1.3.1.3';
		$this->mibs['RX_level']='SNMPv2-SMI::transmission.127.1.1.1.1.6.3';
		$this->mibs['Resets']='SNMPv2-SMI::transmission.127.1.2.2.1.4.2';
		$this->mibs['TX_level']='SNMPv2-SMI::transmission.127.1.2.2.1.3.2';
		$this->mibs['TxTimingOffset']='SNMPv2-SMI::transmission.127.1.1.2.1.6.4';
		$this->mibs['Uncorrectables']='SNMPv2-SMI::transmission.127.1.1.4.1.4.3';
		$this->mibs['Unerroreds']='SNMPv2-SMI::transmission.127.1.1.4.1.2.3';
		$this->mibs['equipo']='';
		$this->mibs['id_mib']='';
		$this->mibs['inoctets']='IF-MIB::ifOutOctets.2';
		$this->mibs['link_doble']='NULL';
		$this->mibs['link_pc']='IF-MIB::ifOperStatus.1';;
		$this->mibs['link_usb']='IF-MIB::ifOperStatus.5';;
		$this->mibs['nombre']='';
		$this->mibs['objectid']='';
		$this->mibs['outoctets']='';
		$this->mibs["MAC_1"]="interfaces.ifTable.ifEntry.ifPhysAddress.1";
		$this->mibs["MAC_2"]="interfaces.ifTable.ifEntry.ifPhysAddress.2";
	}

	function equipo($ip, $mac='', $poolear=true) {
		$this->ip=$ip;
		$this->mac=$mac;
		if(!$poolear) { return; }
		if(!$this->sysObjectID=snmp_get($ip, "system.sysObjectID.0")) 
			{ $this->caido=1; return; }

		if(!$this->sysDescr=snmp_get($ip, "system.sysDescr.0")) 
			{ $this->caido=1; return; }

		if($this->sysUpTime=snmp_get($ip, "system.sysUpTime.0")) {
			$this->sysUpTime = explode(") ", $this->sysUpTime);
			$this->sysUpTime = str_replace("day", "d", $this->sysUpTime[1]);
		} else $this->sysUpTime='';

		if(!$this->sysName=snmp_get($ip, "system.sysName.0")) 
			$this->sysName='';

		$this->caido=0;
//		$this->sysDescr = explode (" ",$this->sysDescr);
//		$this->sysDescr = $this->sysDescr[0].(isset($this->sysDescr[1])?" ".$this->sysDescr[1]:'');

		$this->mibs['Correcteds']='SNMPv2-SMI::transmission.127.1.1.4.1.3.3';
		$this->mibs['DocsisCap']='DOCS-IF-MIB::docsIfDocsisBaseCapability.0';
		$this->mibs['DocsisOper']='DOCS-IF-MIB::docsIfCmStatusDocsisOperMode.2';
		$this->mibs['Freq_BW_DS']='SNMPv2-SMI::transmission.127.1.1.1.1.3.3';
		$this->mibs['Freq_BW_US']='SNMPv2-SMI::transmission.127.1.1.2.1.3.4';
		$this->mibs['Freq_DS']='SNMPv2-SMI::transmission.127.1.1.1.1.2.3';
		$this->mibs['Freq_US']='SNMPv2-SMI::transmission.127.1.1.2.1.2.4';
		$this->mibs['LostSyncs']='SNMPv2-SMI::transmission.127.1.2.2.1.5.2';
		$this->mibs['MAC_1']='interfaces.ifTable.ifEntry.ifPhysAddress.1';
		$this->mibs['MAC_2']='interfaces.ifTable.ifEntry.ifPhysAddress.2';
		$this->mibs['MAC_PC']='SNMPv2-SMI::mib-2.17.4.3.1.1';
		$this->mibs['MER']='SNMPv2-SMI::transmission.127.1.1.4.1.5.3';
		$this->mibs['MicroRef']='SNMPv2-SMI::transmission.127.1.1.4.1.6.3';
		$this->mibs['OSVersion']='SNMPv2-SMI::mib-2.69.1.3.5.0';
		$this->mibs['QOS_DS']='SNMPv2-SMI::transmission.127.1.1.3.1.5';
		$this->mibs['QOS_US']='SNMPv2-SMI::transmission.127.1.1.3.1.3';
		$this->mibs['RX_level']='SNMPv2-SMI::transmission.127.1.1.1.1.6.3';
		$this->mibs['Resets']='SNMPv2-SMI::transmission.127.1.2.2.1.4.2';
		$this->mibs['TX_level']='SNMPv2-SMI::transmission.127.1.2.2.1.3.2';
		$this->mibs['TxTimingOffset']='SNMPv2-SMI::transmission.127.1.1.2.1.6.4';
		$this->mibs['Uncorrectables']='SNMPv2-SMI::transmission.127.1.1.4.1.4.3';
		$this->mibs['Unerroreds']='SNMPv2-SMI::transmission.127.1.1.4.1.2.3';
		$this->mibs['equipo']='';
		$this->mibs['id_mib']='';
		$this->mibs['inoctets']='IF-MIB::ifOutOctets.2';
		$this->mibs['link_doble']='NULL';
		$this->mibs['link_pc']='IF-MIB::ifOperStatus.1';;
		$this->mibs['link_usb']='IF-MIB::ifOperStatus.5';;
		$this->mibs['nombre']='';
		$this->mibs['objectid']='';
		$this->mibs['outoctets']='';
		$this->mibs["MAC_1"]="interfaces.ifTable.ifEntry.ifPhysAddress.1";
		$this->mibs["MAC_2"]="interfaces.ifTable.ifEntry.ifPhysAddress.2";
	}
	
	function es_caido() {
		if ($this->caido==1) return(1);
		return(0);
	}

	function snmp($variable, $timeout=250000, $reintentos=2) {
		if ($this->caido) return ("Caido");

		if (!isset($this->mibs["$variable"])) {
			//return("-1");
			return("No disponible");
		} elseif($this->mibs["$variable"]=="") {
			//return("-1");
			return("No disponible");
		}

		if (isset($this->mibs_value["$variable"])) {
			return($this->mibs_value["$variable"]);
		}

		switch ($variable) {
			case "TX_level":
			case "RX_level":

				$snmp = snmp_get($this->ip, $this->mibs["$variable"]);
				if(strpos($snmp, " dBmV") == false) $snmp/=10;
				else $snmp=str_replace(" dBmV", '', $snmp);
				$this->mibs_value["$variable"]=$snmp+0;
				return($this->mibs_value["$variable"]);

			case "QOS_DS":
			case "QOS_US":

				$snmp = snmp_walk($this->ip,$this->mibs["$variable"]);
				if(isset($snmp[0])) {

					$this->mibs_value["$variable"]=@$snmp[0];
					return(@$snmp[0]);
				} else { //Si no respondi� el QoS
					$pooleador = "/home/demian/equipos/pooleo_equipos.out mib ".$this->ip." ".COMM_DOCSIS." DOCS-QOS-MIB::docsQosParamSetMaxTrafficRate 1";
//					aca ($pooleador);
					$respuesta=array();
      		      	exec ($pooleador,$respuesta);
				  	list ($key, $val) = each ($respuesta);
				  	$temp=split(';',$val);
				  	//aca ($temp);
				  	$valor = array();
				  	if (sizeof($temp)==5){
					  	$valor[0]=$temp[3];
					  	$valor = snmp_limpiar($valor);
					  	if ($variable =="QOS_US"){ // Donwstream
					      $this->mibs_value["$variable"]=$valor[0];
					      //aca ($this->mibs_value["$variable"]);
					      return($valor[0]);
					   }
					   if ($variable =="QOS_DS"){  //Upstream
						  	$temp[2]=str_replace("active","provisioned",$temp[2]);	
						  	//aca ($temp[2]);			   
					      	$pooleador = "/home/demian/equipos/pooleo_equipos.out mib ".$this->ip." ".COMM_DOCSIS." ".$temp[2]." 1";
					      	//aca ($pooleador);
					      	exec ($pooleador,$respuesta);
				  		  	list ($key, $val) = each ($respuesta);
				  		  	$temp=split(';',$val);
					        if (sizeof($temp)==5){
					  			$valor[0]=$temp[3];
					  			$valor = snmp_limpiar($valor);
					  			$this->mibs_value["$variable"]=$valor[0];
					      		return($valor[0]);
					        }
					   }
				  	}
				  	else{
				  		return('');	
				  	}

					return('');					
				}

			case "Freq_DS":
			case "Freq_US":
				$snmp = snmp_get($this->ip,$this->mibs["$variable"]);
				if ($snmp>1000000) $snmp=($snmp/1000000);
				if ($snmp>1000) $snmp=($snmp/1000);
				$snmp=round($snmp,2);
				$snmp.=" MHz";
				$this->mibs_value["$variable"]=$snmp;
				return($snmp);

			case "MER":
				$snmp = snmp_get($this->ip,$this->mibs["$variable"]);
				$snmp=($snmp/10);
				$snmp=round($snmp,2);
	//			$snmp.=" MHz";
				$this->mibs_value["$variable"]=$snmp;
				return($snmp);

			case "DocsisCap": case "DocsisOper":
			case "Unerroreds": case "Correcteds": case "Uncorrectables":
			case "MicroRef":
			case "OSVersion":
				$snmp = snmp_get($this->ip, $this->mibs["$variable"]);
				$this->mibs_value["$variable"]=$snmp;
				return($snmp);

			case "Freq_BW_DS":
				$snmp = snmp_get($this->ip,$this->mibs["$variable"]);
				$this->mibs_value["$variable"]=$snmp;
				return($snmp);
			case "Freq_BW_US":
				$snmp = snmp_get($this->ip,$this->mibs["$variable"]) ;
				$this->mibs_value["$variable"]=$snmp;
				return($snmp);
			case "MAC_PC":
				$snmp_mac = snmp_walk($this->ip,$this->mibs["$variable"]);

				$snmp_mac_return='';

				for($i=0;$i<sizeof($snmp_mac);$i++) {
					
//			if(hex_a_txt($snmp_mac[$i])!=$this->mac) 
//					if(substr(hex_a_txt($snmp_mac[$i]),0,11)!=substr($this->mac),0,11)) 
					if(isset($snmp_mac[$i])) {
						if(hex_a_txt($snmp_mac[$i])!=$this->mac and hex_a_txt($snmp_mac[$i])!='0030eb800302' and hex_a_txt($snmp_mac[$i])!='0030eb800304') {
							$snmp_mac_return.=hex_a_txt($snmp_mac[$i])." ";
						}
					}
				}
				$this->mibs_value["$variable"]=$snmp_mac_return;
				return($snmp_mac_return);
				//return(hex_a_txt($snmp_mac[0]));
				
			case "MAC_1":
			case "MAC_2":
				$snmp = mac_sin_dots(snmp_get($this->ip, $this->mibs["$variable"]));
				$this->mibs_value["$variable"]=$snmp;
				return($snmp);

			case "link_doble":
			case "link_pc":
			case "link_usb":
				$snmp = snmp_get($this->ip,$this->mibs["$variable"]);
				if(strstr($snmp,"dormant")) $snmpr="Dormant";
				elseif(strstr($snmp,"up")) $snmpr="Up";
				elseif(strstr($snmp,"down")) $snmpr="Down";
				else $snmpr="-1";
				$this->mibs_value["$variable"]=$snmpr;

				return($snmpr);

			case "inoctets":
			case "outoctets":
				$snmp = snmp_get($this->ip, $this->mibs["$variable"], $timeout, $reintentos);
				$this->mibs_value["$variable"]=$snmp;
				return($snmp);

			default:
				return ("ERROR");
		}
	}

	function get_sysDescr() {
		if ($this->caido) return;
		return($this->sysDescr);
	}
	
	function get_sysName() {
		if ($this->caido) return;
		return($this->sysName);
	}

	function get_sysUpTime() {
		if ($this->caido) return;
		return($this->sysUpTime);
	}

	function get_sysObjectID() {
		if ($this->caido) return;
		return($this->sysObjectID);
	}

}