<?php 

	ob_start();

	include("header.php");

	$buffer = ob_get_contents();

	ob_end_clean();
	
	$buffer = str_replace("%TITLE%","Mot de passe oublié - L'annuaire des portails",$buffer);

	echo $buffer;
	
	$sql = "SELECT * 
			FROM users 
			WHERE ip = '" . $_SERVER['REMOTE_ADDR'] .
			"' OR last_ip = '" . $_SERVER['REMOTE_ADDR'] . "'";

	$req = $dbh->prepare($sql);
	$req->execute();
	$users = $req->fetchAll();
	
	?>
	<main id='forgotpassword'>
	<div class="vertical">
		<div class="vertical-center">
			<?php if(!empty($users))
				{
						if(count($users) > 1){?>
					<h1>Sélectionnez le compte avec lequel vous voulez réinitialiser le mot de passe</h1>
					<select id="userslist" onchange="change();">
						<?php foreach($users as $user):?>
						<option value="<?= $user["id"]; ?>" ><?= $user["username"];?></option>
						<?php endforeach;?>
					</select>
					<br>
					<a id="link" href="resetpassword/<?= $users[0]["id"]; ?>" class="btn">Réinitialiser le mot de passe de ce compte</a>
				<?php }
					else{
						header('Location: resetpassword/' . $users[0]["id"]); 
						}
				}
				else{?>
						<h1>Veuillez vous connecter avec la connexion internet avec laquelle a été créé le compte ou avec laquelle vous vous êtes connectés avec pour la dernière fois, si vous rencontrez un problème n'hésitez pas à nous contacter à <b>sweetovh@gmail.com</b></h1>
				<?php }?>
		</div>
	</div>
	</main>
	
<?php include("footer.php"); ?>

<script type="text/javascript">

   function change() {
    var user_id = $('#userslist').val();
	$('#link').attr("href", "resetpassword/" + user_id);
   }

   change();
  </script>