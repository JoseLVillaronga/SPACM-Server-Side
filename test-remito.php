<?php
require_once "config.php";
if(!empty($_SESSION['usuario'])){
    $usu=new Usuario($_SESSION['usuario']);
}else{
	header("location: login.php");
	exit;
}
$id=$_GET['id'];
$plId=$_GET['plId'];
$res=json_decode(file_get_contents("http://192.168.1.18/spacm-remito.php?id=".$id));
require_once "header.php";
?>
    <main class="container" id="content" style="background-color: rgba(255,255,255,.4);">
        <h4>Info Remito ...</h4>
        <h6 style="padding: 10px;">Bien venid@ <?php echo $usu->getNombre()." ".$usu->getApellido(); ?></h6>

		<table class="highlight centered responsive-table">
			<thead>
				<tr>
					<th>Remito Nro</th>
					<th>Total</th>
					<th>No Procesados</th>
					<th>Procesados</th>
				</tr>
			</thead>
				<tbody>
				<tr>
					<td><?php echo $res->RemitoNro; ?></td>
					<td><?php echo $res->Total; ?></td>
					<td><?php echo $res->NoProcesado; ?></td>
					<td><?php echo $res->Procesado; ?></td>
				</tr>
			</tbody>
		</table>

        <br>
        <a class="waves-effect waves-light btn indigo" href="javascript:void(0)" onclick="location.href='test-info2.php?id=<?php echo $plId; ?>'">Volver</a>
    </main>
<?php
require_once "footer.php";
?>