<?php
require_once "config.php";
if(!empty($_SESSION['usuario'])){
    $usu=new Usuario($_SESSION['usuario']);
}else{
	header("location: login.php");
	exit;
}
$query="SELECT * FROM teccam.prueba_resultados_docsis WHERE pl_id = ".$_GET['id'];
$res=Db::listar($query);
require_once "header.php";
?>
    <main class="container" id="content" style="background-color: rgba(255,255,255,.4);width: 100%;">
        <h4>Test Info</h4>
        <h6 style="padding: 10px;">Bien venid@ <?php echo $usu->getNombre()." ".$usu->getApellido(); ?></h6>
		<table class="highlight centered responsive-table">
			<thead>
				<tr>
					<th>Prueba ID</th>
					<th>CM MAC DOCSIS</th>
					<th>Prueba Nav</th>
					<th>Prueba Velocidad</th>
				</tr>
			</thead>
			
			<tbody>
				<?php  
				foreach($res as $fila){ ?>
				<tr>
					<td class="celdaInfo"><?php echo $fila['p_id']; ?></td>
					<td class="celdaInfo" title="Info Remito ... (doble click)" ondblclick="location.href='test-remito.php?id=<?php echo $fila['lstk_id']; ?>&plId=<?php echo $fila['pl_id']; ?>'">
						<?php echo $fila['pr_mac_docsis']; ?>
					</td>
					<td class="celdaInfo"><?php echo $fila['pr_navega']; ?></td>
					<td class="celdaInfo"><pre><?php echo $fila['pr_result_test_velocidad']; ?></pre></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<br>
		<table class="highlight centered responsive-table">
			<thead>
				<tr>
					<th>Prueba WiFi 2G</th>
					<th>Prueba WiFi 5G</th>
					<th>Prueba Firmware</th>
					<th>Prueba MTA</th>
				</tr>
			</thead>
			<tbody>
				<?php  
				foreach($res as $fila2){ ?>
				<tr>
					<td class="celdaInfo"><pre><?php echo $fila2['pr_wifi']; ?></pre></td>
					<td class="celdaInfo"><pre><?php echo $fila2['pr_wifi_5g']; ?></pre></td>
					<td class="celdaInfo"><?php echo $fila2['pr_firmware']; ?></td>
					<td class="celdaInfo"><?php echo $fila2['pr_mta']; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table><br>
    </main>
<?php
require_once "footer.php";
?>