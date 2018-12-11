<?php

	ob_start();

	include("header.php");

	$buffer = ob_get_contents();

	ob_end_clean();

	$buffer=str_replace("%TITLE%","Inscription - L'annuaire des portails",$buffer);

	echo $buffer;

	$error = 0;
	
	if(isset($_POST["username"]))
	{
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

		if((strlen($_POST["username"])>=1)
		&& (strlen($_POST["username"])<=20)
		&& $file["success"]
		&& isset($_POST["login"])
		&& (strlen($_POST["login"])>=1)
		&& (strlen($_POST["login"])<=30)
		&& isset($_POST["password"])
		&& (strlen($_POST["password"])>=1)
		&& (strlen($_POST["password"])<=30)
		&& isset($_POST["server"])
		&& isset($_POST["password_confirmation"])
		&& (strlen($_POST["password_confirmation"])>=1)
		&& (strlen($_POST["password_confirmation"])<=30))
		{
			$sql = "SELECT * FROM servers
				WHERE id = " . $_POST["server"];

			$req = $dbh->prepare($sql);
			$req->execute();
			$server_test = $req->fetch();
			
			if($server_test)
			{
				if($_POST["password_confirmation"] == $_POST["password"])
				{		
					$sql = "SELECT * FROM users WHERE username = " . $dbh->quote($_POST["username"]);
					
					$req = $dbh->prepare($sql);
					$req->execute();
					$user = $req->fetchAll();

					if(empty($user))
					{
						$sql = "SELECT * FROM users WHERE login = " . $dbh->quote($_POST["login"]);
					
						$req = $dbh->prepare($sql);
						$req->execute();
						$user = $req->fetchAll();
						
						if(empty($user))
						{
							$hashed_password = md5($_POST["password"]);

							$_POST["username"] = htmlspecialchars($_POST["username"]);
							$_POST["login"] = htmlspecialchars($_POST["login"]);
					
							$sql = "INSERT INTO `users`(`username`, `login`, `password`, `server`, `ip`) 
									VALUES (" . $dbh->quote($_POST["username"]) . 
									"," . $dbh->quote($_POST["login"]) . 
									"," . $dbh->quote($hashed_password) . 
									"," . $_POST["server"] . 
									"," . $dbh->quote($_SERVER['REMOTE_ADDR']) . ")";
					
							$req = $dbh->prepare($sql);
							$req->execute();		

							header('Location: login');
						}
						else
						{
							$error = 4;
						}
					}
					else
					{
						$error = 2;
					}
				}
				else
				{
					$error = 1;
				}
			}
			else
			{
				$error = 3;
			}
		}
		else
		{
			$error = 3;
		}
	}

	$sql = "SELECT *
			FROM servers
			ORDER BY name";

	$req = $dbh->prepare($sql);
	$req->execute();
	$servers = $req->fetchAll();
?>

	<main id='register' class="container-fluid">

	<?php 

			if($error == 1)
			{?>

				<div class="alert alert-danger text-center">
					<strong>Les mots de passe ne correspondent pas</strong>
				</div>

			<?php }

			if($error == 2)
			{?>

				<div class="alert alert-danger text-center">
					<strong>Pseudo déjà utilisé</strong>
				</div>

			<?php }

			if($error == 3)
			{?>

				<div class="alert alert-danger text-center">
					<strong>Champs manquants</strong>
				</div>

			<?php }

			if($error == 4)
			{?>

				<div class="alert alert-danger text-center">
					<strong>Nom d'utilisateur déjà utilisé</strong>
				</div>

			<?php }?>

		<div class="row centered-form">

			<div class="col-xs-30 col-sm-20 col-md-16 col-lg-10 col-sm-offset-5 col-md-offset-7 col-lg-offset-10">

				<div class="panel panel-default">

					<div class="panel-heading">
						<h3 class="panel-title"><b>IMPORTANT !</b> Ne mettez <b>PAS</b> votre identifiant ou mot de passe de Dofus</h3>
		 			</div>

		 			<div class="panel-body">

						<form method="post" action="/register">

							<div class="row">

								<div class="col-xs-15">
									<div class="form-group">
										<input type="text" name="username" class="form-control input-sm" placeholder="Pseudo" maxlength="20" required>
									</div>
								</div>

								<div class="col-xs-15">
									<div class="form-group">
										<input type="text" name="login" class="form-control input-sm" placeholder="Nom d'utilisateur" maxlength="30" required>
									</div>
								</div>

							</div>
						
							<div class="row">

								<div class="col-xs-15">
									<div class="form-group">
										<input type="password" name="password" class="form-control input-sm" placeholder="Mot de passe" maxlength="30" required>
									</div>
								</div>

								<div class="col-xs-15">
									<div class="form-group">
										<input type="password" name="password_confirmation" class="form-control input-sm" placeholder="Confirmation du mot de passe" maxlength="30">
									</div>
								</div>

							</div>

							<div class="form-group text-center">

								<h4>Serveur :</h4>

								<select name="server">

									<?php

										foreach($servers as $server) :
									
									?>

										<option value="<?php echo $server["id"]; ?>" <?php if($server["id"] == 2) echo "selected"; ?> required><?php echo $server["name"]; ?></option>

									<?php 

										endforeach; 
									
									?>

								</select>

							</div>
							<div style="display:flex;">
							<di style="margin:auto;" class="g-recaptcha" data-sitekey="6LcExjcUAAAAAEdlqsObyM40i_XTeLPlTsIgjIJX"></div>
							</div>
							<input type="submit" value="Valider l'inscription" class="btn btn-info btn-block">

						</form>

					</div>

				</div>

			</div>

		</div>

	</main>

<?php include("footer.php"); ?>