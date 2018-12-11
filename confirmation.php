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

		$sql = "SELECT * FROM portals
			WHERE id = " . $_GET["id"];

		$req = $dbh->prepare($sql);
		$req->execute();
		$portal_test = $req->fetch();
		
		if ($portal_test != false) {
			
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
					WHERE id = " . $_GET["id"];
					
			$req = $dbh->prepare($sql);
			$req->execute();
			$portal = $req->fetch();
			
			if(empty($vote) && $_SESSION["user_id"] != $portal["user"] && $_SERVER['REMOTE_ADDR'] != $portal["ip"])
			{
							
			
				$sql = "INSERT INTO `votes`(`portal`, `user`, `user_ip`, `date`) 
						VALUES (" . $portal["id"] . "," . $_SESSION["user_id"] . ",'" . $_SERVER['REMOTE_ADDR'] . "', NOW())";

				$req = $dbh->prepare($sql);
				$req->execute();
			
				$sql = "UPDATE `portals` 
						SET `votes_number` = `votes_number` + 1
						WHERE id = " . $_GET["id"];
			
				$req = $dbh->prepare($sql);
				$req->execute();
			
				$sql = "UPDATE `users` 
						SET `votes_sent` = `votes_sent` + 1 
						WHERE id = " . $_SESSION["user_id"];
			
				$req = $dbh->prepare($sql);
				$req->execute();
			
				$sql = "UPDATE `users` 
						SET `votes_number` = `votes_number` + 1,
						`votes_number_current_grade` = `votes_number_current_grade` + 1 
						WHERE id = " . $portal["user"];
			
				$req = $dbh->prepare($sql);
				$req->execute();
			
				$sql = "SELECT * 
						FROM users
						WHERE id = " . $portal["user"];
			
				$req = $dbh->prepare($sql);
				$req->execute();
				$user = $req->fetch();
			
			
				$sql = "SELECT * 
						FROM grades 
						WHERE id = " . $user["grade"];
			
				$req = $dbh->prepare($sql);
				$req->execute();
				$grade = $req->fetch();
				
				if($user["votes_number_current_grade"] >= $grade["number_votes_next"])
				{
					$sql = "UPDATE `users` 
							SET `grade` = `grade` + 1,
							`votes_number_current_grade` = 0 
							WHERE id = " . $portal["user"];
							
					$req = $dbh->prepare($sql);
					$req->execute();
				}
			
				header('Location: ../../portails/'.$portal["server"]);
			}
			else
			{
				header('Location: ../../portails/'.$portal["server"]);
			}
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