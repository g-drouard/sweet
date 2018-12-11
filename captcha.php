<?php

	ob_start();

	include("header.php");

	$buffer = ob_get_contents();

	ob_end_clean();

	$buffer = str_replace("%TITLE%","Sweet.ovh - Le site de recensement des portails",$buffer);

	echo $buffer;
	
	if(!isset($_POST["g-recaptcha-response"])) {
?>

	<form method="POST" action="captcha.php">
		<div class="g-recaptcha" data-sitekey="6LcExjcUAAAAAEdlqsObyM40i_XTeLPlTsIgjIJX"></div>
		<input type="submit" value="Envoyer le formulaire">
	</form>

<?php 	}

	else {
		
		$data = array("secret" => "6LcExjcUAAAAABKy3WfIihoxvZV_KYYbZMf6taMF","response" => $_POST["g-recaptcha-response"]);


$data_url = http_build_query ($data);

// Création d'un flux
$opts = array(
  'http'=>array(
    'method'=>"POST",
    'content'=>$data_url
  )
);

$context = stream_context_create($opts);

// Accès à un fichier HTTP avec les entêtes HTTP indiqués ci-dessus
$file = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context), true);

var_dump($file["success"]);

	}

	include("footer.php");

?>