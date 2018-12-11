<?php 

ob_start();

include("header.php");

$buffer = ob_get_contents();

ob_end_clean();

$buffer = str_replace("%TITLE%","Sweet.ovh - Le site de recensement des portails",$buffer);

echo $buffer;

$sql= "SELECT count(id) AS max FROM users";

$req = $dbh->prepare($sql);
$req->execute();
$max = $req->fetch();
?>
<div class="background">
<main id="accueil">

<div class='vertical'>

<div class='vertical-center'>

<h1 class="titleEffect ">Bienvenue sur Sweet.ovh</h1>

<div class="text-center">
<img src="/images/Sweet.png"/>
<img src="/images/tie.png"/>
</div>
<div class="left">

<div class="presentation">
<p class="fonctionnalitesTitle text-center">Présentation</p>
<p>Ce site développé par Miysis et Tie-Phon permet de <b>recenser les positions et le nombre d'utilisations</b> de chaque <b>portail de dimension</b> ainsi que le modificateur actuel sur <b>chaque serveur</b></p>
<p class="text-center">Actuellement le site comporte <b><?= $max["max"];?> inscrits</b></p>
</div>
</div>
<div class="right">
<div class="principe">
<p class="fonctionnalitesTitle text-center">Principe</p>
<p>Le recensement est effectué par les utilisateurs du site, il est donc primordial que lorsque vous vous inscrivez sur le site vous vous engagez à <b>ne pas renseigner de fausses informations</b> juste pour alimenter votre soif de chiantise extrême</p>
<p>Le site étant basé sur l'entraide il faut bien évidemment un maximum d'utilisateurs pour être efficace, n'hésitez pas à partager le site à votre alliance/guilde ou vos amis</p>
</div>
</div>

<div class="fonctionnalites">

<h1 class="fonctionnalitesTitleMain">Fonctionnalités</h1>

<div class="left">

<div class="fonctionnalitesAll">

<p class="fonctionnalitesTitle text-center">Pour tout le monde</p>

<p class="fonctionnalitesCategories">Affichage des informations des portails</p>

<p class="fonctionnalitesDescription">Vous pouvez voir les différentes informations recensées par les utilisateurs sur l'ensemble des serveurs</p>

<p class="fonctionnalitesCategories">Copier l'ensemble des positions des portails d'un serveur ou informations détaillées de chaque portail</p>

<p class="fonctionnalitesDescription">Vous pouvez récupérer dans le presse-papier les positions de l'ensemble des portails d'un serveur</p>

<p class="fonctionnalitesDescription">Vous pouvez récupérer dans le presse-papier les positions de l'ensemble des portails d'un serveur pour les annonces de guilde et d'alliance, cette syntaxe particulière vous permettra de pouvoir cliquer directement sur les positions via l'annonce</p>

<p class="fonctionnalitesDescription">Vous pouvez également récupérer dans le presse-papier les informations détaillées d'un portail spécifique</p>

<p class="fonctionnalitesCategories">Ladder des utilisateurs et des serveurs</p>

<p class="fonctionnalitesDescription">Vous pouvez voir le classement de l'ensemble des utilisateurs et des serveurs afin de voir où en est votre serveur</p>

<p class="fonctionnalitesCategories">Historique des informations des dimensions</p>

<p class="fonctionnalitesDescription">Vous pouvez voir l'historique des informations d'une dimension, si jamais un utilisateur s'amuse à troller</p>

</div>
</div>


<div class="right">
<div class="fonctionnalitesUsers">

<p class="fonctionnalitesTitle text-center">Pour les inscrits</p>

<p class="fonctionnalitesCategories">Mettre à jour les informations des portails</p>

<p class="fonctionnalitesDescription">Vous pouvez mettre à jour les différentes informations des portails</p>

<p class="fonctionnalitesCategories">Système de confirmation et de report</p>

<p class="fonctionnalitesDescription">Pour prévenir de la fiabilité de la position renseignée, vous pouvez confirmer cette dernière en appuyant sur le bouton "Confirmer les infos"</p>

<p class="fonctionnalitesDescription">Pour gérer le cas des trolls nous avons décidé de mettre en place un système de report, vous pouvez report un utilisateur en appuyant sur le bouton "Demander le ban"</p>

