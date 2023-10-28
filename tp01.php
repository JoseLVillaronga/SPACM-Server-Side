<?php
require_once 'config.php';
$id=$_GET['id'];
$query="SELECT * FROM tipo_prueba WHERE tp_id = ".$id;
$res=json_encode(Db::listarServer($query));
echo $res;