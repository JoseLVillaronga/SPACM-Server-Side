<?php
$ip = $_GET['ip'];
echo file_get_contents("http://192.168.1.11:10080/test-debian.php?ip=".$ip);