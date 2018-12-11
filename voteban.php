<?php
	session_start();
	
	$dbname = 'sweetovhrvsweet';
	$user = 'sweetovhrvsweet';
	$password = 'cbPjTReB1312';

	$dsn = 'mysql:dbname=' . $dbname . ';host=sweetovhrvsweet.mysql.db;charset=utf8';

	$options = array(
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false,
	);

	$dbh = new PDO($dsn, $user, $password, $options);
	
	if(isset($_GET["id"]) && $_SESSION["login"] != NULL)
	{
		$_GET["id"] = intval($_GET["id"]);
		
		$sql = "SELECT *
				FROM votes
				WHERE portal = " . $_GET["id"] .
				" AND (user = " . $_SESSION["user_id"] .
				" OR user_ip = '" . $_SERVER['REMOTE_ADDR'] . "')";
						
		$req = $dbh->prepare($sql);
		$req->execute();
		$vote = $req->fetch();
		
		$sql = "SELECT *
				FROM portals
				WHERE `id` = " . $_GET["id"];
		
		$req = $dbh->prepare($sql);
		$req->execute();
		$portal = $req->fetch();
		
		if(!$portal)
		{
			header('Location: ../..');
		}
		
		if(empty($vote) && ($portal["server"] == $_SESSION["server"]))
			{
				$sql = "INSERT INTO `votes`(`portal`, `user`, `report`, `user_ip`, `date`) 
								VALUES (" . $portal["id"] . "," . $_SESSION["user_id"] . ", 1,'" . $_SERVER['REMOTE_ADDR'] . "', NOW())";

				$req = $dbh->prepare($sql);
				$req->execute();
				
				$sql = "UPDATE `portals` 
						SET `reports_number` = `reports_number` + 1
						WHERE id = " . $_GET["id"];
			
				$req = $dbh->prepare($sql);
				$req->execute();
				
				$sql = "UPDATE `users` 
						SET `reports_sent` = `reports_sent` + 1 
						WHERE id = " . $_SESSION["user_id"];
			
				$req = $dbh->prepare($sql);
				$req->execute();
				
				$sql = "UPDATE `users` 
						SET `reports_number` = `reports_number` + 1 
						WHERE id = " . $portal["user"];
			
				$req = $dbh->prepare($sql);
				$req->execute();
				
				$sql = "SELECT *
						FROM users
						WHERE `id` = " . $portal["user"];
					
				$req = $dbh->prepare($sql);
				$req->execute();
				$user = $req->fetch();
				
				if(($user["reports_number"] - $user["votes_number"] - 5) >= 0)
				{
					$sql = "INSERT INTO `ip_banned`(`ip`,`user`) 
							VALUES ('" . $user["ip"] . "'," . $user["id"] . ")";

					$req = $dbh->prepare($sql);
					$req->execute();
					
					$sql = "UPDATE `users` 
						SET `rigths` = 0 
						WHERE id = " . $user["id"];
			
					$req = $dbh->prepare($sql);
					$req->execute();
				}
				
				header('Location: ../../portails/'.$portal["server"]);
			}
		else
			{
				header('Location: ../..');
			}
	}
	else
	{
		header('Location: ../..');
	}
	
	?>