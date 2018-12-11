<?php 

	ob_start();

	include("header.php");

	$buffer = ob_get_contents();

	ob_end_clean();

	$buffer=str_replace("%TITLE%",$server["name"]." - Mon IP - L'annuaire des portails",$buffer);

	echo $buffer;
	
	var_dump(md5('katalisback'));
	
	include("footer.php"); ?>