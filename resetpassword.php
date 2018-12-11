<?php 

	ob_start();

	include("header.php");

	$buffer = ob_get_contents();

	ob_end_clean();
	
	$buffer = str_replace("%TITLE%","Réinitilisation du mot de passe - L'annuaire des portails",$buffer);

	echo $buffer;
	
	$error = 0;
	
	if(isset($_GET["id"]) && !empty($_GET["id"]))
	{
		
	$_GET["id"] = intval($_GET["id"]);
	
	$sql = "SELECT * 
			FROM users
			WHERE id = " . $_GET["id"];
	
	$req = $dbh->prepare($sql);
	$req->execute();
	$user = $req->fetch();
	
	if(isset($_POST["password"]) && isset($_POST["confirm_password"]))
	{
		if(strlen($_POST["password"])>=1 
		&& strlen($_POST["password"])<=30 
		&& strlen($_POST["confirm_password"])>=1 
		&& strlen($_POST["confirm_password"])<=30)
		{
			if($_POST["password"] == $_POST["confirm_password"])
			{
				if($_SERVER['REMOTE_ADDR'] == $user["ip"] || $_SERVER['REMOTE_ADDR'] == $user["last_ip"] || $_SESSION["user_id"] == $user["id"])
				{
					$hashed_password = md5($_POST["password"]);
				
					$sql = "UPDATE `users` 
							SET `password` = " . $dbh->quote($hashed_password) . 
							"WHERE id = " . $_GET["id"];
							
					$req = $dbh->prepare($sql);
					$req->execute();
					
					header('Location: ../login');
				}
				else
				{
					header('Location: ../..');
				}
			}
			else
			{
				$error = 1;
			}
		}
		else
		{
			$error = 2;
		}
	}
	
	if(!empty($user))
	{
	
	if($_SERVER['REMOTE_ADDR'] == $user["ip"] || $_SERVER['REMOTE_ADDR'] == $user["last_ip"] || $_SESSION["user_id"] == $user["id"])
	{
	?>
	<main id='resetpassword'>
		
	<div class="vertical">
		
		<div class="vertical-center">
		
		<?php if($error == 1)
		{ ?>
		<div class="alert alert-danger text-center">
			<strong>Les mots de passe ne correspondent pas</strong>
		</div>
		<?php } ?>
		
		<?php if($error == 2)
		{ ?>
		<div class="alert alert-danger text-center">
			<strong>Champs manquants</strong>
		</div>
		<?php } ?>
		
		<h1>Changement du mot de passe de <?= $user["username"]; ?></h1>
		
		<br>
		
		<div class="centered-form">
		
			<div class="col-xs-30 col-sm-20 col-md-16 col-lg-10 col-sm-offset-5 col-md-offset-7 col-lg-offset-10">
		
			<div class="panel panel-default">
			
			<div class="panel-heading">
				<h3 class="panel-title">Votre nom d'utilisateur est <b><?= $user["login"];?></b></h3>
		 	</div>
		
			<div class="panel-body">
		
			<form method="post" action="/resetpassword/<?= $user["id"];?>">
			
				<div class="col-xs-15">
					<div class="form-group">
						<input type="password" class="form-control input-sm" name="password" placeholder="Nouveau mot de passe" maxlength="30" required>
					</div>
				</div>
				
				<div class="col-xs-15">
					<div class="form-group">
						<input type="password" class="form-control input-sm" name="confirm_password" placeholder="Confirmation du mot de passe" maxlength="30" required>
					</div>
				</div>
				
				<input id="resetpasswordsubmit" type="submit" value="Valider" class="btn btn-block">
			
			</form>
			
			</div>
		
			</div>
		
			</div>
		
		</div>
		
		</div>
		
	</div>
		
	</main>
	<?php include("footer.php"); }
	else
	{ ?>
	<main id='resetpassword'>
	<div class="vertical">
		<div class="vertical-center">
		<h1>Veuillez vous connecter avec la connexion internet avec laquelle a été créé le compte ou avec laquelle vous vous êtes connectés avec pour la dernière fois, si vous rencontrez un problème n'hésitez pas à nous contacter à <b>sweetovh@gmail.com</b></h1>
		</div>
	</div>
	</main>
	<?php include("footer.php"); }
	}
	else{
		header('Location: ../..');
	}
	}
	else
	{
		header('Location: ../..');
	}
?>
