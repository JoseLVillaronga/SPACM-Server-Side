<?php
require_once "config.php";
if(!empty($_SESSION['usuario'])){
    $usu=new Usuario($_SESSION['usuario']);
}else{
	header("location: login.php");
	exit;
}
$query="SELECT * FROM lista_opers WHERE lo_id BETWEEN 101 AND 140";
$res=Db::listar($query);
?>
        <h4>Estado Opers Virt</h4>
        <h6 style="padding: 10px;">Bien venid@ <?php echo $usu->getNombre()." ".$usu->getApellido()." <em style=\"font-weight: bold;\">".date("Y-m-d H:i:s")."</em>"; ?></h6>
		<div id="">
		<table class="highlight centered responsive-table purple lighten-5">
			<thead>
				<tr>
					<th>Nro.</th>
					<th>Reiniciar</th>
					<th>Estado</th>
				</tr>
			</thead>
	
			<tbody>
				<?php  
				foreach($res as $fila){ 
				if(ping($fila['lo_ip'], 80, .1)=="down"){
					$color="red";
					$estado="Down";
				}else{
					$color="green";
					$estado="Up";
				}
				?>
				<tr>
					<td class="celdaInfo"><?php echo $fila['usu_id']; ?></td>
					<td class="celdaInfo"><a class="waves-effect waves-light btn indigo" href="javascript:void(0)" onclick="location.href='virt-reinicia.php?id=<?php echo $fila['usu_id']; ?>'">Reiniciar</a></td>
					<td class="celdaInfo" style="color: white;background-color: <?php echo $color; ?>;"><?php echo $estado; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<br>
		</div>