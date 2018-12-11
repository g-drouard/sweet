<?php 

	ob_start();

	include("header.php");

	$buffer = ob_get_contents();

	ob_end_clean();
	
	$buffer = str_replace("%TITLE%","Historique - L'annuaire des portails",$buffer);

	echo $buffer;
	
	if(isset($_GET["id"]))
		{
			$_GET["id"] = intval($_GET["id"]);

			$sql = "SELECT * from portals 
					WHERE id = " . $_GET["id"];
					
			$req = $dbh->prepare($sql);
			$req->execute();
			$portal_test = $req->fetch();
			
			if ($portal_test) 
			{
				
				$sql = "SELECT id, posX, posY, canopee, unknowing, number_utilisations, user, votes_number, reports_number,current_modificateur,
						DAY(date) AS jour, MONTH(date) AS mois, HOUR(date) AS heure, MINUTE(date) AS minute,
						CONCAT(
							FLOOR(HOUR(TIMEDIFF(date, NOW())) / 24), ' j ',
							MOD(HOUR(TIMEDIFF(date, NOW())), 24), ' h ',
							LPAD(MINUTE(TIMEDIFF(date, NOW())), 2, '0'), ' min') as FULL_DATE
						FROM historique 
						WHERE portal_id = " . $_GET["id"] . " ORDER BY date DESC";

				$req = $dbh->prepare($sql);
				$req->execute();
				$portals = $req->fetchAll();
				
				$sql = "SELECT * 
						FROM portals 
						WHERE id = " . $_GET["id"];
						
				$req = $dbh->prepare($sql);
				$req->execute();
				$portal_source = $req->fetch();
				
				$sql = "SELECT *
						FROM servers 
						WHERE id = " . $portal_source["server"];
						
				$req = $dbh->prepare($sql);
				$req->execute();
				$server = $req->fetch();
				
				?>
			
			<main id='historique'>
			
			<div class="vertical">
			<div class="vertical-center">
				<h1 class="text-center"><?= $server["name"] ?></h1>
				
				<h2 class="text-center text-uppercase">Historique de la dimension <?= $portal_source["name"]; ?></h2>
				
				<p class="text-center"><img src="../images/portals/<?= $portal_source["name"]; ?>.png" height="160"></p>
				
				<a class="btn btn-historique static" href="/portails/<?= $portal_source["server"];?>">Retour à la page des portails</a>

			<?php if(!empty($portals))
			{?>
				<table class="table">
				<tbody>
				<tr>
				   <td>Position</td>
				   <td>Informateur</td>
				   <td>Modificateur</td>
				   <td>Ancienneté de l'information</td>
				</tr>
				<?php foreach($portals as $portal):
					
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
					
					$sql = "SELECT *
						FROM modificateurs
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
				?>
				<tr>
					<td>
								<?php if($portal["unknowing"] == 1) { ?>

									<h2 class="text-center text-uppercase"><font color="red">Position Inconnue</font></h2>

								<?php } else { ?>

									<h2 class="text-center text-uppercase"><?php if($portal["canopee"] == 1) { ?>(Canopée)<?php } ?></h2>
									<h3 class="text-center"><b>[<?= $portal["posX"]; ?>,<?= $portal["posY"]; ?>]</b></h3>

									<h3 class="text-center">Utilisations <b><?php if($portal["number_utilisations"] <= 20) { echo '<font color="red">' . $portal["number_utilisations"] . '</font>'; } else { if($portal["number_utilisations"] <= 50) { echo '<font color="orange">' . $portal["number_utilisations"] . '</font>'; } else { echo '<font color="green">' . $portal["number_utilisations"] . '</font> '; } } ?></b></h3>

								<?php } ?>
					</td>	
					<td>
									<h2 class="text-center text-uppercase">Renseigné par<br/></h2>
									<div class="grade-<?= $user["grade"];?>">
										<a class="grade" href="/profil/<?=$user['id']?>"></a>
										<span><?= $user["username"];?></span>
										<span class="titre"><?php if($user["username"]=="Pom-damour"){echo "&laquo; Moderateur &raquo;";} else if($user["username"]=="Miysis"){echo "&laquo; Fondateur du site &raquo;";} else {echo "&laquo; " . $grade["name"] . " &raquo;";}?></span>
									</div>
					</td>
					<td>
									<h3><?= $current_modificateur["name"];?></h3>
									<img src="../images/modificateurs/<?= $current_modificateur_name; ?>.png" title="<?= $current_modificateur["name"] . " : " . $current_modificateur["description"]; ?>" height="50" width="50">
					</td>
			
				<?php

						if(substr($portal['FULL_DATE'], 0, 3) == '0 j')
						{
							$portal['FULL_DATE'] = str_replace('0 j','',$portal['FULL_DATE']);

							if(substr($portal['FULL_DATE'], 0, 4) == ' 0 h')
							{
								if(substr($portal['FULL_DATE'], 5, 1) == '0')
								{
									$portal['FULL_DATE'] = substr($portal['FULL_DATE'], 6, 1)." min";
								}
							}
						}

						$portal['FULL_DATE'] = str_replace(' 0 h ','',$portal['FULL_DATE']);
					?>
					<td>
								<h4 class="text-center text-uppercase">Mis à jour il y a </h4>
								<h3 class="text-center" ><?= $portal['FULL_DATE'];?></h3>
					</td>
				</tr>
				<?php endforeach; ?>
				</tbody>
				</table>
			<?php }
			else{ ?>
				<h1>Historique vide</h1>
			<?php }?>
				</div>
			</div>
			</main>
			
			<?php
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
<?php include("footer.php"); ?>