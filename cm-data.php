<?php
require_once 'config.php';
$ip=$_GET['ip'];
$cmData=cmDataSPACM($ip);
?>
      <table class="striped centered responsive-table blue lighten-5">
        <thead>
          <tr>
              <th>Uptime</th>
              <th>SysName</th>
              <th>SysDesc</th>
              <th>Firmware</th>
              <th>TX</th>
              <th>RX</th>
              <th>MER</th>
              <th>Frec. DS</th>
              <th>Frec US</th>
              <th>Nro. Serie</th>
          </tr>
        </thead>

        <tbody>
        <?php  ?>
          <tr>
            <td><?php echo $cmData['Uptime']; ?></td>
            <td><?php echo $cmData['SysName']; ?></td>
            <td><?php echo $cmData['SysDesc']; ?></td>
            <td><?php echo $cmData['Firmware']; ?></td>
            <td><?php echo ($cmData['TX']/10)." dbmv"; ?></td>
            <td><?php echo ($cmData['RX']/10)." dbmv"; ?></td>
            <td><?php echo ($cmData['MER']/10)." db"; ?></td>
            <td><?php echo ($cmData['Frec DS']/1000000)." Mhz"; ?></td>
            <td><?php echo ($cmData['Frec US']/1000000)." Mhz"; ?></td>
            <td title="Cerrar" onclick="window.close();"><?php echo $cmData['Nro.Serie']; ?></td>
          </tr>
		<?php  ?>
        </tbody>
      </table>