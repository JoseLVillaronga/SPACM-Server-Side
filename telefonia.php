<?php
require_once "config.php";
$res=file_get_contents("http://192.168.254.177/");
$file = fopen("/var/www/html/telefonia.txt", "w");
$res=str_replace("]", "", $res);
$res.=",{\"Hora\" : \"".date("Y-m-d H:i:s")."\"}]";
fwrite($file, $res);
fclose($file);