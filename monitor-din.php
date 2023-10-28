<?php
require_once 'config.php';
$query="SELECT lp_id,lp.p_id,lo_id,lp_fecha,p.cli_usuario,lp.ps_id,ps_color,ps_nombre FROM lote_prueba AS lp,prueba_estado AS pe,prueba AS p WHERE lp.ps_id = pe.ps_id AND lp.p_id = p.p_id AND p_habilitado = 1 AND lo_id BETWEEN 101 AND 140 AND lp_id NOT IN (SELECT pl_id FROM prueba_resultados_docsis WHERE pr_ot = 1) ORDER BY lo_id";
$res=Db::listar($query);
$qTerminadosOK="SELECT lp_id,lp.p_id,lo_id,lp_fecha,p.cli_usuario,lp.ps_id,ps_color,ps_nombre 
FROM lote_prueba AS lp,prueba_estado AS pe,prueba AS p 
WHERE lp.ps_id = pe.ps_id 
AND lp.p_id = p.p_id 
AND p_habilitado = 1 
AND lo_id BETWEEN 101 AND 140
AND lp_id IN (SELECT pl_id FROM prueba_resultados_docsis WHERE pr_ot = 1)
AND lp_id NOT IN (SELECT pl_id FROM prueba_resultados_docsis WHERE pr_ot = 0) 
AND lp.ps_id = 3
ORDER BY lo_id";
$qTerminadosNoOK="SELECT lp_id,lp.p_id,lo_id,lp_fecha,p.cli_usuario,lp.ps_id,ps_color,ps_nombre 
FROM lote_prueba AS lp,prueba_estado AS pe,prueba AS p 
WHERE lp.ps_id = pe.ps_id 
AND lp.p_id = p.p_id 
AND p_habilitado = 1 
AND lo_id BETWEEN 101 AND 140
AND lp_id IN (SELECT pl_id FROM prueba_resultados_docsis WHERE pr_ot = 1)
AND lp_id NOT IN (SELECT pl_id FROM prueba_resultados_docsis WHERE pr_ot = 0) 
AND lp.ps_id = 4
ORDER BY lo_id";
$qTerminadosObs="SELECT lp_id,lp.p_id,lo_id,lp_fecha,p.cli_usuario,lp.ps_id,ps_color,ps_nombre 
FROM lote_prueba AS lp,prueba_estado AS pe,prueba AS p 
WHERE lp.ps_id = pe.ps_id 
AND lp.p_id = p.p_id 
AND p_habilitado = 1 
AND lo_id BETWEEN 101 AND 140
AND lp_id IN (SELECT pl_id FROM prueba_resultados_docsis WHERE pr_ot = 1)
AND lp_id NOT IN (SELECT pl_id FROM prueba_resultados_docsis WHERE pr_ot = 0) 
AND lp.ps_id = 5
ORDER BY lo_id";
$terminadosOK=Db::listar($qTerminadosOK);
$terminadosObs=Db::listar($qTerminadosObs);
$tOK=array();
foreach($terminadosOK as $filaOK){
	$tOK[]=$filaOK['lo_id'];
}
$tOK=array_filter($tOK);
$tOK=implode(",", $tOK);
$terminadosNoOK=Db::listar($qTerminadosNoOK);
$tNoOK=array();
$tObs=array();
foreach($terminadosNoOK as $filaNoOK){
	$tNoOK[]=$filaNoOK['lo_id'];
}
foreach($terminadosObs as $filaObs){
	$tObs[]=$filaObs['lo_id'];
}
$tNoOK=array_filter($tNoOK);
$tNoOK=implode(",", $tNoOK);
$tObs=array_filter($tObs);
$tObs=implode(",", $tObs);
$qFechaInicio="SELECT MIN(pr_fecha_inicio) AS fecha_inicio FROM prueba_resultados_docsis 
WHERE p_id IN (SELECT p_id FROM prueba WHERE p_habilitado = 1 ORDER BY p_id DESC) 
AND pl_id IN (SELECT lp_id FROM lote_prueba WHERE lo_id BETWEEN 101 AND 140)
ORDER BY pr_id DESC LIMIT 1";
$fechaInicio=Db::listar($qFechaInicio)[0]['fecha_inicio'];
$datetime1=new DateTime($fechaInicio);
$datetime2=new DateTime(date("Y-m-d H:i:s"));
$intervalo=$datetime1->diff($datetime2);

