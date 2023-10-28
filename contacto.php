<?php
require_once 'config.php';
$titulo="Teccam S.R.L. | Contacto";
require_once "include/geoiploc.php";
if(is_null($_SESSION['paisC'])){
  $ip = $_SERVER['REMOTE_ADDR'];
  $_SESSION['paisC'] = getCountryFromIP($ip,"code");
}
$_SESSION['redirect'] = "contacto.php";
if($_SERVER['REQUEST_METHOD']=="POST"){
    if (empty($_POST['captcha']) OR strtolower($_POST['captcha']) != $_SESSION['captcha']) {
        $mensaje2 = "Captcha invalido";
    }
	$nombre = $_POST['nombre'];
	$mail = $_POST['email'];
	$empresa = $_POST['empresa'];
	$telefono = $_POST['tel'];
	$header = 'From: ' . $mail . " \r\n";
	$header .= "X-Mailer: PHP/" . phpversion() . " \r\n";
	$header .= "Mime-Version: 1.0 \r\n";
	$header .= "Content-Type: text/plain";
	$mensaje = "Este mensaje fue enviado por " . $nombre . ",
	 de la empresa " . $empresa . " \r\n";
	$mensaje .= "Su e-mail es: " . $mail . " \r\n";
	$mensaje .= "Su teléfono es: ".$telefono." \r\n";
	$mensaje .= "Mensaje: " . $_POST['comentarios'] . " \r\n";
	$mensaje .= "Enviado el " . date('d/m/Y', time());
	
	$para = 'info@teccam.net';
	$asunto = 'Formulario de Contacto www.teccam.net';
	if(!empty($nombre) AND !empty($mail) AND !empty($empresa) AND !empty($telefono) AND !isset($mensaje2)){
		mail($para, $asunto, utf8_decode($mensaje), $header);
		$mensaje2="Mensaje enviado correctamente";
	}else{
		if(!isset($mensaje2)){
			$mensaje2="Hay que completar todos los campos ...";
		}
	}
}else{
	$mensaje2="";
}

require_once 'header.php';
?>
	<main id="main" class="container row">
		<br><br><br>
		<div class="col s12 m6" onkeydown="if (event.keyCode == 13) document.forms['formulario'].submit();">
			<form name="form1" id="formulario" method="post">
				<div class="row">
					<div class="input-field col s12">
						<h4>Formulario de Contacto</h4>
					</div>
			        <div class="input-field col s12">
			          	<input placeholder="Nombre" id="nombre" type="text" class="validate" name="nombre">
			          	<label for="nombre">Nombre</label>
			        </div>
			        <div class="input-field col s12">
			          	<input placeholder="E-Mail" id="mail" type="email" class="validate" name="email">
			          	<label for="mail" data-error="Mail invalido ..." data-success="Correcto ...">E-Mail</label>
			        </div>
			        <div class="input-field col s12">
			          	<input placeholder="Empresa" id="empresa" type="text" class="validate" name="empresa">
			          	<label for="empresa">Empresa</label>
			        </div>
			        <div class="input-field col s12">
			          	<input placeholder="Teléfono" id="telefono" type="tel" class="validate" name="tel">
			          	<label for="telefono">Teléfono</label>
			        </div>
			        <div class="input-field col s12">
			          	<textarea name="comentarios" cols="22" rows="8" class="validate" id="comentarios"></textarea>
			          	<label for="comentarios">Comentarios</label>
			        </div>
			        <div class="input-field col s12">
					  	<span class="form"><br><br>
                      		<strong>Escriba lo siguiente:</strong><br>
                      	    <img src="captcha.php" id="captcha" /><br>
                      	        		<a href="#" onclick="
									    document.getElementById('captcha').src='captcha.php?'+Math.random();
									    document.getElementById('captcha-form').focus();"
									    id="change-image">No se lee? Cambiar texto.</a><br><br>
									    <input type="text" placeholder="Texto Captcha" name="captcha" id="captcha-form" autocomplete="off" class="validate">
                      	</span>
					</div>
					
			        <div class="input-field col s12">

			          	<a id="scale-demo" href="#!" class="btn-floating btn-large scale-transition">
			          		<i class="material-icons waves-effect waves-light" onclick="document.forms['formulario'].submit();" title="Enviar">send</i>
			          	</a>
			        </div>
			        <div class="input-field col s12">
			          	<em style="color: red;font-size: 18pt;"><?php if(!empty($mensaje2)){echo "<br />".$mensaje2."<br /><br />";} ?></em>
			        </div>
		        </div>
			</form>
		</div>
		
		<div class="col s12 m6">
		  	<em style="font-size: 1.5em;">Estamos en ...</em><br>
		  	<?php
		  	if($_SESSION['paisC'] == 'UY' AND in_array($_SERVER['SERVER_NAME'], array('teccam.com.uy','www.teccam.com.uy'))){
		  		echo "<p>+ Departamento Técnico y Laboratorio<br>
				Dr. Salvador Ferrer Serra 2103, Montevideo<br>
				TEL. 24007352<br>
				E-Mail.: logistica2@teccam.com.uy</p>";
		  	}else{
		  		echo "<p>+ Departamento Técnico y Laboratorio<br>
				Aguero 870/80, Florida (C.P.: 1602)<br>
				TEL. (+5411) 4730-3461<br>
				Skype.: teccam.srl (solo llamadas, chat no disponible).</p>
			<p>+Administración y Oficina Comercial<br>
				Bucarelli 3053, Villa Urquiza (C.P.: 1431)<br>
				TEL. (+5411) 4542-4511<br>
				Fax: 4542-2382</p>";
		  	}
		  	?>
		  	

			<iframe src="<?php
			if($_SESSION['paisC'] == 'UY' AND in_array($_SERVER['SERVER_NAME'], array('teccam.com.uy','www.teccam.com.uy'))){
				echo "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3272.445117674201!2d-56.174799084762626!3d-34.895277580385006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x959f804dda095bf1%3A0x8a7f6c744e0ccdbf!2sDr.+Salvador+Ferrer+Serra+2103%2C+Montevideo%2C+Uruguay!5e0!3m2!1ses!2sar!4v1486407394733";
			}else{
				echo "https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d13145.951911623251!2d-58.5041351!3d-34.5411982!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xf30fc9fe75b1f862!2sTeccam+SRL!5e0!3m2!1ses!2sar!4v1482263866565";
			}
			?>" style="border:0" allowfullscreen="" height="450" frameborder="0" width="100%"></iframe>
		</div>

	</main>
<?php
require_once 'footer.php';
?>