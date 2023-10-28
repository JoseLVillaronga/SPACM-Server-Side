<?php
require_once 'config.php';
if(!empty($_SESSION['usuario'])){
    $usu=new Usuario($_SESSION['usuario']);
}else{
	header("location: login.php");
	exit;
}
if($_SERVER['REQUEST_METHOD']=="POST"){
	$loId=$_POST['loId'];
	$res=file_get_contents("http://192.168.81.23/lo-id.php?loId=".$loId);
	$res=json_decode($res);
	$serie=$_POST['serie'];
	$mac;
	if(!empty($serie)){
		$bus=json_decode(file_get_contents("http://192.168.1.18/spacm-busca-item.php?serie=".$serie));
	}
	if(is_object($bus)){
		$serie=$bus->serie;
		$mac=$bus->mac;
	}
	$mensaje;
	if(!empty($serie)){
		
		$ot=file_get_contents("http://192.168.1.18/spacm-rep.php?&serie=".$serie."&tarea=2&fallaId=29&repCantidad=1&repTerminado=1&srdevolucion=1");
		if($ot=="OK"){
			$connexion=new mysqli("192.168.81.21","jlvillaronga","teccamsql365","teccam");
			$query="UPDATE teccam.prueba_resultados_docsis
				SET
				pr_mac_docsis = '".$mac."',
				pr_ot = 1
				WHERE p_id = ".$res[0]->p_id." AND pl_id = ".$res[0]->lp_id;
			mysqli_query($connexion, $query);
			$connexion->close();
			header("location: monitor.php");
			exit;
		}else{
			$mensaje="No se pudo grabar la OT, intente nuebamente ...";
		}
	}
}else{
	$loId=$_GET['loId'];
	$serie="";
	$mensaje;
}

require_once "header.php";
?>
    <main class="container" id="content" style="background-color: rgba(255,255,255,.4);">
        <h4>Cerrar Oper Virt - <?php echo $loId; ?></h4>
        <form method="post" id="formulario">
        	<h5>Cargar Nro. Serie / MAC</h5>
			 <div class="input-field col s12">
			   	<input value="" onkeydown="if (event.keyCode == 37) document.getElementById('enviar').click();" placeholder="Serie" id="serie" type="text" class="validate" name="serie">
			   	<input type="hidden" value="<?php echo $loId; ?>" name="loId">
			   	<label for="serie">Serie</label>
			 </div>
          <a id="scale-demo" href="#!" class="btn-floating btn-large scale-transition indigo">
			    <i id="enviar" class="material-icons waves-effect waves-light" onclick="document.forms['formulario'].submit();" title="Enviar">send</i>
			</a>
        </form>
        <p style="color: red;text-align: center;font-weight: bold;"> <?php echo $mensaje; ?> </p>
    </main>
    <script>
    	document.getElementById('serie').focus();
    </script>
<?php
require_once "footer.php";
?>