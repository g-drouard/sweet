<?php 

	ob_start();

	include("header.php");

	$buffer = ob_get_contents();

	ob_end_clean();

	if($_SESSION["login"] == NULL)
	{

		$buffer=str_replace("%TITLE%","Accès réservé - L'annuaire des portails",$buffer);

		echo $buffer;?>

		<main id='login' class='container'>
			<h2 class="center" style="margin:0 auto;">
				<a class="btn btn-info" href="/register">Inscrivez-vous</a><br/>
				 et/ou <br/>
				<a class="btn btn-info" href="/login">Connectez-vous</a> <br/>
				 pour mettre à jour les positions des portails
			</h2>
		</main>

	<?php } 
	else 
	{
		
		$sql = "SELECT * FROM ip_banned
				WHERE `ip` = '" . $_SERVER['REMOTE_ADDR'] . "' OR `user` = " . $_SESSION["user_id"];

		$req = $dbh->prepare($sql);
		$req->execute();
		$ip = $req->fetchAll();

		$buffer=str_replace("%TITLE%","Modifier la position du portail - L'annuaire des portails",$buffer);

		echo $buffer;

		if (isset($_POST["posX"]) && ($_POST["posX"] >= -100) && ($_POST["posX"] <= 100) && isset($_POST["posY"]) && ($_POST["posY"] >= -100) && ($_POST["posY"] <= 100) && isset($_POST["number_utilisations"]) && ($_POST["number_utilisations"] >= 1) && ($_POST["number_utilisations"] <= 128) && isset($_POST["modificateur"]) && ($_POST["modificateur"] >= 1) && ($_POST["modificateur"] <= 25) && isset($_POST["portal_id"]) && ($_POST["portal_id"] >= 1) && ($_POST["portal_id"] <= 212)) 
		{
	
			$sql = "SELECT * FROM portals
				WHERE id = " . $_POST["portal_id"];

			$req = $dbh->prepare($sql);
			$req->execute();
			$portal = $req->fetch();
			
			$sql = "SELECT * FROM cycle_modificateurs
					WHERE id = " . $portal["cycle"];

			$req = $dbh->prepare($sql);
			$req->execute();
			$cycle = $req->fetch();

			if($_POST["modificateur"] == $cycle["modificateur_1"] || $_POST["modificateur"] == $cycle["modificateur_2"] || $_POST["modificateur"] == $cycle["modificateur_3"] || $_POST["modificateur"] == $cycle["modificateur_4"] || $_POST["modificateur"] == $cycle["modificateur_5"] || $_POST["modificateur"] == $cycle["modificateur_6"] || $_POST["modificateur"] == $cycle["modificateur_7"] || $_POST["modificateur"] == $cycle["modificateur_8"] || $_POST["modificateur"] == $cycle["modificateur_9"] || $_POST["modificateur"] == $cycle["modificateur_10"]) 
			{	
				if($_POST["unknowing"] == 'on')
				{
					$unknowing = 1;
				}
				else
				{
					$unknowing = 0;
				}
				
				if($_POST["canopee"] == 'on')
				{
					$canopee = 1;
				}
				else
				{
					$canopee = 0;
				}
				
				$sql = "UPDATE portals
						SET `posX` = " . $_POST["posX"] .
						" , `posY` = " . $_POST["posY"] .
						" , `number_utilisations` = " . $_POST["number_utilisations"] .
						" , `current_modificateur` = " . $_POST["modificateur"] .
						" , `canopee` = " . $canopee . 
						" , `unknowing` = " . $unknowing . 
						" , `ip` = '" . $_SERVER['REMOTE_ADDR'] . 
						"' , date = NOW() WHERE `id` = " . $_POST["portal_id"];

				$req = $dbh->prepare($sql);					
				$req->execute();			
				
				$sql = "UPDATE users
						SET `portals_number` = `portals_number` + 1
						WHERE `id` = " . $_SESSION["user_id"];
						
				$req = $dbh->prepare($sql);					
				$req->execute();
				
									
				if($portal["posX"] != $_POST["posX"] || $portal["posY"] != $_POST["posY"] || $portal["unknowing"] != $unknowing)
				{
					$sql = "DELETE FROM `votes` WHERE `portal` = " . $_POST["portal_id"];

					$req = $dbh->prepare($sql);					
					$req->execute();
					
					$sql = "UPDATE portals
						SET `user` = " . $_SESSION["user_id"] .
						" , `votes_number` = 0, `reports_number` = 0 
						WHERE `id` = " . $_POST["portal_id"];

					$req = $dbh->prepare($sql);					
					$req->execute();
				}
				
				if($_POST["number_utilisations"] != $portal["number_utilisations"] && $portal["user"] != $_SESSION["user_id"])
				{
					header('Location: /confirmation/'.$portal["id"]);
				}
				else
				{
					header('Location: /portails/'.$portal["server"]);
				}
			}
		}

		if(isset($_GET["id"]))
		{
			$_GET["id"] = intval($_GET["id"]);

			if ($_GET["id"] >= 1 && $_GET["id"] <= 212) 
			{
				$sql = "SELECT * FROM portals
						WHERE id = " . $_GET["id"];

				$req = $dbh->prepare($sql);		
				$req->execute();			
				$portal = $req->fetch();
		
				$sql = "SELECT * FROM modificateurs
					   WHERE id = " . $portal["current_modificateur"];

				$req = $dbh->prepare($sql);			
				$req->execute();		
				$current_modificateur = $req->fetch();
			
				$current_modificateur_name = str_replace("é","e",$current_modificateur["name"]);
				$current_modificateur_name = str_replace("ê","e",$current_modificateur_name);
				$current_modificateur_name = str_replace("è","e",$current_modificateur_name);
				$current_modificateur_name = str_replace("'","_",$current_modificateur_name);
				$current_modificateur_name = str_replace("-","_",$current_modificateur_name);
				$current_modificateur_name = str_replace(" ","_",$current_modificateur_name); 
				
				if(empty($ip))
				{?>

				<main id="edit">

					<div class='vertical'>

						<div class='vertical-center'>

							<div class="divtitle">
								<h2>Cervelles de iops et enutrofs séniles s'abstenir lors du renseignement des informations</h2>
							</div>

							<form method="post" action="edit.php">

								<input type="hidden" name="portal_id" value="<?php echo $portal["id"]?>"/>

								<table class='table'>

								   <tbody>

									   <tr>
										   <td>Dimension</td>
										   <td>Position</td>
										   <?php if($portal["unknowing"] != 0) {?>
										   <td>Nombre d'utilisations</td>
										   <?php }?>
										   <td>Modificateur actuel</td>
										   <td>Validation de la modification</td>
									   </tr>

									   <tr>
										   <td><h2><?php echo $portal["name"]; ?></h2><img src="../images/portals/<?php echo $portal["name"]; ?>.png" height="173"></td>
										   <?php if($portal["unknowing"] != 0) {?>
										   <td><h2 class="line">[<input type="number" name="posX" min="-100" max="100" step="1" value="<?php echo $portal["posX"]; ?>">,<input type="number" name="posY" min="-100" max="100" step="1" value="<?php echo $portal["posY"]; ?>">]</h2>
										   <p class="line" ><input type="checkbox" name="canopee" <?php if($portal["canopee"] == 1) { echo 'checked'; } ?> /> Village de la Canopée</p>
										   <p class="line"><input type="checkbox" name="unknowing" <?php if($portal["unknowing"] == 1) { echo 'checked'; } ?> /> Position inconnue<p></td>
										   <?php }?>
										   <td ><h2><?php if($portal["unknowing"] != 0) {?><input type="number" name="number_utilisations" min="1" max="128" step="1" value="<?php echo $portal["number_utilisations"]; ?>"><?php } else {?><p class="line"><input type="checkbox" name="unknowing" <?php if($portal["unknowing"] == 1) { echo 'checked'; } ?> /> Position inconnue<p><?php }?></h2></td>
										   
										   <td>

											   <select name="modificateur" onchange="showValue(this.value)">

												<?php 

													$sql = "SELECT *
														FROM cycle_modificateurs
														WHERE id = " . $portal["cycle"];

													$req = $dbh->prepare($sql);
													$req->execute();
													$cycle = $req->fetch();

													for($i = 1 ; $i < 11 ; $i++)
													{
														$sql = "SELECT * FROM modificateurs
														   WHERE id = " . $cycle["modificateur_".$i];
													   
														$req = $dbh->prepare($sql);
														$req->execute();
														$modificateur = $req->fetch();
													
														$modificateur_name = str_replace("é","e",$modificateur["name"]);
														$modificateur_name = str_replace("ê","e",$modificateur_name);
														$modificateur_name = str_replace("è","e",$modificateur_name);
														$modificateur_name = str_replace("'","_",$modificateur_name);
														$modificateur_name = str_replace(" ","_",$modificateur_name);
														$modificateur_name = str_replace("-","_",$modificateur_name); ?>

														<option value="<?php echo $modificateur["id"]; ?>" title="../images/modificateurs/<?php echo $modificateur_name; ?>.png" <?php if($modificateur["id"] == $portal["current_modificateur"]){ echo 'selected'; }?>><?php echo $modificateur["name"]; ?></option>
														   
													<?php } ?>

												</select>

											</td>

										   <td><p class="line"><input class="btn" value="Valider" type="submit"><a href="/portails/<?php echo $portal["server"]; ?>" class="btn" >Annuler</a></p></td>
										</tr>
									</tbody>

								</table>

							</form>

						</div>

					</div>

				</main>
			<?php
			}
			else
			{?>
			<main id="edit">
			<div class='vertical'>

						<div class='vertical-center'>
								
								<h1>Vous avez été banni du site pour avoir troll, si vous voulez demander un deban veuillez nous contacter à <b>sweetovh@gmail.com</b></h1>
			
						</div>
			
			</div>
			</main>
			<?php
			}
			}
			else 
			{
				if($_POST["number_utilisations"] != $portal["number_utilisations"] && $portal["user"] != $_SESSION["user_id"])
				{
					header('Location: /confirmation/'.$portal["id"]);
				}
				else
				{
					header('Location: /portails/'.$portal["server"]);
				}
			}
		}
		else 
		{
			header('Location: /serveurs');
		}
	}

include("footer.php"); ?>

<script language="javascript">

	$(document).ready(function(e) {
		$("body select").msDropDown();
	});

</script>