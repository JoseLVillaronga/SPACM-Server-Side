<?php
require_once 'config.php';
$id=$_GET['id'];
$mac=$_GET['mac'];
$obj=new Prueba($id);
?>
      <table class="striped centered responsive-table blue lighten-5">
        <thead>
          <tr>
              <th>ID Oper Virt</th>
              <th>Fecha Inicio</th>
              <th>Estado</th>
          </tr>
        </thead>

        <tbody>
        	<tr>
        		<td colspan="3">
        			<table class="responsive-table" style="background-color: #D8D3D3; border: solid 1px grey;">
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
        <?php
        $lpId;  
        foreach($obj->lotePrueba->lote as $filaL){
			 $lpId[]="'".$filaL['lp_id']."'";
		}
		$lpId=implode(",", $lpId);
		$qL="SELECT * FROM prueba_resultados_docsis WHERE pl_id IN (".$lpId.") AND pr_mac_docsis = '".$mac."'";
		$resL=Db::listar($qL);
		foreach($obj->lotePrueba->lote as $fila){
		if(!empty($mac)){
			if($fila['lp_id']!=$resL[0]['pl_id']){
				continue 1;
			}
		}
        ?>
          <tr>
            <td><?php echo $fila['lo_id']; ?></td>
            <td><?php echo $fila['lp_fecha']; ?></td>
            <td title="Info Prueba ... (click)" onclick="window.open('test-info2.php?id=<?php echo $fila['lp_id']; ?>','_blank')" style="border: solid 1px grey;background-color: <?php echo $fila['ps_color']; ?>">
            	<?php echo $fila['ps_nombre']; ?>
            </td>
          </tr>
		<?php } ?>
        </tbody>
      </table>
      <?php
      //echo "<pre>";
	  //print_r($obj->lotePrueba->lote);
	  //echo "</pre>";
	  //echo $lpId."<br>";
	  //echo $resL[0]['pl_id'];
      ?>