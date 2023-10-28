<?php
require_once "config.php";
if(!empty($_SESSION['usuario'])){
    $usu=new Usuario($_SESSION['usuario']);
}else{
	header("location: login.php");
	exit;
}
if($_SERVER['REQUEST_METHOD']=="POST"){
	$tipoPrueba=$_POST['tipoPrueba'];
	$opers=$_POST['opers'];
	$controlCalidad=$_POST['controlCalidad'];
	$cantPuertos=$_POST['cantPuertos'];
	if(strlen($opers[0]) > 4){
		$opers=explode(",", $opers[0]);
	}
	$p=new Prueba(null);
	$p->tipoPrueba=new TipoPrueba($tipoPrueba);
	$p->setFechaInicio(date("Y-m-d H:i:s"));
	if($controlCalidad=="1"){
		$p->setControlCalidad(1);
	}else{
		$p->setControlCalidad(0);
	}
	$p->setUsuario($_SESSION['usuario']);
	$p->setHabilitado("1");
	$p->setCantidadEthernet($cantPuertos);
	$mensaje="";
	$query="SELECT * FROM teccam.prueba WHERE p_habilitado = 1 AND p_plataforma_nro = 0";
	$c=Db::listar($query);
	if(count($c)=="0"){
		$p->agregaADb();
		if($p->errorSql['0'] == "00000"){
			$p->lotePrueba=new LotePrueba($p->getId());
			//$check=array();
			$queryCK="SELECT lo_id FROM prueba AS p,lote_prueba AS lp WHERE p.p_id = lp.p_id AND p_habilitado = 1 AND lo_id BETWEEN 101 AND 140";
			$resCK=Db::listar($queryCK);
			$check=array();
			foreach($resCK as $filaCK){
				$check[]=$filaCK['lo_id'];
			}
			$con=new mysqli("192.168.81.21","jlvillaronga","teccamsql365","teccam");
			$con2=new mysqli("192.168.81.21","jlvillaronga","teccamsql365","teccam");
			foreach($opers as $key => $value){
				$usu=$_SESSION['usuario'];
				$estado=1;
				if(!in_array($value, $check)){
					$fe=date("Y-m-d H:i:s");
					$query="INSERT INTO `lote_prueba`
							(`lp_id`,
							`p_id`,
							`lo_id`,
							`lp_fecha`,
							`cli_usuario`,
							`ps_id`)
							VALUES
							(null,
							".$p->getId().",
							".$value.",
							'".$fe."',
							'".$usu."',
							".$estado.")";
					mysqli_query($con, $query);
					$lpId=mysqli_insert_id($con);
					//$p->lotePrueba->setLotePorId(mysqli_insert_id($con));
					//$p->lotePrueba->historico->agregaADb();
					
					
					$query2="INSERT INTO `prueba_historico`
							(`lp_id`,
							`ps_id`,
							`ph_fecha`,
							`cli_usuario`)
							VALUES
							(".$lpId.",
							".$estado.",
							'".$fe."',
							'".$usu."')";
					mysqli_query($con2, $query2);
				}
			}
			$con->close();
			$con2->close();
			header("location: eventos-virt.php");
			exit;
		}
	}else{
		$mensaje="No se puede grabar hasta no cerrar el Test abierto ...";
	}
}else{
	$tipoPrueba;
	$opers=array();
	$controlCalidad=0;
}
require_once "header.php";
?>
    <main class="container" id="content" style="background-color: rgba(255,255,255,.4);">
        <h4>Tests ALTA</h4>
        <h6 style="padding: 10px;">Bien venid@ <?php echo $usu->getNombre()." ".$usu->getApellido(); ?></h6>
        <div class="col s12 m6" onkeydown="if (event.keyCode == 13) document.forms['formulario'].submit();">
        <form name="form1" id="formulario" method="post">
        	<div class="row">
        		<div class="input-field col s12 m6">
        			<select placeholder="Tipo de Prueba" id="tipoPrueba" class="validate" name="tipoPrueba">
        				<option>Seleccionar ...</option>
        				<?php foreach(Db::listar("SELECT * FROM tipo_prueba WHERE tp_id NOT IN (5)") as $filaTP){ ?>
        				<option value="<?php echo $filaTP['tp_id']; ?>"><?php echo $filaTP['tp_nombre']; ?></option>
        				<?php } ?>
        			</select>
        			<label for="tipoPrueba">Tipo de Prueba</label>
        		</div>
        		<div class="input-field col s12 m6">
					<select multiple placeholder="Operarios Virtuales" id="opers" class="validate" name="opers[]">
        				<?php
		        		foreach (Db::listar("SELECT usu_id FROM lista_opers WHERE lo_id BETWEEN 101 AND 140") as $fila5) {
							$valore[]=$fila5['usu_id'];
						}
						$valore=implode(",", $valore);
		        		?>
		        		<option value="<?php echo $valore; ?>">Todas ...</option>
		        		<?php 
		        		$query2="SELECT * FROM lista_opers WHERE lo_id BETWEEN 101 AND 140";
		        		foreach (Db::listar($query2) as $fila2) { ?>
		        		<option value="<?php echo $fila2['usu_id']; ?>"><?php echo $fila2['lo_nombre']; ?></option>
		        		<?php } ?>
        			</select>
        			<label for="opers">Operarios Virtuales</label>
        		</div>
        		<div class="input-field col s12 m6">
        			<select placeholder="Cantidad de puertos" id="cantPuertos" class="validate" name="cantPuertos">
        				<option value="1">Uno</option>
        				<option value="2">Dos</option>
        				<option value="3">Tres</option>
        				<option value="4">Cuatro</option>
        			</select>
        			<label for="cantPuertos">Cantidad de Puertos</label>
        		</div>
        		<div class="input-field col s12 m6">
        			<input placeholder="Control de Calidad" type="checkbox" value="1" class="validate" id="controlCalidad" <?php if($controlCalidad=="1"){echo "CHECKED";} ?> name="controlCalidad">
        			<label for="controlCalidad">Control de Calidad</label>
        		</div>
		        <div class="input-field col s12">
			       	<a id="scale-demo" href="#!" class="btn-floating btn-large scale-transition">
			   		<i class="material-icons waves-effect waves-light indigo" onclick="document.forms['formulario'].submit();" title="Enviar">send</i>
			    	</a>
			    </div>
        	</div>
        </form>
        </div>
        <div style="color: red;font-weight: bolder;text-align: center;">
        <?php
        echo $mensaje;
        //echo "<pre>";
		//print_r($opers);
		//echo "<br>";
		/* if(is_object($p->lotePrueba)){
			print_r($p->errorSql);
		}*/
		//echo "</pre>";
        ?>
        </div>
    </main>
<?php
require_once "footer.php";
?>