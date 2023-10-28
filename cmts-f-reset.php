<?php
require_once 'config.php';
$queryCM="SELECT cmd_id,cmd_modelo FROM teccam.cable_modem_docsis ORDER BY cmd_modelo";
if($_SERVER['REQUEST_METHOD']=="POST"){
	$cm=$_POST['cm'];
	$pr=Db::listar("SELECT p_habilitado FROM teccam.prueba WHERE p_habilitado = 1");
	if(!empty($cm) AND count($pr)=="0"){
		$res=Db::listar("SELECT * FROM teccam.cable_modem_docsis WHERE cmd_id = ".$cm);
		$oid=$res[0]['cmd_oid1'];
		$valor=$res[0]['cmd_oid1_value'];
		$modems=cableModemsSPACM(traerModemsFromCmts(),traeIPCMs());
		$ips=array();
		foreach ($modems as $fila) {
			if($fila['Status']=="Operational"){
				$ips[]=$fila['IP DOCSIS'];
			}
		}
		foreach($ips as $key => $value){
			if($value!="0.0.0.0" AND !empty($value)){
				shell_exec("timeout 1 /usr/bin/nohup /usr/bin/snmpset -v 2c -c public ".$value." ".$oid." i ".$valor);
			}
		}
		$script="<script>window.close();</script>";
	}else{
		$script;
	}
}else{
	$cm;
	$script;
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>CMs Factory Reset</title>
</head>
<body>
	<form method="post">
	<table style="margin: auto; width: 400px;margin-top: 30px;border: solid 1px #000;text-align: center;">
		<tr>
			<td style="background-color: grey;color: white;font-size: 1.5em;">Factory Reset</td>
		</tr>
		<tr>
			<td style="min-height: 45px;">
				<select name="cm">
					<option value="">Seleccionar ...</option>
					<?php  
					foreach(Db::listar($queryCM) as $filaCM){ ?>
					<option value="<?php echo $filaCM['cmd_id']; ?>"><?php echo $filaCM['cmd_modelo']; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<td><input type="submit" value="Reset"></td>
		</tr>
	</table>
	</form>
	<?php echo $script; ?>
</body>
</html>