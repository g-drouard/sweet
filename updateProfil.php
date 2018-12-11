<?php

	ob_start();

	include("header.php");

	$buffer = ob_get_contents();

	ob_end_clean();
	
	if($_SESSION['user_id'])
	{
		
		$sql = "SELECT *
			FROM users
			WHERE id = " . $_SESSION['user_id'];

		$req = $dbh->prepare($sql);
		$req->execute();
		$user = $req->fetch();
		
		setcookie("server", $user["server"], time() + (86400 * 30), "/");
		$_SESSION["server"] = $user["server"];
		
		header('Location: /portails/'.$user["server"]);
	}
	else
	{
		header('Location: /serveurs');
	}
?>