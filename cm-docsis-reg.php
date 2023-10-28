<?php
require_once "config.php";
if(!empty($_SESSION['usuario']) AND $_SESSION['usuario']=="jlvillaronga"){
    $usu=new Usuario($_SESSION['usuario']);
}else{
	header("location: login.php");
	exit;
}
require_once "header.php";
?>
    <main class="container" id="content" style="background-color: rgba(255,255,255,.4);">
        <h4 style="text-align: center;">Registro de Cable Modems DOCSIS</h4>
        <br>
        <h6 style="padding: 10px;">Bien venid@ <?php echo $usu->getNombre()." ".$usu->getApellido(); ?></h6>
	<?php  
	foreach(Db::listar("SELECT * FROM cable_modem_docsis ORDER BY cmd_modelo") as $fila){ ?>
      <table style="background-color: rgba(0,0,0,.1);border-bottom: solid 1px rgba(0,0,0,.5);" class="highlight centered responsive-table">
        <thead>
          <tr>
              <th>Modelo</th>
              <th>Firmware</th>
              <th>Firmware 2</th>
              <th>Firmware File</th>
              <th>Firmware File 2</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo $fila['cmd_modelo']; ?></td>
            <td><?php echo $fila['cmd_firmware']; ?></td>
            <td><?php echo $fila['cmd_firmware2']; ?></td>
            <td><?php echo $fila['cmd_firmware_file']; ?></td>
            <td><?php echo $fila['cmd_firmware_file2']; ?></td>
          </tr>
        </tbody>
      </table>
      <table style="background-color: rgba(0,0,0,.1);border-bottom: solid 1px rgba(0,0,0,.5);" class="highlight centered responsive-table">
        <thead>
          <tr>
              <th>Cliente</th>
              <th>WIFI 5G</th>
              <th>WIFI 2G</th>
              <th>MTA</th>
              <th>OID 1</th>
              <th>OID 1 Value</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo $fila['emp_id']; ?></td>
            <td><?php if($fila['cmd_wifi_5g']=="1"){echo "Si";}else{echo "No";} ?></td>
            <td><?php if($fila['cmd_wifi_2g']=="1"){echo "Si";}else{echo "No";} ?></td>
            <td><?php if($fila['cmd_mta']=="1"){echo "Si";}else{echo "No";} ?></td>
            <td><?php echo $fila['cmd_oid1']; ?></td>
            <td><?php echo $fila['cmd_oid1_value']; ?></td>
          </tr>
        </tbody>
      </table>
      <table style="background-color: rgba(0,0,0,.1);" class="highlight centered responsive-table">
        <thead>
          <tr>
              <th>Agregar</th>
              <th>Editar</th>
              <th>Borrar</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
	          <a id="scale-demo" href="#!" class="btn-floating btn-large scale-transition indigo">
				 <i id="add" class="material-icons waves-effect waves-light" onclick="location.href='cm-docsis-reg-a.php'" title="Agregar">add</i>
			  </a>
            </td>
            <td>
	          <a id="scale-demo" href="#!" class="btn-floating btn-large scale-transition green">
				 <i id="edit" class="material-icons waves-effect waves-light" onclick="location.href='cm-docsis-reg-e.php?id=<?php echo $fila['cmd_id']; ?>'" title="Editar">edit</i>
			  </a>
            </td>
            <td>
	          <a id="scale-demo" href="#!" class="btn-floating btn-large scale-transition red">
				 <i id="del" class="material-icons waves-effect waves-light" ondblclick="location.href='cm-docsis-reg-d.php?id=<?php echo $fila['cmd_id']; ?>'" title="borrar">delete</i>
			  </a>
            </td>
          </tr>
        </tbody>
      </table>
      <br><br>
    <?php } ?>
    </main>
<?php
require_once "footer.php";
?>