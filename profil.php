<?php

	ob_start();

	include("header.php");

	$buffer = ob_get_contents();

	ob_end_clean();
	
	$sql= "SELECT MAX(id) AS max FROM users";
	
	$req = $dbh->prepare($sql);	
    $req->execute();	
	$max = $req->fetch();
	
	
	if(isset($_GET["id"]) && !empty($_GET["id"]))
	{
		$_GET["id"] = intval($_GET["id"]);

		if(($_GET["id"]>=1) && ($_GET["id"]<=$max["max"]))
		{
			$sql = "SELECT * 
					FROM users
					WHERE id = " . $_GET["id"];
			
			$req = $dbh->prepare($sql);
		    $req->execute();
			$user = $req->fetch();

			if(!empty($user))
			{
			
			$sql = "SELECT * 
					FROM grades
					WHERE id = " . $user["grade"];
	
			$req = $dbh->prepare($sql);			
		    $req->execute();			
			$grade = $req->fetch();
			
			$sql = "SELECT * 
					FROM grades
					WHERE id = " . $user["grade"] . " + 1";
	
			$req = $dbh->prepare($sql);			
		    $req->execute();			
			$next_grade = $req->fetch();
			
			$sql = "SELECT * 
					FROM servers
					WHERE id = " . $user["server"];
	
			$req = $dbh->prepare($sql);			
		    $req->execute();			
			$server = $req->fetch();
			
			$server_name = str_replace(" ","",$server["name"]);
			$server_name = str_replace("-","",$server_name);
			$server_name = str_replace("ï","i",$server_name);
			
			$percent = $user["votes_number_current_grade"]/$grade["number_votes_next"]*100;
			$votes_restants = $grade["number_votes_next"]-$user["votes_number_current_grade"];

			$buffer=str_replace("%TITLE%","Profil de ".$user["username"]." - L'annuaire des portails",$buffer);

			echo $buffer;
			
			$s_votes = "";
			
			if($user["votes_number"] > 1)
			{
				$s_votes = "s";
			}

			if($votes_restants == 1)
			{
				$s = "";
			}
			else
			{
				$s = "s";
			}?>

			<main id='profil'>

				<div class='vertical'>

					<div class='vertical-center'>

						<h1 class="text-center">Profil de</h1>
						<div class="grade-<?= $user["grade"];?>">
							<span><?= $user["username"];?></span>
							<span class="titre"><?php if($user["username"]=="Pom-damour"){echo "&laquo; Moderateur &raquo;";}elseif($user["username"]=="Miysis"){echo "&laquo; Fondateur du site &raquo;";}else{echo "&laquo; ".$grade["name"]." &raquo;";}?></span>
						</div>
						<?php if($user["rigths"] == 0) { ?>
						<h2>Joueur banni pour avoir fait le petit enfant</h2>
						<?php }?>
						<a href="../portails/<?= $user["server"];?>" ><h2 class="center"><?= $server["name"]; ?></h2>
						<img src="../images/servers/<?php echo $server_name;?>-min.png"/></a>
						<?php if($_SESSION["user_id"] == $user["id"])
						{ ?>
						<h3><a href="/resetpassword/<?= $_SESSION["user_id"]; ?>">Changer son mot de passe</a></h3>
						<?php } ?>
						<h3 class="center"><?= $user["votes_number"]; ?> confirmation<?= $s_votes?> totale<?= $s_votes?></h3>
						<h3 class="center"><?= $votes_restants; ?> confirmation<?= $s?> restante<?= $s?> pour up</h3>

						<div class="progress">
							<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="<?= $percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $percent; ?>%">
							</div>
							<div class="progression">
								<?= $user["votes_number_current_grade"]." / ".$grade["number_votes_next"]?>
							</div>

						</div>
						<div class="next_grade">
						<h2 class="text-center">Prochain Rang</h2>
						<div class="grade-<?= $user["grade"] + 1;?>">
							<span><?= $user["username"];?></span>
							<span class="titre"><?php if($user["username"]=="Pom-damour"){echo "&laquo; Moderateur &raquo;";}else{echo "&laquo; ".$next_grade["name"]." &raquo;";}?></span>
						</div>
						</div>

					</div>

				</div>

			</main>

			<?php include("footer.php");
			}
			else
			{
				$buffer=str_replace("%TITLE%",$server["name"]." - Compte supprimé - L'annuaire des portails",$buffer);
				
				echo $buffer;?>
				<main id='profil'>
				
				<div class='vertical'>

					<div class='vertical-center'>

					<h1>Compte supprimé</h1>
					
					</div>
				
				</div>
				
				</main>
			<?php include("footer.php");
			}
		}
		else
		{
			header('Location: /serveurs');
		}
	}
	else
	{
		header('Location: /serveurs');
	}

?>