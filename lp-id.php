<?php
require_once 'config.php';
$lpId=$_GET['lpId'];
$query="SELECT * FROM teccam.prueba_resultados_docsis WHERE pl_id = ".$lpId;
$res=Db::listarServer($query);
$res=json_encode($res);
echo $res;