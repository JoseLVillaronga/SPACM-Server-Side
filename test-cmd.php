<?php
require_once 'config.php';
$_SESSION['empresa']="2";
$_SESSION['paisC']="ZZ";
echo $argv[1]."\n"."\n";
$query="SELECT * FROM articulos_vista ORDER BY art_id LIMIT 20";
foreach (Db::listar($query) as $fila) {
	echo $fila['art_id']." * ".$fila['articulo']."\n";
}

echo "\n".$argv[2];
?>