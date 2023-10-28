<?php
require_once 'config.php';
$accion=new Ajax($_GET['ax_id']);
echo "<pre>";
print_r($accion);
echo "</pre>";
?>