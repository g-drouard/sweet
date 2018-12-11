<?php 

ob_start();

include("header.php");

$buffer = ob_get_contents();

var_dump($buffer);

ob_end_clean();

$buffer = str_replace("%TITLE%",$server["name"],$buffer);

echo $buffer;

if(isset($_GET["id"]) && !empty($_GET["id"]))
{
$server_id = intval($_GET["id"]);
}
else
{
header('Location: /serveurs');
}

$sql = "SELECT *
FROM servers
WHERE id = " . $server_id;

$req = $dbh->prepare($sql);
$req->execute();
$server = $req->fetch();

if($server == false)
{ ?>
<main id='dim_list' class="container-fluid">

<div class="vertical">
<div class="vertical-center">

<h1>Le serveur sur lequel vous essayez d'aller n'existe pas ou a été fusionné<?php if($_SESSION['user_id']) echo ', <a href="/updateProfil.php">cliquez ici</a> pour actualiser votre serveur si il y a eu une fusion'; ?>.</h1>

</div>
</div>

</main>
<?php }
else
{

$sql = "SELECT id, server, name, ip, posX, posY, canopee, unknowing, number_utilisations, user, votes_number, reports_number,
cycle,current_modificateur, DAY(date) AS jour, MONTH(date) AS mois, HOUR(date) AS heure, MINUTE(date) AS minute,
CONCAT(
FLOOR(HOUR(TIMEDIFF(date, NOW())) / 24), ' j ',
MOD(HOUR(TIMEDIFF(date, NOW())), 24), ' h ',
LPAD(MINUTE(TIMEDIFF(date, NOW())), 2, '0'), ' min') as FULL_DATE
FROM portals
WHERE server = " . $server_id .
" ORDER BY name";

$req = $dbh->prepare($sql);
$req->execute();
$portals = $req->fetchAll();

$infos = "";
$annonce = "";

?>

<main id='dim_list' class="container-fluid">

<div class="pub">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Pub portails haut -->
<ins class="adsbygoogle"
 style="display:inline-block;width:728px;height:90px"
 data-ad-client="ca-pub-9064407582480322"
 data-ad-slot="9311745294"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>

<?php
foreach($portals as $portal):

if($_SESSION["login"] != NULL)
{
$sql = "SELECT *
FROM votes
WHERE portal = " . $portal["id"] .
" AND (user = " . $_SESSION["user_id"] .
" OR user_ip = '" . $_SERVER['REMOTE_ADDR'] . "')";

$req = $dbh->prepare($sql);
$req->execute();
$vote = $req->fetch();
}

$sql = "SELECT *
FROM modificateurs
WHERE id = " . $portal["current_modificateur"];

$req = $dbh->prepare($sql);
$req->execute();
$current_modificateur = $req->fetch();

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

if($portal["unknowing"] == 1)
{
$annonce .= $portal["name"] . " Position Inconnue";
}
else
{
$annonce .= "{map," . $portal["posX"] . "," . $portal["posY"] . ",";

if($portal["canopee"] == 1)
{
$annonce .= "10, ";
}
else
{
$annonce .= "1, ";
}

$annonce .= $portal["name"] . " }";
}


$infos .= $portal["name"];

if($portal["unknowing"] == 1)
{
$infos .= " Position inconnue ";
}
else
{
$infos .= " [" . $portal["posX"] . "," . $portal["posY"] . "] ";
if($portal["canopee"] == 1)
{
$infos .= "(Canopée) ";
}
}

$current_modificateur_name = str_replace("é","e",$current_modificateur["name"]);
$current_modificateur_name = str_replace("ê","e",$current_modificateur_name);
$current_modificateur_name = str_replace("è","e",$current_modificateur_name);
$current_modificateur_name = str_replace("'","_",$current_modificateur_name);
$current_modificateur_name = str_replace("-","_",$current_modificateur_name);
$current_modificateur_name = str_replace(" ","_",$current_modificateur_name);?>

<div class="portal">

<div class="dimension text-center col-xs-8 col-sm-5 col-lg-3">

<div class="vertical">
<div class="vertical-center">

<h2 class="text-center text-uppercase"><?= $portal["name"]; ?></h2>
<img src="../images/portals/<?= $portal["name"]; ?>.png" height="160">
<br>
<a href="/historique/<?= $portal["id"]; ?>" class="btn static">Historique</a>

</div>
</div>

</div>

<div class="infos text-center col-xs-13 col-sm-6 col-lg-4">

<div class="vertical">
<div class="vertical-center">

<?php if($portal["unknowing"] == 1) { ?>

<h2 class="text-center text-uppercase"><font color="red">Position Inconnue</font></h2>

<?php } else { ?>

<h2 class="text-center text-uppercase">Position<?php if($portal["canopee"] == 1) { ?> (Canopée)<?php } ?></h2>
<h3 class="text-center"><b>[<?= $portal["posX"]; ?>,<?= $portal["posY"]; ?>]</b></h3>

<h3 class="text-center">Utilisations <b><?php if($portal["number_utilisations"] <= 20) { echo '<font color="red">' . $portal["number_utilisations"] . '</font>'; } else { if($portal["number_utilisations"] <= 50) { echo '<font color="orange">' . $portal["number_utilisations"] . '</font>'; } else { echo '<font color="green">' . $portal["number_utilisations"] . '</font> '; } } ?></b></h3>
<button class="copybtn btn" data-clipboard-text="<?= $portal["name"] . " [" . $portal["posX"] . "," . $portal["posY"] . "]" . " - " . $portal["number_utilisations"] . " utilisations - " . $current_modificateur["name"]; ?>">Copier les infos</button>

<?php } ?>

</div>
</div>

</div>

<div class="cycle text-center hidden-xs col-sm-6 col-lg-15">

<div class="vertical">
<div class="vertical-center">

<?php 

$sql = "SELECT * FROM modificateurs
WHERE id = " . $portal["current_modificateur"];

$req = $dbh->prepare($sql);
$req->execute();
$current_modificateur = $req->fetch(); 

?>

<h2 class='text-uppercase'>Modificateur <p class="survol">(survolez pour voir les effets)</p></h2>
<h3><?= $current_modificateur["name"];?></h3>

<div class="modificateurs">

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

<div class="text-center <?php if($modificateur["id"] != $portal["current_modificateur"]){ echo ' visible-lg-inline';}?>">
<img class="cycle<?php if($modificateur["id"] == $portal["current_modificateur"]){ echo ' current_modificateur';}?>" src="../images/modificateurs/<?= $modificateur_name; ?>.png" title="<?= $modificateur["name"] . " : " . $modificateur["description"]; ?>" height="50" width="50">
</div>

<?php } ?>

