<?php
require_once "config.php";
if(!empty($_SESSION['usuario'])){
    $usu=new Usuario($_SESSION['usuario']);
}else{
	header("location: login.php");
	exit;
}
$serie=$_GET['serie'];
if(isset($_GET['serie']) AND !empty($serie)){
	$bus=json_decode(file_get_contents("http://192.168.101.18/spacm-busca-item.php?serie=".$serie));
	if(is_object($bus)){
		$serie=$bus->serie;
		$mac=$bus->mac;
		$rem_nro=$bus->rem_nro;
		$color=$bus->color;
		$estado=$bus->estado;
	}else{
		$serie="";
		$mac="";
		$rem_nro="";
		$color="";
		$estado="";
	}
}else{
	$serie="";
	$mac="";
	$rem_nro="";
	$color="";
	$estado="";
}

require_once "header.php";
?>
    <main class="container" id="content" style="background-color: rgba(255,255,255,.4);">
        <h4>Check Stock Activo</h4>
        <h6 style="padding-left: 10px;">Bien venid@ <?php echo $usu->getNombre()." ".$usu->getApellido(); ?></h6>
        <div style="padding: 10px;">
        <form method="get" id="formulario">
			<div class="input-field col s12">
			   	<input value="" onkeydown="if (event.keyCode == 37) document.getElementById('enviar').click();" placeholder="Serie / MAC" id="serie" type="text" class="validate" name="serie">
			   	<label for="serie">Serie / MAC</label>
			 </div>
          <a id="scale-demo" href="#!" class="btn-floating btn-large scale-transition indigo">
			    <i id="enviar" class="material-icons waves-effect waves-light" onclick="document.forms['formulario'].submit();" title="Enviar">send</i>
			</a>
        </form>
        <div>
        	
        </div>
        <br>
		<table style="background-color: <?php echo $color; ?>">
			<thead>
				<tr>
					<th>Estado</th>
					<th>Nro Remito</th>
					<th>Nro. Serie</th>
					<th>MAC</th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td colspan="5">
						
					</td>
				</tr>
				<tr>
					<td style="font-size: 2em;font-weight: bolder;"><?php echo $estado; ?></td>
					<td><?php echo $rem_nro; ?></td>
					<td><?php echo $serie; ?></td>
					<td><?php echo $mac; ?></td>
				</tr>
				<tr>
					<td colspan="5">
						
					</td>
				</tr>
			</tbody>
		</table>
        	
        </div>
        <br>
    </main>
    <script>
    	document.getElementById('serie').focus();
    </script>
<?php
require_once "footer.php";
?>