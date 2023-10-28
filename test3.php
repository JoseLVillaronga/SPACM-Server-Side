<?php
require_once 'config.php';
$obj=new Prueba(44);
$obj->lotePrueba->setLotePorId(205);
//$obj->lotePrueba->setEstado(2);
//$obj->lotePrueba->actualizaDb();
//$obj->lotePrueba->historico->agregaADb();
echo "<pre>";
print_r($obj);
echo "</pre>";