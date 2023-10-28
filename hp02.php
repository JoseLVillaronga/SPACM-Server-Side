<?php
require_once 'config.php';
$id=$_GET['id'];
$query="SELECT * FROM prueba_historico WHERE lp_id = ".$id;
$res=json_encode(Db::listarServer($query));
echo $res;