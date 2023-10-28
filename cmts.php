<?php
require_once "config.php";
if(!empty($_SESSION['usuario'])){
    $usu=new Usuario($_SESSION['usuario']);
}else{
	header("location: login.php");
	exit;
}
$modems=cableModemsSPACM(traerModemsFromCmts(),traeIPCMs());
require_once "header.php";
?>
    <main class="container" id="content" style="background-color: rgba(255,255,255,.4);">
        <h4 style="text-align: center;">CMTS Listado CMs (<?php echo count($modems); ?>)</h4>
	      <table class="centered responsive-table highlight">
	        <thead>
	          <tr>
	              <th>MAC DOCSIS</th>
	              <th>IP DOCSIS</th>
	              <th>Rx Power en el CMTS</th>
	              <th>SNR en el CMTS</th>
	              <th>Microreflexiones</th>
	              <th>Status</th>
	              <th>Version DOCSIS</th>
	              <th>IP Host</th>
	              <th>Abre Log</th>
	          </tr>
	        </thead>
	
	        <tbody class="">
	        <?php  
			foreach ($modems as $fila) { 
	        ?>
	          <tr ondblclick="<?php if(!empty($fila['IP Host'])){echo "cmData('".$fila['IP DOCSIS']."','".$fila['MAC DOCSIS']."');";} ?>" <?php if(!empty($fila['IP Host'])){echo "title=\"Info CM con doble click...\"";} ?>>
	            <td><?php echo $fila['MAC DOCSIS']; ?></td>
	            <td><?php echo $fila['IP DOCSIS']; ?></td>
	            <td><?php echo $fila['Rx Power en el CMTS']; ?></td>
	            <td><?php echo $fila['SNR en el CMTS']; ?></td>
	            <td><?php echo $fila['Microreflexiones']; ?></td>
	            <td><?php echo $fila['Status']; ?></td>
	            <td><?php echo $fila['Version DOCSIS']; ?></td>
	            <td style="vertical-align: middle;padding-bottom: 0px;"><?php echo $fila['IP Host']; ?></td>
	            <td><a class="waves-effect waves-light btn indigo" onclick="<?php if(!empty($fila['IP Host'])){echo "cmLogs('".$fila['IP DOCSIS']."','".$fila['MAC DOCSIS']."');";} ?>">Abrir</a></td>
	          </tr>
	          <tr title="Cerrar con doble click ..." ondblclick="cmDataClose('<?php echo $fila['MAC DOCSIS']; ?>');">
	          	<td id="<?php echo $fila['MAC DOCSIS']; ?>" colspan="9"></td>
	          </tr>
			<?php } ?>
	        </tbody>
	      </table>
        <p style="text-align: center;">
        	<a class="waves-effect waves-light btn  indigo" href="javascript:void(0)" title="Reiniciar CMTS (doble click)" ondblclick="location.href='cmts-restart.php'">Reinicia</a>
        	<a class="waves-effect waves-light btn  indigo" href="javascript:void(0)" title="Resetear CMs (doble click)" ondblclick="window.open('cmts-f-reset.php','freset','height=200,width=450')">Factory Reset</a>
        </p>
    </main>
<?php
require_once "footer.php";
?>