<?php 

	ob_start();

	include("header.php");

	$buffer = ob_get_contents();

	ob_end_clean();
	
	$buffer = str_replace("%TITLE%","Changement du mot de passe - L'annuaire des portails",$buffer);

	echo $buffer;?>
	<main id='changepassword'>
	<div class="vertical">
		<div class="vertical-center">
		</div>
	</div>
	</main>
<?php include("footer.php"); ?>