<?php 

	ob_start();

	include("header.php");

	$buffer = ob_get_contents();

	ob_end_clean();

	$buffer=str_replace("%TITLE%","Connexion - L'annuaire des portails",$buffer);

	echo $buffer;

	$error = 0;
	
	if(isset($_SESSION['username']))
	{
		session_start();
		setcookie("user_id", null, -1, "/");
		setcookie("username", null, -1, "/");
		setcookie("server", null, -1, "/");
		setcookie("rigths", null, -1, "/");
		session_destroy();
		header('Location: ..');
	}

	if(isset($_POST["login"]))
	{
		if((strlen($_POST["login"])>=1)
		&& (strlen($_POST["login"])<=30)
		&& isset($_POST["password"])
		&& (strlen($_POST["password"])>=1)
		&& (strlen($_POST["password"])<=30))
		{
			$hashed_password = md5($_POST["password"]);
		
			$_POST["username"] = htmlspecialchars($_POST["username"]);
			$_POST["login"] = htmlspecialchars($_POST["login"]);
		
			$sql = "SELECT * 
					FROM users
					WHERE login = " . $dbh->quote($_POST["login"]) .
					" AND password = " . $dbh->quote($hashed_password);

			$req = $dbh->prepare($sql);
			$req->execute();
			$user = $req->fetch();

			if(empty($user))
			{
				$error = 1;
			}
			else
			{
				$sql = "UPDATE `users` SET `last_connexion`= NOW(), `last_ip` = '" . $_SERVER['REMOTE_ADDR'] . "' WHERE `id` = " . $user["id"];
				
				$req = $dbh->prepare($sql);
				$req->execute();
				
				$_SESSION['login'] = 1;
				$_SESSION['user_id'] = $user["id"];
				$_SESSION['username'] = $user["username"];
				$_SESSION['server'] = $user["server"];
				$_SESSION['rigths'] = $user["rigths"];

				if(!empty($_POST["remember"]))
				{
					setcookie("login", $_POST["login"], time() + (86400 * 30), "/");
					setcookie("password", $_POST["password"], time() + (86400 * 30), "/");
					setcookie("remember", 1, time() + (86400 * 30), "/");
				}
				
				if(!empty($_POST["connected"]))
				{
					setcookie("user_id", $user["id"], time() + (86400 * 30), "/");
					setcookie("username", $user["username"], time() + (86400 * 30), "/");
					setcookie("server", $user["server"], time() + (86400 * 30), "/");
					setcookie("rigths", $user["rigths"], time() + (86400 * 30), "/");
				}

				header('Location: portails/' .$_SESSION['server']);
			}
		}
		else
		{
			$error = 2;
		}
	}

	if(isset($_COOKIE["login"]))
	{
		$login_remember = $_COOKIE["login"];
	}
	else
	{
		$login_remember = "";
	}

	if(isset($_COOKIE["password"]))
	{
		$password_remember = $_COOKIE["password"];
	}
	else
	{
		$password_remember = "";
	}
	
	if(isset($_COOKIE["remember"]))
	{
		$remember = 1;
	}
	else
	{
		$remember = 0;
	}
?>

	<main id='login' class="container-fluid">

	<?php 
			if($error == 1)
			{?>

				<div class="alert alert-danger center">
					<strong>Nom d'utilisateur et/ou mot de passe incorrect(s)</strong>
				</div>

			<?php }

			if($error == 2)
			{?>

				<div class="alert alert-danger center">
					<strong>Champs manquants</strong>
				</div>

			<?php }?>

		<div class="container centered-form">

			<div id="loginbox" class="mainbox col-md-16 col-md-offset-7 col-sm-20 col-sm-offset-5">	 

				<div class="panel panel-info">

					<div class="panel-heading">
						<div class="panel-title">Connexion</div>
					</div>

					<div style="padding-top:30px" class="panel-body" >
							
						<form class="form-horizontal" method="post" action="/login">

							<div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input type="text" class="form-control" name="login" value="<?php echo $login_remember; ?>" placeholder="Nom d'utilisateur" maxlength="30" required>
							</div>
								
							<div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
								<input type="password" class="form-control" name="password" value="<?php echo $password_remember; ?>" placeholder="Mot de passe" maxlength="30" required>
							</div>
									
							<div class="input-group">
								<div class="checkbox">
									<label class="remember">
										<input type="checkbox" name="remember" value="1" <?php if($remember == 1) { echo 'checked'; }?>> Se souvenir de moi
									</label>
								</div>
							</div>
							
							<div class="input-group">
								<div class="checkbox">
									<label class="remember">
										<input type="checkbox" name="connected" value="1" checked> Rester connecté
									</label>
								</div>
							</div>
									
							<div style="margin-top:10px" class="form-group">
								<div class="col-xs-30 controls text-center">
									<input type="submit" value="Se connecter" class="btn btn-info">
								</div>
							</div>

							<div class="form-group">
								<div class="col-xs-30 control">
									<div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
										<a href="forgotpassword">
										Mot de passe ou Nom d'utilisateur oublié ?
										</a>
										<br>
										<br>
										Vous n'avez pas de compte ?
										<a href="register">
										Inscrivez-vous ici
										</a>
										
										
									</div>
								</div>
							</div>

						</form>

					</div>

				</div>

			</div>

		</div>

	</main>


<?php include("footer.php"); ?>