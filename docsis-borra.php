<?php
require_once 'config.php';
$con=new mysqli("192.168.81.21","jlvillaronga","teccamsql365","teccam");
$query="DELETE FROM teccam.docsis WHERE DATE(d_fecha) < DATE(NOW())";
mysqli_query($con, $query);
$con->close();