<?php
$API=new Routeros_Api();
$API->connect('192.168.254.100', 'admin', 'teccammt0810');
$API->write('/interface/wireless/scan/1');
$READ = $API->read(false);
$ARRAY = $API->parse_response($READ);
$API->disconnect();
echo "<pre>";
print_r($ARRAY);
echo "</pre>";
?>