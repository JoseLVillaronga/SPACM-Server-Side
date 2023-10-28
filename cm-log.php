<?php
require_once 'config.php';
$ip=$_GET['ip'];
$logs = traerLogFromCM2($ip);
?>
      <table class="striped centered responsive-table blue lighten-5">
        <thead>
          <tr>
              <th>ID</th>
              <th>Fecha</th>
              <th>Tipo</th>
              <th>Texto</th>
          </tr>
        </thead>
        <tbody>
        <?php  
        foreach ($logs as $fila2) { ?>
          <tr>
            <td><?php echo $fila2['ID']; ?></td>
            <td><?php echo $fila2['Hora']; ?></td>
            <td><?php echo $fila2['Tipo']; ?></td>
            <td><?php echo $fila2['Texto']; ?></td>
          </tr>
		<?php } ?>
        </tbody>
      </table>