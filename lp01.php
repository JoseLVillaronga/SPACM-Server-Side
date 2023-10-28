<?php
require_once 'config.php';
$id=$_GET['id'];
$query="SELECT lp_id,p_id,lo_id,lp_fecha,cli_usuario,p.ps_id,ps_color,ps_nombre FROM lote_prueba AS p,prueba_estado AS pe WHERE p.ps_id = pe.ps_id AND p_id = ".$id;
$res=json_encode(Db::listarServer($query));
echo $res;