<?php
require_once 'config.php';
$id=$_GET['id'];
$query2="SELECT * FROM lote_prueba WHERE lp_id = ".$id;
$res2=json_encode(Db::listarServer($query2));
echo $res2;