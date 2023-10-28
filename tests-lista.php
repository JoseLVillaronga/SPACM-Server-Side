<?php
require_once "config.php";
$mac;
$mac=$_GET['mac'];
if(!empty($_SESSION['usuario'])){
    $usu=new Usuario($_SESSION['usuario']);
}else{
	header("location: login.php");
	exit;
}
if(!empty($mac)){
	$query="SELECT * FROM prueba 
			WHERE p_id IN (SELECT p_id FROM prueba_resultados_docsis WHERE pr_mac_docsis = '".$mac."')
			AND p_plataforma_nro = 0
			ORDER BY p_id DESC";
}else{
	$query="SELECT * FROM prueba WHERE p_habilitado = 1 AND p_plataforma_nro = 0 ORDER BY p_id DESC LIMIT 100";
}

$res=Db::listar($query);
require_once "header.php";
?>
    <main class="container row" id="content" style="background-color: rgba(255,255,255,.4);">
        <h4 class="col s12 m12">Tests LISTA</h4>
        <h6 style="padding: 10px;"><div class="col s12">Bien venid@ <?php echo $usu->getNombre()." ".$usu->getApellido(); ?></div>
        </h6>
        <div style="text-align: center;" class="input-field col s12 m6">
			<input value="" style="width: 60%;" onkeydown="if (event.keyCode == 13) document.getElementById('scale-demo').click();" placeholder="Nro. MAC" id="serie" type="text" class="validate" name="serie">
			<label for="serie">MAC</label>
          	&nbsp;&nbsp;&nbsp;&nbsp;<a id="scale-demo" href="javascript:void(0)" onclick="location.href='tests-lista.php?mac='+document.getElementById('serie').value" class="btn-floating btn-large scale-transition indigo">
			    <i class="material-icons waves-effect waves-light" title="Enviar">search</i>
			</a>
        </div>
        <div style="text-align: center;" class="input-field col s12 m6">
        	<a class="waves-effect waves-light btn  indigo" href="javascript:void(0)" onclick="pruebaTipo();">Abiertas</a>
        	<a class="waves-effect waves-light btn  indigo" href="javascript:void(0)" onclick="pruebaTipo2();">Cerradas</a>
        	<a class="waves-effect waves-light btn  indigo" href="javascript:void(0)" onclick="pruebaTipo3();">Todas</a>
        </div>
        <div id="prueba">
	      <table class="centered highlight">
	        <thead>
	          <tr>
	              <th>ID</th>
	              <th>Tipo de Prueba</th>
	              <th>Fecha de Inicio</th>
	              <th>Cierra Prueba</th>
	          </tr>
	        </thead>
	
	        <tbody>
	          <tr>
	          	<td colspan="4">
	          		<table class="centered highlight" style="background-color: #BFE788;">
	          		<?php
	          		$queryR1="SELECT lstk_id FROM teccam.prueba_resultados_docsis 
								WHERE p_id IN (SELECT p_id FROM teccam.prueba WHERE p_habilitado = 1 ORDER BY p_id DESC)
								AND lstk_id IS NOT NULL AND lstk_id <> 0
								AND pl_id IN (SELECT lp_id FROM teccam.lote_prueba WHERE lo_id BETWEEN 101 AND 140)
								ORDER BY pr_id DESC
								LIMIT 1";
					$r1=Db::listar($queryR1);
	          		$r2=json_decode(file_get_contents("http://192.168.1.18/spacm-remito.php?id=".$r1[0]['lstk_id']));
					if(is_integer($r2->Procesado/40)){
						$colorInfo="green;";
					}else{
						$colorInfo="red;";
					}
	          		?>
	          			<thead>
	          				<tr style="font-size: 1.2em;font-weight: bold;">
	          					<td>Remito Nro.</td>
	          					<td>Total</td>
	          					<td>No Procesados</td>
	          					<td>Procesados</td>
	          				</tr>
	          			</thead>
	          			<tbody>
	          				<tr>
	          					<td style="font-size: 1.3em; font-weight: bold;"><?php echo $r2->RemitoNro; ?></td>
	          					<td><?php echo $r2->Total; ?></td>
	          					<td><?php echo $r2->NoProcesado; ?></td>
	          					<td style="font-weight: bolder;font-size: 2em;color: <?php echo $colorInfo; ?>"><?php echo $r2->Procesado; ?></td>
	          				</tr>
	          			</tbody>
	          		</table>
	          	</td>
	          </tr>
	        <?php  
	        foreach($res as $fila){ 
	        $obj=new Prueba($fila['p_id']);
	        ?>
	          <tr style="<?php if($obj->getControlCalidad()=="1"){echo "background-color: #CDCECE;";} ?>" onclick="pruebaInfo('<?php echo $obj->getId(); ?>','<?php echo $mac; ?>');" title="Abrir Info (click ...)">
	            <td style="background-color: "><?php echo $obj->getId(); ?></td>
	            <td><?php echo $obj->tipoPrueba->getNombre(); ?></td>
	            <td><?php echo $obj->getFechInicio(); ?></td>
	            <td><a class="waves-effect waves-light btn indigo" title="Cierra prueba (click ...)" onclick="location.href='tests-cierra.php?id=<?php echo $obj->getId(); ?>'">Cerrar</a></td>
	          </tr>
	          <tr ondblclick="pruebaCerrar(<?php echo $obj->getId(); ?>);" title="Cierra Info (doble click ...)">
	          	<td id="<?php echo $obj->getId(); ?>" colspan="4"></td>
	          </tr>
			<?php } ?>
	        </tbody>
	      </table>
	    </div>
        <p> </p>
    </main>
    <script>
    	document.getElementById('serie').focus();
    </script>
<?php
require_once "footer.php";
?>