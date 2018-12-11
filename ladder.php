<?php

	ob_start();

	include("header.php");

	$buffer = ob_get_contents();

	ob_end_clean();

	$buffer=str_replace("%TITLE%","Ladder des utilisateurs - L'annuaire des portails",$buffer);

	echo $buffer;
	
	$sql = "SELECT s.id, s.name, COUNT(DISTINCT u.username) AS INSCRITS, SUM(u.votes_number) AS CONFIRMS FROM users u INNER JOIN servers s ON s.id = u.server GROUP BY s.name ORDER BY 3 DESC";

	$req = $dbh->prepare($sql);
	$req->execute();
	$servers = $req->fetchAll();
	
	$sql = "SELECT *
			FROM users
			ORDER by votes_number DESC, username ASC LIMIT 100";

	$req = $dbh->prepare($sql);
	$req->execute();
	$users = $req->fetchAll();
	
	?>
<div class="background_ladder">
	<main id='ladders' class='container'>
		<div id = "changeLadder">
		<button id="btnUsers" class="btn" onclick="change(1);" style="display: none">Voir le ladder des utilisateurs</button>
		<button id="btnServers" class="btn" onclick="change(0);">Voir le ladder des serveurs</button>
		</div>
		<div id="divServers" style="display: none">
		<h1 class="text-center titleEffect">Ladder Serveurs</h1>
		<table id="ladderServers" class="display">
		<thead>
	        <tr>
	            <th>Nom du serveur</th>
	            <th>Nombre d'inscrits</th>
				<th>Nombre de confirmations total</th>
	        </tr>
	    </thead>
	    <tbody>
		<?php
		foreach($servers as $server):
		?>
	        <tr>
	            <td><a href="/portails/<?= $server["id"] ?>"><?= $server["name"] ?></a></td>
	            <td><?= $server["INSCRITS"] ?></td>
				<td><?= $server["CONFIRMS"] ?></td>
	        </tr>
		<?php
		endforeach;
		?>
	    </tbody>
		</table>
		</div>
		
		<div id="divUsers">
		<h1 class="text-center titleEffect">Ladder Utilisateurs</h1>
		<table id="ladderUsers" class="display">
		<thead>
	        <tr>
	            <th>Pseudo</th>
	            <th>Confirmations Totales</th>
				<th>Rang</th>
				<th>Serveur</th>
	        </tr>
	    </thead>
	    <tbody>
		<?php
		foreach($users as $user):
		
		$sql = "SELECT *
				FROM grades
				WHERE `id` = " . $user["grade"];

		$req = $dbh->prepare($sql);
		$req->execute();
		$grade = $req->fetch();
		
		$sql = "SELECT *
				FROM servers
				WHERE `id` = " . $user["server"];

		$req = $dbh->prepare($sql);
		$req->execute();
		$serveur = $req->fetch();
		
		?>
	        <tr>
	            <td><a href="/profil/<?= $user["id"] ?>"><?= $user["username"] ?></a></td>
	            <td><?= $user["votes_number"] ?></td>
				<td><?php if($user["id"] == 99) { echo "&laquo; Dictatrice &raquo;";}else { echo "&laquo;" . $grade["name"] . " &raquo;"; }?></td>
				<td><a href="/portails/<?= $user["server"] ?>"><?= $serveur["name"] ?></a></td>
	        </tr>
		<?php
		endforeach;
		?>
	    </tbody>
		</table>
		</div>
	</main>
</div>
		<?php include("footer.php"); ?>
		<script type="text/javascript">
		$(document).ready(function(){
		    $('#ladderServers').DataTable( {
				"columnDefs": [
		        {"className": "dt-center", "targets": "_all"}
		      ],
				"order": [[ 1, "desc" ]],
		        "language": {
		            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
		        }
		    } );

			$('#ladderUsers').DataTable( {
				"columnDefs": [
		        {"className": "dt-center", "targets": "_all"}
		      ],
				"order": [[ 1, "desc" ]],
		        "language": {
		            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
		        }
		    } );
			
		    $('main#ladders').animate({
		    	opacity:1
		    }, 300);
		});
		</script>
		<script language="javascript">

			function change(users) {
				if(users)
				{
					$('#divUsers').removeAttr( 'style' );
					$('#btnServers').removeAttr( 'style' );
					$('#divServers').css('display', 'none');
					$('#btnUsers').css('display', 'none');
				}
				else
				{
					$('#divServers').removeAttr( 'style' );
					$('#btnUsers').removeAttr( 'style' );
					$('#divUsers').css('display', 'none');
					$('#btnServers').css('display', 'none');
				}
			}

</script>
		