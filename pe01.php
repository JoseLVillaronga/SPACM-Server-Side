<?php
require_once 'config.php';
$id=$_GET['id'];
$query="SELECT * FROM teccam.prueba_estado WHERE ps_id = ".$id;
$res=json_encode(Db::listarServer($query));
echo $res;