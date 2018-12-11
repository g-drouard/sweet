<?php 

	ob_start();

	include("header.php");

	$buffer = ob_get_contents();

	ob_end_clean();

	$buffer=str_replace("%TITLE%",$server["name"]." - Mon IP - L'annuaire des portails",$buffer);

	echo $buffer;?>
	<div class="background_partenaires">
	<main id="partenaires" class='container'>
	<div class='vertical'>
	<div class='vertical-center'>
	<h1 class="titleEffect">Partenaires</h1>
	<div class="left">
	<div class="partenairesEntraide partenairesLeft">La plateforme Entraide a été pensée et initiée afin d'aider les joueurs du serveur Pouchecot dans divers domaines tels que : le passage de Donjons, le Théorycraft, le Roleplay, les Tournois etc...<br>
	<br>
	Un lieu de discussion entre les joueurs permettant à ceux-ci de débattre sur de nombreux sujets sans distinction de guilde ou d'alliance.<br>
	Plateforme jugée trop 'élitiste' par une partie de la communauté, j'ai alors mêlé un projet d'études avec l'ancien forum utilisé afin de redonner un second souffle à celui-ci.<br>
	<br>
	Désormais plus axée sur la communauté, la plateforme accueillera n'importe quel joueur francophone de DOFUS MMO (et de Dofus-Touch !). Des sections dédiées au serveur Pouchecot sont présentes et nous y hébergerons la section Goultarminator comme l'année précédente.<br>
	<br>
	Divers outils sont à votre disposition afin de vous aider dans votre vie de joueur. N'hésitez pas à nous faire vos propositions sur le forum !<br>
	Pour toutes vos questions, n'hésitez pas à me contacter sur la plateforme ou sur Twitter !<br>
	<br>
	Bon jeu sur Dofus !<br>
	<br>
	<b>Sala'</b></div>
	<img src="../images/Fleche.png"/>
	<a href="http://entraide.ordre2vlad.fr/" target="_blank"><img class="img-center" src="/images/Entraide.png"/></a>
	</div>
	<div class="right">
	<div class="partenairesDofusExchange partenairesRight">DofusExchange vous offre la possibilité de gérer vos fragments, aussi bien ceux de cartes légendaires que ceux servant à l'amulette Ementaire et de gérer vos captures d'archimonstres.
	<br>
	<br>
	Bon jeu à tous et bonnes chasses aux archis ainsi que de bons échanges !
	<br>
	<br>
	<b>Coonstance & Niagami.</b></div>
	<img src="../images/Fleche.png"/>
	<a href="http://www.dofusexchange.com/fr/" target="_blank"><img class="img-center banniereDofusExchange" src="/images/DofusExchange.png"/></a>
	<div class="partenairesRight partenairesDofusTournaments">
	<p class="partenairesTitle text-center">Dofus Tournaments</p>
	<p>Vous êtes fans de PvPm, vous avez juste envie d'essayer ce mode de jeu ou vous voulez juste suivre les différents tournois PvPm Dofus ?</p>
	<p>N'hésitez plus et rendez vous sur Dofus Tournaments, de nombreux tournois sur la plupart des serveurs vous attendent !</p>
	</div>
	<img src="../images/Fleche.png"/>
	<a href="https://dofus-tournaments.fr/" target="_blank"><img style="margin-bottom: 20px;" class="img-center" src="/images/DofusTournaments.png"/></a>
	</div>
	</div>
	</div>
	</main>
	</div>
	<?php include("footer.php"); ?>