<?php
require_once 'config.php';
exec(utf8_decode("logger -n 192.168.81.21 -p 0.0 -t ".$_SESSION['usu_id']." Se inicia prueba de navegación WEB, el CM no navega, se termina la prueba ..."));
$query="SELECT lp_id,p.p_id,lo_id,lp_fecha,lp.cli_usuario,ps_id,tp_id,p_fecha_inicio,p_fecha_final,p_habilitado 
FROM lote_prueba AS lp,prueba AS p 
WHERE p.p_id = lp.p_id 
AND p_habilitado = 1 
AND lo_id = ".$_GET['usu_id'];
$res=Db::listarServer($query);
echo json_encode($res);