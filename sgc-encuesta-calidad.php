<?php
require_once 'config.php';
$_SESSION['empresa']=$_GET['emp'];
$_SESSION['Conexion']['Base']=$_GET['base'];
if($_SERVER['SERVER_NAME']=="intranet.teccam.net" OR $_SERVER['SERVER_NAME']=="laboratorio.teccam.net" OR $_SERVER['SERVER_NAME']=="vps.teccam.net" OR $_SERVER['SERVER_NAME']=="127.0.0.1"){
	$_SESSION['Conexion']['Host']="127.0.0.1";
	$_SESSION['Conexion']['Port']="3306";
}else{
	$laboratorio=gethostbyname("laboratorio.teccam.net");
	$_SESSION['Conexion']['Host']=$laboratorio;
	$_SESSION['Conexion']['Port']="63406";
}
require_once "include/geoiploc.php";
if(is_null($_SESSION['paisC'])){
  $ip = $_SERVER['REMOTE_ADDR'];
  $_SESSION['paisC'] = getCountryFromIP($ip,"code");
}
require 'conection.php';
$auth=new Usuario($_SESSION['usuario']);
$titulo = ".: TECCAM SRL | Encuesta de Calidad :.";
$bodyId = "aplicaciones";
$_SESSION['bid'] = $bodyId;
$_SESSION['redirect'] = "sgc-encuesta-calidad.php";
require 'header.php';
$queryV="SELECT * FROM sgc_encuesta_values";
$vl=Db::listar($queryV);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$id=$_POST['id'];
	$preguntas=explode(",", $_POST['preguntas']);
	$nombre=$_POST['nombre'];
	$apellido=$_POST['apellido'];
	$cargo=$_POST['cargo'];
	$valores=$_POST['valores'];
	$encuesta=new SgcEncuesta($id);
	foreach($_POST['valores'] as $keyX => $valueX){
		$test[]=$valueX['valor'];
	}
	if(in_array("0", $test)){
		$mensaje="Faltó completar la encuesta ...";
	}else{
		foreach($_POST['valores'] as $key1 => $value1){
			$encuesta->loteEncuesta->setEncId($encuesta->getId());
			$encuesta->loteEncuesta->setNombre($nombre);
			$encuesta->loteEncuesta->setApellido($apellido);
			$encuesta->loteEncuesta->setCargo($cargo);
			$encuesta->loteEncuesta->setFecha(date('Y-m-d H:i:s'));
			$encuesta->loteEncuesta->setPregunta($value1['pregunta']);
			$encuesta->loteEncuesta->setValor($value1['valor']);
			$encuesta->loteEncuesta->agregaADb();
		}
		$mensaje="Encuesta grabada correctamente ...";
	}

	
}elseif($_SERVER['REQUEST_METHOD'] == 'GET'){
	$id=$_GET['id'];
	$preguntas=explode(",", $_GET['pr']);
	$nombre;
	$apellido;
	$cargo;
	$valores;
	$encuesta=new SgcEncuesta($id);
}
$mensajeBaja="Esta encuesta ya caduco, muchas gracias ...";
function mBaja($encuesta){
	if($encuesta->valida){
		echo "display:none;";
	}
}
function baja($encuesta){
	if(!$encuesta->valida){
		echo "display:none;";
	}
}
?>
						<main id="main" class="container row">
                        	  <form method="post" id="formulario">
                        	  	<input type="hidden" name="id" value="<?php echo $id; ?>" />
                        	  		<input type="hidden" name="preguntas" value="<?php echo implode(",", $preguntas); ?>" />
                        	  	<table width="490" align="center" style="border:1px solid grey;">
									<tr style="color: white;background-color: grey;height: 35px;">
										<td colspan="2">Encuesta de Calidad</td>
									</tr>
									<?php
									foreach($preguntas as $key => $value){ 
									$obj=new SgcPregunta($value);
									?>
									<tr style="height: 55px;border-bottom: dotted grey;<?php baja($encuesta); ?>">
										<td><input type="hidden" value="<?php echo $value; ?>" name="valores[<?php echo $key; ?>][pregunta]" /><?php echo $obj->getNombre(); ?></td>
										<td>
											<select name="valores[<?php echo $key; ?>][valor]">
												<option value="0">Seleccionar ...</option>
												<?php
												foreach($vl as $fila){ ?>
												<option value="<?php echo $fila["encv_id"]; ?>"><?php echo $fila["encv_descripcion"]; ?></option>
												<?php } ?>
											</select>
										</td>
									</tr><?php } ?>
									<tr style="height: 55px;<?php baja($encuesta); ?>border-bottom: dotted grey;">
										<td>Nombre</td>
										<td><input type="text" name="nombre" value="<?php echo $nombre; ?>" style="width: 80%;" /></td>
									</tr>
									<tr style="height: 55px;<?php baja($encuesta); ?>border-bottom: dotted grey;">
										<td>Apellido</td>
										<td><input type="text" name="apellido" value="<?php echo $apellido; ?>" style="width: 80%;" /></td>
									</tr>
									<tr style="height: 55px;<?php baja($encuesta); ?>border-bottom: dotted grey;">
										<td>Cargo</td>
										<td><input type="text" name="cargo" value="<?php echo $cargo; ?>" style="width: 80%;" /></td>
									</tr>
									<tr style="height: 85px;<?php mBaja($encuesta); ?>">
										<td colspan="2"><em style="color: green;font-size: 18px;"><?php echo $mensajeBaja; ?></em></td>
									</tr>
									<tr style="height: 55px;<?php baja($encuesta); ?>">
										<td colspan="2">
								          	<a id="scale-demo" href="#!" class="btn-floating btn-large scale-transition">
								          		<i class="material-icons waves-effect waves-light" onclick="document.forms['formulario'].submit();" title="Enviar">send</i>
								          	</a>
										</td>
									</tr>
                        	  	</table>
                        	  </form>
                        	  <br />
<?php
//echo "<pre>";
//echo $id."<br /><br />";
//$encuesta=new SgcEncuesta($id);
//print_r($encuesta->loteEncuesta->errorSql);
echo "<br /><em style='color:green;'>".$mensaje."</em>";
//echo $pr."<br />".$val."<br />";
//var_dump($encuesta->loteEncuesta);
//echo "</pre>";
?>
                        	  
                      	        </p>
						</main>
<?php 
include 'footer.php';
?>