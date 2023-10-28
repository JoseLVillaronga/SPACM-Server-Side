<?php
require_once 'config.php';
$id=$_GET['id'];
$query="SELECT * FROM ajax WHERE ax_id = ".$id;
$res=Db::listarServer($query);
$res=json_encode($res);
echo $res;