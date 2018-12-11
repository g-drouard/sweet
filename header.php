<?php
session_start();
$dbname = 'sweetovhrvsweet';
$user = 'sweetovhrvsweet';
$password = '########';
$dsn = 'mysql:dbname=' . $dbname . ';host=sweetovhrvsweet.mysql.db;charset=utf8';
$options = array(
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
PDO::ATTR_EMULATE_PREPARES => false,
);
$dbh = new PDO($dsn, $user, $password, $options);
if(isset($_COOKIE["user_id"]))
{
$_SESSION['login'] = 1;
$_SESSION['user_id'] = $_COOKIE["user_id"];
$_SESSION['username'] = $_COOKIE["username"];
$_SESSION['server'] = $_COOKIE["server"];
$_SESSION['rigths'] = $_COOKIE["rigths"];
}
$server_id = intval($_GET["id"]);
$sql = "SELECT *
FROM servers
WHERE id = " . $server_id;
$req = $dbh->prepare($sql);
$req->execute();
$server = $req->fetch();
?>
<!DOCTYPE html>
<html>
<head>
<title>%TITLE%</title>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../css/msdropdown.min.css" />
<link rel="stylesheet" type="text/css" href="../css/style.min.css">
<link rel="stylesheet" type="text/css" href="../css/dataTables.min.css">
<link rel="icon" type="image/png" href="../images/icons/lion.png" />
<!--[if IE]><link rel="shortcut icon" type="image/x-icon" href="../images/icons/lion.png" /><![endif]-->
</head>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
google_ad_client: "ca-pub-9064407582480322",
enable_page_level_ads: true
  });
</script>
<body>
<header>
<nav class="navbar navbar-inverse">
<div class="container-fluid">
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav" aria-expanded="false">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<div class="navbar-header">
<a class="navbar-brand" href="/">Accueil</a>
</div>
<div id='nav' class="navbar-body collapse navbar-collapse">
<?php if($_SESSION["login"] == NULL) { ?>
<ul class="nav navbar-nav">
<li class="active"><a href="/serveurs"><span class="glyphicon glyphicon-th-list"></span> Liste des serveurs</a></li>
</ul>
<ul class="nav navbar-nav navbar-right">
<li><a id="google-sheet" href="https://docs.google.com/spreadsheets/d/1wgEEY7aYvX1gb14Ma7lQPgM7BN2C8CCy87cQFWVeMIk/edit?usp=sharing" target="_blank"><span class="glyphicon glyphicon-list-alt"></span> Calmanax</a></li>
<li><a id="yt-channel" href="https://www.youtube.com/watch?v=BPGspvDB_WU&lc" target="_blank"><span class="glyphicon glyphicon-film"></span> Chaine YouTube</a></li>
<li><a href="/partenaires"><span class="glyphicon glyphicon-thumbs-up"></span> Partenaires</a></li>
<!--<li><a href="/ladder"><span class="glyphicon glyphicon-king"></span> Ladder</a></li>-->
<li><a href="/register"><span class="glyphicon glyphicon-user"></span> Inscription</a></li>
<li><a href="/login"><span class="glyphicon glyphicon-log-in"></span> Connexion</a></li>
</ul>
<?php } else { ?>
<ul class="nav navbar-nav">
<li class="<?php if(!isset($_GET['id'])){echo'active';}?>"><a href="/serveurs"><span class="glyphicon glyphicon-th-list"></span> Liste des serveurs</a></li>
<li class="<?php if(isset($_GET['id'])){echo "active";}?>"><a href="/portails/<?php echo $_SESSION["server"]; ?>">Serveur principal</a></li>
<li><a href="/updateProfil">Actualiser mon compte (fusions)</a></li>
</ul>
<ul class="nav navbar-nav navbar-right">
<li><a id="google-sheet" href="https://docs.google.com/spreadsheets/d/1wgEEY7aYvX1gb14Ma7lQPgM7BN2C8CCy87cQFWVeMIk/edit?usp=sharing" target="_blank"><span class="glyphicon glyphicon-list-alt"></span> Calmanax</a></li>
<li><a id="yt-channel" href="https://www.youtube.com/watch?v=BPGspvDB_WU&lc" target="_blank"><span class="glyphicon glyphicon-film"></span> Chaine YouTube</a></li>
<li><a href="/partenaires"><span class="glyphicon glyphicon-thumbs-up"></span> Partenaires</a></li>
<!--<li><a href="/ladder"><span class="glyphicon glyphicon-king"></span> Ladder</a></li>-->
<li><a href="/profil/<?php echo $_SESSION["user_id"]; ?>"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION["username"]; ?></a></li>
<li><a href="/login"><span class="glyphicon glyphicon-log-out"></span> Se déconnecter</a></li>
</ul>
<?php }?>
</div>
</div>
</nav>
</header>