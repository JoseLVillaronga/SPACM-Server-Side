<?php
require_once "config.php";
if(!empty($_SESSION['usuario'])){
    $usu=new Usuario($_SESSION['usuario']);
}else{
	header("location: login.php");
	exit;
}
if($_SERVER['REQUEST_METHOD']=="POST"){
	$accion=$_POST['accion'];
	$usu=$_POST['usu'];
	if(strlen($usu[0]) > 4){
		$usu=explode(",", $usu[0]);
	}
	$ev=new Evento($auth);
	$ev->activar($accion,$usu);
	if($ev->errorSql['0']=="00000" AND $accion=="5"){
		header("location: monitor.php");
		exit;
	}elseif($ev->errorSql['0']=="00000" AND $accion=="1"){
		header("location: virt-estado.php");
		exit;
	}elseif($ev->errorSql['0']=="00000" AND $accion=="2"){
		header("location: virt-estado.php");
		exit;
	}
}
require_once "header.php";
?>
    <main class="container" id="content" style="background-color: rgba(255,255,255,.4);">
        <h4>Lanzar Eventos en Virtuales</h4>
        <form method="post" id="formulario">
          	<h5>Seleccionar Acción</h5>
        	<select name="accion">
        		<option value="">Seleccionar ...</option>
        		<?php 
        		$query="SELECT * FROM ajax WHERE ax_id NOT IN (2,6)";
        		foreach (Db::listar($query) as $fila) { ?>
        		<option value="<?php echo $fila['ax_id']; ?>"><?php echo $fila['ax_nombre']; ?></option>
        		<?php } ?>
        	</select>
        	<h5>Seleccionar Usuario</h5>
        	<select multiple name="usu[]">
        		<option value="">Seleccionar ...</option>
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
          <a id="scale-demo" href="#!" class="btn-floating btn-large scale-transition indigo">
			    <i id="enviar" class="material-icons waves-effect waves-light" onclick="document.forms['formulario'].submit();" title="Enviar">send</i>
			</a>
        </form>
        <?php
        //echo "<pre>";
		//print_r($usu);
		//echo "</pre>";
        ?>
        <p> </p>
    </main>
<?php
require_once "footer.php";
?>