<?php
require_once 'config.php';
$con=new mysqli("192.168.81.21","jlvillaronga","teccamsql365","teccam");
mysqli_query($con, "flush hosts");
