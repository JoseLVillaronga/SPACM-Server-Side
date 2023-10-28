<?php
require_once 'config.php';
if(!empty($_SESSION['usuario']) AND $_SESSION['usuario']=="jlvillaronga"){
    $usu=new Usuario($_SESSION['usuario']);
}else{
	header("location: login.php");
	exit;
}
if($_SERVER['REQUEST_METHOD']=="POST"){
	$id=$_POST['id'];
	$obj=new CMDocsis($id);
	$modelo=$_POST['modelo'];
	$firmware=$_POST['firmware'];
	$firmware2=$_POST['firmware2'];
	$firmwareFile=$_POST['firmwareFile'];
	$firmwareFile2=$_POST['firmwareFile2'];
	$wifi5g=$_POST['wifi5g'];
	$wifi2g=$_POST['wifi2g'];
	$mta=$_POST['mta'];
	$oid1=$_POST['oid1'];
	$oid1v=$_POST['oid1v'];
	$empId=$_POST['empId'];
	$obj->setModelo($modelo);
	$obj->setFirmware($firmware);
	$obj->setFirmwareFile($firmwareFile);
	$obj->setFirmware2($firmware2);
	$obj->setFirmwareFile2($firmwareFile2);
	$obj->setWifi5G($wifi5g);
	$obj->setWifi2G($wifi2g);
	$obj->setMTA($mta);
	$obj->setOID1($oid1);
	$obj->setOID1Value($oid1v);
	$obj->setEmpId($empId);
	$obj->actualizaDb();
	if($obj->errorSql['0']=="00000"){
		header("location: cm-docsis-reg.php");
		exit;
	}
}else{
	$id=$_GET['id'];
	$obj=new CMDocsis($id);
	$modelo=$obj->getModelo();
	$firmware=$obj->getFirmware();
	$firmware2=$obj->getFirmware2();
	$firmwareFile=$obj->getFirmwareFile();
	$firmwareFile2=$obj->getFirmwareFile2();
	$wifi5g=$obj->getWifi5G();
	$wifi2g=$obj->getWifi2G();
	$mta=$obj->getMTA();
	$oid1=$obj->getOID1();
	$oid1v=$obj->getOID1Value();
	$empId=$obj->getEmpId();
}
require_once "header.php";
?>
    <main class="container row" id="content" style="background-color: rgba(255,255,255,.4);">
        <h4 style="text-align: center;">Editar Cable Modems DOCSIS</h4>
        <br>
        <h6 style="padding: 10px;">Bien venid@ <?php echo $usu->getNombre()." ".$usu->getApellido(); ?></h6>
        <form method="post" id="formulario">
		<div class="input-field col s12 m6">
			<input type="text" id="modelo" name="modelo" value="<?php echo $modelo; ?>">
			<label for="modelo">Modelo ...</label>
			<input type="hidden" name="id" value="<?php echo $id; ?>">
		</div>
		<div class="input-field col s12 m6">
			<input type="text" id="firmware" name="firmware" value="<?php echo $firmware; ?>">
			<label for="firmware">Firmware ...</label>
		</div>
		<div class="input-field col s12 m6">
			<input type="text" id="firmware2" name="firmware2" value="<?php echo $firmware2; ?>">
			<label for="firmware2">Firmware 2 ...</label>
		</div>
		<div class="input-field col s12 m6">
			<input type="text" id="firmwareFile" name="firmwareFile" value="<?php echo $firmwareFile; ?>">
			<label for="firmwareFile">Firmware File ...</label>
		</div>
		<div class="input-field col s12 m6">
			<input type="text" id="firmwareFile2" name="firmwareFile2" value="<?php echo $firmwareFile2; ?>">
			<label for="firmwareFile">Firmware File 2 ...</label>
		</div>
		<div class="input-field col s12 m6">
        	<select placeholder="empId" id="empId" class="validate" name="empId">
        		<?php  
        		foreach(Db::listar("SELECT * FROM empresas ORDER BY emp_razon_social") as $filaEmp){ ?>
        		<option value="<?php echo $filaEmp['emp_id']; ?>" <?php if($filaEmp['emp_id']==$empId){echo "SELECTED";} ?>><?php echo $filaEmp['emp_razon_social']; ?></option>
        		<?php } ?>
        	</select>
			<label for="empId">Cliente ...</label>
		</div>
		<div class="input-field col s12 m6">
        	<select placeholder="wifi5g" id="wifi5g" class="validate" name="wifi5g">
        		<option value="0">No</option>
        		<option value="1" <?php if($wifi5g=="1"){echo "SELECTED";} ?>>Si</option>
        	</select>
			<label for="wifi5g">Tiene WiFi 5G ...</label>
		</div>
		<div class="input-field col s12 m6">
        	<select placeholder="wifi2g" id="wifi2g" class="validate" name="wifi2g">
        		<option value="0">No</option>
        		<option value="1" <?php if($wifi2g=="1"){echo "SELECTED";} ?>>Si</option>
        	</select>
			<label for="wifi5g">Tiene WiFi 2G ...</label>
		</div>
		<div class="input-field col s12 m6">
        	<select placeholder="mta" id="mta" class="validate" name="mta">
        		<option value="0">No</option>
        		<option value="1" <?php if($mta=="1"){echo "SELECTED";} ?>>Si</option>
        	</select>
			<label for="mta">Tiene MTA ...</label>
		</div>
		<div class="input-field col s12 m6">
			<input type="text" id="oid1" name="oid1" value="<?php echo $oid1; ?>">
			<label for="oid1">OID 1 ...</label>
		</div>
		<div class="input-field col s12 m6">
        	<select placeholder="oid1v" id="oid1v" class="validate" name="oid1v">
        		<option value="0">Elegir ...</option>
        		<option value="1" <?php if($oid1v=="1"){echo "SELECTED";} ?>>1</option>
        		<option value="2" <?php if($oid1v=="2"){echo "SELECTED";} ?>>2</option>
        		<option value="3" <?php if($oid1v=="3"){echo "SELECTED";} ?>>3</option>
        		<option value="4" <?php if($oid1v=="4"){echo "SELECTED";} ?>>4</option>
        	</select>
			<label for="oid1v">OID 1 Value ...</label>
		</div>
		<div class="input-field col s12 m6">
	          <a id="scale-demo" href="#!" class="btn-floating btn-large scale-transition green">
				 <i id="add" class="material-icons waves-effect waves-light" onclick="document.forms['formulario'].submit();" title="Grabar">send</i>
			  </a>
		</div>
		</form>
    </main>
<?php
require_once "footer.php";
?>