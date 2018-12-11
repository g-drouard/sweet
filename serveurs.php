<?php 

	ob_start();

	include("header.php");

	$buffer = ob_get_contents();

	ob_end_clean();

	$buffer=str_replace("%TITLE%","Liste des serveurs - L'annuaire des portails",$buffer);

	echo $buffer;

	$sql = "SELECT *
			FROM servers
			ORDER BY name";

	$req = $dbh->prepare($sql); 
	$req->execute();    
	$servers = $req->fetchAll();

?>
	<main id='serv_list' class="container-fluid">
		
		<div class="pub">
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- Pub liste serveurs haut -->
		<ins class="adsbygoogle"
			 style="display:inline-block;width:728px;height:90px"
			 data-ad-client="ca-pub-9064407582480322"
			 data-ad-slot="7835012099"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
		</div>
		
		<h2 class="text-center text-uppercase" >Sélectionnez votre serveur</h2>
		
		<div>
		<?php

			$compteur = 0;

			foreach($servers as $server) :

				$server_name = str_replace(" ","",$server["name"]);
				$server_name = str_replace("-","",$server_name);
				$server_name = str_replace("ï","i",$server_name); ?>

				<div class="col-xs-6 col-sm-5 col-lg-3 text-center">

					<div class='server'>

						<a href="portails/<?php echo $server["id"]; ?>">

							<img src="../images/servers/<?php echo $server_name;?>-min.png"/>
							<h4><?php echo $server["name"];?></h4>

						</a>

					</div>

				</div>

		<?php 

			endforeach; 

		?>
		</div>

	</main>

<?php include("footer.php"); ?>