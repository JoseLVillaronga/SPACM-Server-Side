<?php
require_once "config.php";
$query="SELECT * FROM prueba WHERE p_habilitado = 0 AND p_plataforma_nro = 0 ORDER BY p_id DESC LIMIT 100";
$res=Db::listar($query);
?>
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
								WHERE p_id IN (SELECT p_id FROM teccam.prueba WHERE p_habilitado = 0 AND p_plataforma_nro = 0 ORDER BY p_id DESC)
								AND lstk_id IS NOT NULL
								AND pl_id IN (SELECT lp_id FROM teccam.lote_prueba WHERE lo_id BETWEEN 101 AND 140)
								ORDER BY pr_id DESC
								LIMIT 1";
					$r1=Db::listar($queryR1);
	          		$r2=json_decode(file_get_contents("http://192.168.1.143/spacm-remito.php?id=".$r1[0]['lstk_id']));
					if(is_integer($r2->Procesado/40) OR $r2->Procesado==$r2->Total){
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
	          <tr style="<?php if($obj->getControlCalidad()=="1"){echo "background-color: #CDCECE;";} ?>" onclick="pruebaInfo('<?php echo $obj->getId(); ?>','');" title="Abrir Info (click ...)">
	            <td><?php echo $obj->getId(); ?></td>
	            <td><?php echo $obj->tipoPrueba->getNombre(); ?></td>
	            <td><?php echo $obj->getFechInicio(); ?></td>
	            <td>
	            	<?php
	            	if($obj->getHabilitado()=="1"){
	            		echo "<a class=\"waves-effect waves-light btn indigo\" title=\"Cierra prueba (click ...)\" onclick=\"location.href='tests-cierra.php?id=".$obj->getId()."'\">Cerrar</a>";
	            	}
	            	?>
	            </td>
	          </tr>
	          <tr ondblclick="pruebaCerrar(<?php echo $obj->getId(); ?>);" title="Cierra Info (doble click ...)">
	          	<td id="<?php echo $obj->getId(); ?>" colspan="4"></td>
	          </tr>

			<?php } ?>
	        </tbody>
	      </table>