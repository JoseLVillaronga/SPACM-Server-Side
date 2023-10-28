<?php
require_once 'config.php';

$telnet = new PHPTelnet();
echo "<pre>";
// if the first argument to Connect is blank,
// PHPTelnet will connect to the local host via 127.0.0.1
$result = $telnet->Connect('10.100.2.252','vicente','vicente');

if ($result == 0) {
$telnet->DoCommand('en', $result);
// NOTE: $result may contain newlines
$telnet->DoCommand('vicente', $result);
//echo $result;
// NOTE: $result may contain newlines
$telnet->DoCommand('clear cable modem offline', $result);
echo $result;
echo " Clear OK ...";
// say Disconnect(0); to break the connection without explicitly logging out
$telnet->Disconnect();
//echo "</pre>";
}
?>