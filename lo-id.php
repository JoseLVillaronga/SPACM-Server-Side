<?php
require_once 'config.php';
$loId=$_GET['loId'];
$query="SELECT lp_id,p.p_id,lo_id,lp_fecha,lp.cli_usuario,ps_id,tp_id,p_fecha_inicio,p_fecha_final,p_habilitado,p_cc,p_cant_ether 
FROM lote_prueba AS lp,prueba AS p 
WHERE p.p_id = lp.p_id 
AND p_habilitado = 1 
AND lo_id = ".$loId;
$res=Db::listarServer($query);
$res=json_encode($res);
echo $res;
?>