<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<style>
		body
		{
			font-family: Arial, sans-serif;
			font-size: 9pt;
			color: #666;
			background-color: #F8F8F8;
		
		}
	</style>
</head>
<body>
<?php
if(empty($_GET['ip'])){
}else{
	$des=snmpwalkoid($_GET['ip'], "public", ".1.3.6.1.2.1.4.20.1.1");
	$cpe="";
	foreach ($des as $key => $value) {
	    if(!strpos($value,"10.41.192")){continue;}
	    $cpe.=str_replace("IpAddress: ", "", $value)." &nbsp;";
	}
	echo $cpe;
}
?>
</body>
</html>