<p class="fonctionnalitesCategories">Système de rangs, ornements et titres</p>

<p class="fonctionnalitesDescription">Afin de récompenser les utilisateurs se mettant au service des autres nous avons mis en place un système de rangs qui évolue en fonction du nombre de confirmations qu'ils obtiennent par les autres utilisateurs, vous pouvez voir cette évolution sur les pages de profil (en haut à droite dans la barre de menu)</p>
</div>
<div class="ameliorations">
<p class="fonctionnalitesTitle text-center">Une version 2.0 du site est en cours de développement et permettra de nombreuses nouvelles fonctionnalités</p>
</div>
</div>

<h1 class="fonctionnalitesTitleMain">Partenariat</h1>

<div class="left">
<div class="partenairesAccueil partenaireEntraideAccueil">
<p class="partenairesTitle text-center">Projet Entraide</p>
<p class="partenairesTitle text-center">Message du développeur :</p>
<p>La plateforme Entraide a été pensée et initiée afin d'aider les joueurs du serveur Pouchecot dans divers domaines tels que : le passage de Donjons, le Théorycraft, le Roleplay, les Tournois etc...</p>
<br>
<p>Un lieu de discussion entre les joueurs permettant à ceux-ci de débattre sur de nombreux sujets sans distinction de guilde ou d'alliance.</p>
<p>Plateforme jugée trop 'élitiste' par une partie de la communauté, j'ai alors mêlé un projet d'études avec l'ancien forum utilisé afin de redonner un second souffle à celui-ci.</p>
<br>
<p>Désormais plus axée sur la communauté, la plateforme accueillera n'importe quel joueur francophone de DOFUS MMO (et de Dofus-Touch !). Des sections dédiées au serveur Pouchecot sont présentes et nous y hébergerons la section Goultarminator comme l'année précédente.</p>
<br>
<p>Divers outils sont à votre disposition afin de vous aider dans votre vie de joueur. N'hésitez pas à nous faire vos propositions sur le forum !</p>
<p>Pour toutes vos questions, n'hésitez pas à me contacter sur la plateforme ou sur Twitter !</p>
<br>
<p>Bon jeu sur Dofus !</p>
<br>
<b>Sala'</b></div>
<img src="/images/Fleche.png"/>
<a href="http://entraide.ordre2vlad.fr/" target="_blank"><img class="img-center" src="/images/Entraide.png"/></a>
</div>



<div class="right">
<div class="partenairesAccueil partenaireDofusExchangeAccueil">
<p class="partenairesTitle text-center">Dofus Exchange</p>
<p class="partenairesTitle text-center">Message des développeurs :</p>
DofusExchange vous offre la possibilité de gérer vos fragments, aussi bien ceux de cartes légendaires que ceux servant à l'amulette Ementaire et de gérer vos captures d'archimonstres.
<br>
<br>
Bon jeu à tous et bonnes chasses aux archis ainsi que de bons échanges !
<br>
<br>
<b>Coonstance & Niagami.</b></div>
<img src="../images/Fleche.png"/>
<a href="http://www.dofusexchange.com/fr/" target="_blank"><img class="img-center banniereDofusExchange" src="/images/DofusExchange.png"/></a>

<div class="partenairesAccueil partenaireDofusTournamentsAccueil">
<p class="partenairesTitle text-center">Dofus Tournaments</p>
<p>Vous êtes fans de PvPm, vous avez juste envie d'essayer ce mode de jeu ou vous voulez juste suivre les différents tournois PvPm Dofus ?</p>
<p>N'hésitez plus et rendez vous sur Dofus Tournaments, de nombreux tournois sur la plupart des serveurs vous attendent !</p>
</div>
<img src="../images/Fleche.png"/>
<a href="https://dofus-tournaments.fr/" target="_blank"><img class="img-center" src="/images/DofusTournaments.png"/></a>

<div class="contact">
<p class="fonctionnalitesTitle text-center">Nous contacter</h1>
<p>N'hésitez pas à nous contacter pour tout renseignement, problème ou proposition en envoyant un mail à <b>sweetovh@gmail.com</b></p>
</div>
</div>
</div>
<div class="pub">

</div>
</div>

</div>

</main>
</div>
<?php include("footer.php"); ?>