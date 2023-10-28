<?php
require_once 'config.php';
$id=$_GET['id'];
$query="SELECT * FROM evento WHERE usu_id = ".$id." ORDER BY ev_id DESC LIMIT 1";
$res=Db::listarServer($query);
$res=json_encode($res);
echo $res;