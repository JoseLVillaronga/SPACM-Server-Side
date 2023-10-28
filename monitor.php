<?php
require_once "config.php";
if(!empty($_SESSION['usuario'])){
    $usu=new Usuario($_SESSION['usuario']);
}else{
	header("location: login.php");
	exit;
}
$queryTP="SELECT * FROM teccam.prueba ORDER BY p_id DESC LIMIT 1";
$resTP=Db::listar($queryTP);
if($resTP[0]["tp_id"]=="5"){
	header("location: monitorUD.php");
	exit;
}

$query="SELECT lp_id,lp.p_id,lo_id,lp_fecha,p.cli_usuario,lp.ps_id,ps_color,ps_nombre FROM lote_prueba AS lp,prueba_estado AS pe,prueba AS p WHERE lp.ps_id = pe.ps_id AND lp.p_id = p.p_id AND p_habilitado = 1 AND lo_id BETWEEN 101 AND 140 AND lp_id NOT IN (SELECT pl_id FROM prueba_resultados_docsis WHERE pr_ot = 1) ORDER BY lo_id";
$res=Db::listar($query);
require_once "header.php";
?>
    <main class="container" id="content" style="background-color: rgba(255,255,255,.4);">
        <h4 style="text-align: center;">Monitor Opers Virt</h4>
        <h6 style="padding: 10px;">Bien venid@ <?php echo $usu->getNombre()." ".$usu->getApellido(); ?></h6>
        <div id="monitor">
          <table class="striped centered blue lighten-5">
	        <thead>
	          <tr>
	              <th>ID Oper Virt</th>
	              <th>Fecha Inicio (<?php echo date("Y-m-d H:i:s"); ?>)</th>
	              <th>Estado</th>
	          </tr>
	        </thead>
	
	        <tbody>
	        	<tr>
	        		<td colspan="3">
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
	          		<table class="centered highlight" style="background-color: #BFE788;">
	          		<?php
	          		$queryR1="SELECT lstk_id FROM teccam.prueba_resultados_docsis 
								WHERE p_id IN (SELECT p_id FROM teccam.prueba WHERE p_habilitado = 1 ORDER BY p_id DESC)
								AND lstk_id IS NOT NULL
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
	          	</td>
	          </tr>
	        <?php  
	        foreach($res as $fila){ ?>
	          <tr class="resalta">
	            <td><?php echo $fila['lo_id']; ?></td>
	            <td><?php echo $fila['lp_fecha']; ?></td>
	            <td style="border: solid 1px grey;background-color: <?php echo $fila['ps_color']; ?>"><?php echo $fila['ps_nombre']; ?></td>
	          </tr>
			<?php } ?>
	        </tbody>
	      </table>
        </div>
        <br>
    </main>
<script>
var monitor = function(){
	var xhr = new XMLHttpRequest();
	xhr.open("GET","monitor-din.php?nc="+Math.random());
	xhr.onreadystatechange = function(){
		if(xhr.readyState == 4){
			var caja = document.getElementById("monitor");
			//if(xhr.status == 200){
				//caja.innerHTML = xhr.responseText;
			//}
			switch(xhr.status){
				case 200:
					caja.innerHTML = xhr.responseText;
				case 404:
					caja.removeFromCache(xhr.requestUrl);
				case 500:
					caja.removeFromCache(xhr.requestUrl);
				case 0:
					caja.removeFromCache(xhr.requestUrl);
				default:
					caja.removeFromCache(xhr.requestUrl);
			}
		}
	}
	xhr.send(null);
}
setInterval(monitor,4000);
</script>
<?php
require_once "footer.php";
?>