?>
          <table class="striped centered blue lighten-5">
	        <thead>
	          <tr>
	              <th>ID Oper Virt</th>
	              <th>Fecha Inicio (<?php echo $fechaInicio; ?>)</th>
	              <th>Tiempo Transcurrido (<?php echo $intervalo->format("%H:%I:%S"); ?>)</th>
	              <th>Estado</th>
	          </tr>
	        </thead>
	
	        <tbody>
	        	<tr>
	        		<td colspan="4">
	        			<table class="" style="background-color: #D8D3D3; border: solid 1px grey;">
	        				<tr>
	        					<td>No iniciado</td>
	        					<td style="width: 50px;background-color: white;"></td>
	        					<td>Iniciado</td>
	        					<td style="width: 50px;background-color: blue;"></td>
	        					<td>Terminado Ok</td>
	        					<td  style="width: 50px;background-color: green;"></td>
	        					<td>Terminado No OK</td>
	        					<td style="width: 50px;background-color: red;"></td>
	        					<td>Terminado c/Adv.</td>
	        					<td style="width: 50px;background-color: yellow;"></td>
	        				</tr>
	        			</table>
	        		</td>
	        	</tr>
	          <tr>
	          	<td colspan="4">
	          		<div>
	          		<table class="centered highlight" style="background-color: #BFE788;">
	          		<?php
	          		$queryR1="SELECT lstk_id FROM teccam.prueba_resultados_docsis 
								WHERE p_id IN (SELECT p_id FROM teccam.prueba ORDER BY p_id DESC)
								AND lstk_id IS NOT NULL AND lstk_id <> 0
								AND pl_id IN (SELECT lp_id FROM teccam.lote_prueba WHERE lo_id BETWEEN 101 AND 140)
								ORDER BY pr_id DESC
								LIMIT 1";
					$r1=Db::listar($queryR1);
	          		$r2=json_decode(file_get_contents("http://192.168.1.18/spacm-remito.php?id=".$r1[0]['lstk_id']));
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
	          		</div>
	          	</td>
	          </tr>
	        <?php  
	        foreach($res as &$fila){ ?>
	          <tr class="resalta">
	            <td><?php echo $fila['lo_id']; ?></td>
	            <td><?php echo $fila['lp_fecha']; ?></td>
	            <?php
	            $fechaInicio2=Db::listar("SELECT pr_fecha_inicio FROM prueba_resultados_docsis WHERE pl_id = ".$fila['lp_id'])[0]['pr_fecha_inicio'];
	            $datetime11=new DateTime($fechaInicio2);
				$datetime22=new DateTime(date("Y-m-d H:i:s"));
				$intervalo2=$datetime11->diff($datetime22);
	            ?>
	            <td><?php echo $intervalo2->format("%H:%I:%S"); ?></td>
	            <td title="Cerrar click ..." onclick="location.href='monitor-cerr.php?loId=<?php echo $fila['lo_id']; ?>'" style="border: solid 1px grey;background-color: <?php echo $fila['ps_color']; ?>"><?php echo $fila['ps_nombre']; ?></td>
	          </tr>
			<?php } ?>
	        </tbody>
	      </table>
	      <br>
	      <p style="color: green;font-weight: bold;background-color: rgba(255,255,255,.7);">Terminadas OK : <?php echo $tOK ?></p>
	      <p style="color: yellow;font-weight: bold;background-color: rgba(0,0,0,.4);">Terminadas Observadas : <?php echo $tObs ?></p>
	      <p style="color: red;font-weight: bold;background-color: rgba(255,255,255,.7);">Terminadas No OK : <?php echo $tNoOK ?></p>