</div>

</div>

</div>

</div>

<div class="user text-center hidden-xs col-sm-8 col-md-9 col-lg-5">

<div class="vertical">
<div class="vertical-center">
<div class="grade-<?= $user["grade"];?>">
<a class="grade" href="/profil/<?=$user['id']?>"></a>
<span><?= $user["username"];?></span>
<span class="titre"><?php if($user["username"]=="Pom-damour"){echo "&laquo; Moderateur &raquo;";}else if($user["username"]=="Miysis"){echo "&laquo; Fondateur du site &raquo;";}else{echo "&laquo; ".$grade["name"]." &raquo;";}?></span>
</div>
<?php if(empty($vote) && ($portal["user"] != $_SESSION['user_id']) && ($_SESSION['login'] != NULL ) && ($_SERVER['REMOTE_ADDR'] != $portal["ip"]) && $_SESSION["rigths"] != 0) {?>
<?php if($portal["unknowing"] != 1) {?>
<a class="confirm btn text-center" href="/confirmation/<?= $portal["id"]; ?>"><span class='badge'><?= $portal["votes_number"];?></span>Confirmer la position</a>
<?php }?>
<button type="button" class="report btn text-center" data-id="<?= $portal["id"]; ?>" data-toggle="modal" data-target="#VoteBan"><span class='badge'><?= $portal["reports_number"];?></span>Demander le ban</button>
<?php }else{?>
<?php if($portal["unknowing"] != 1) {?>
<h2 class='confirm'><span class='number'><?= $portal["votes_number"];?></span> Confirmation<?php if($portal["votes_number"] >= 2) { echo 's'; } ?></h2>
<?php }?>
<h2 class='report'><span class='number'><?= $portal["reports_number"];?></span> Report<?php if($portal["reports_number"] >= 2) { echo 's'; } ?></h2>
<?php }?>

</div>
</div>

</div>

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

<div class="maj text-center col-xs-9 col-sm-5 col-md-4 col-lg-3">

<div class="vertical">
<div class="vertical-center">

<?php if($portal["unknowing"] != 1) {?>
<h4 class="text-center text-uppercase">Mis à jour il y a </h4>
<h3 class="text-center" ><?php echo $portal['FULL_DATE'];?></h3>
<?php }?>
<a class="btn text-center" href="/edit/<?= $portal["id"]; ?>">Mettre à jour</a>
</div>
</div>

</div>

</div>

<?php 

endforeach; 

?>

<div class=" copyAll">
<button class = "copybtn btn" data-clipboard-text="<?= $infos;?>">Copier les positions de <?= $server['name']?></button>
<button id="right" class = "copybtn btn" data-clipboard-text="<?= $annonce;?>">Copier pour une annonce de guilde/alliance</button>
</div>


<!-- Popup VoteBan -->
<div class="modal fade" id="VoteBan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
<div class="modal-content">
  <div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title" id="myModalLabel">Demande de ban</h4>
  </div>
  <div class="modal-body">
Vous êtes sur le point de demander le bannissement de ce joueur, cela n'est à faire que dans le cas où le joueur s'amuse volontairement à donner de fausses informations et non si les informations qu'il communique ne sont plus d'actualité, confirmez-vous qu'il s'agit d'un joueur qui fait chier son monde ?
  </div>
  <div class="modal-footer">
<a class="btn text-center" id="confirmReport" href="#">Confirmer la demande</a>
<button type="button" class="btn" data-dismiss="modal">Annuler</button>
  </div>
</div>
  </div>
</div>

</main>

<?php include("footer.php"); ?>
<script type= "text/javascript">
$(document).on("click", ".report", function () {
var portalId = $(this).data('id');
var href = "/voteban/" + portalId;
var element = document.getElementById('confirmReport');
element.href = href;
});
</script>
<?php } ?>