<?php session_start();

	if(isset($_SESSION["rigths"])&&$_SESSION["rigths"]==2)
	{
		ob_start();

		include('../header.php');

		$buffer = ob_get_contents();

		ob_end_clean();

		$buffer=str_replace("%TITLE%","SLT C NOU LAI ADMINE",$buffer);

		echo $buffer;?>

		<main id="admin">
			
			<div class="container">

				<div class="col-xs-28 col-xs-offset-1 col-sm-12 col-sm-offset-2 element">
					<h1>Gérer les utilisateurs</h1>
					<a href="/admin/users" class='btn'>Accéder</a>
				</div>

				<div class="col-xs-28 col-xs-offset-1 col-sm-12 col-sm-offset-2 element">
					<h1>Gérer les positions</h1>
					<a href="/admin/positions" class='btn'>Accéder</a>
				</div>

			</div>

		</main>


	<?php }
	else
	{
		header('Location:/login');
	}

?>