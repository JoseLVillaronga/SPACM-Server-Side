<?php
require_once 'config.php';
$id=$_GET['id'];
$query="SELECT * FROM prueba WHERE p_id = ".$id;
$res1=Db::listarServer($query);
$res=json_encode($res1);
echo $res;
//print_r($res1);
