<?php
session_start();

if (!isset($_SESSION['usuari'])) {
	header("Location: ./Errors/error_acces.php");
}

if (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)) {
	header("Location: ./logout_expira_sessio.php");
}
?>

<!DOCTYPE html>
<html lang="ca">

<head>
	<meta charset="utf-8">
	<title>Visualitzador de l'agenda</title>
	<link rel="stylesheet" href="./Assets/Stylesheets/agenda.css">
</head>

<body>
	<?php

	if ($_SESSION['usuari'] == "admin") {
		echo '<p>Usuari Administrador.</p>';
		echo '<div>
						<h3><b>Menú del visualitzador:</b></h3>
						<p>
							<a href="registre_gestor.php">Registrar nou gestor.</a><br>
							<a href="registre_client.php">Registrar nou client.</a>
						</p>

						<a href="personal.php">Llista de gestors.</a><br>
						<a href="serveis.php">Modificar o esborrar dades de un gestor.</a><br>
						<a href="professional.php">Llista de clients.</a><br>
						<a href="serveis.php">Modificar o esborrar dades de un client.</a><br>

						<p><a href="serveis.php">Modificació de dades de accés.</a></p>

						<p><a href="logout.php">Finalitza la sessió.</a></p>
					</div>';
	} else if ($_SESSION['usuari'] == "gestor0") {
		echo "<p>Gestor de l'aplicació.</p>";
		echo '<div>
						<h3><b>Menú del visualitzador:</b></h3>
						<a href="personal.php">Llista de clients.</a><br>
						<a href="professional.php">Eviar correu al administrador per esborrar client.</a><br>

						<p><a href="serveis.php">Gestió de productes.</a></p>

						<p><a href="logout.php">Finalitza la sessió.</a></p>
					</div>';
	} else if ($_SESSION['usuari'] == "client0") {
		echo "<p>Usuari de l'aplicació.</p>";
		echo '<div>
						<h3><b>Menú del visualitzador:</b></h3>
						<p><a href="personal.php">Visualitzar dades personals.</a><br></p>

						<a href="professional.php">Eviar correu al gestor per modificacio/esborrament del compte de client.</a><br>
						<a href="professional.php">Eviar correu al gestor per petició de justificació de comanda rebutjada.</a><br>

						<p>
							<a href="serveis.php">Gestionar cistella.</a><br>
							<a href="serveis.php">Gestionar comanda.</a><br>
						</p>

						<p><a href="logout.php">Finalitza la sessió.</a></p>
					</div>';
	}
	?>

	<label class="diahora">
		<?php
		echo "<p>Usuari utilitzant l'agenda: " . $_SESSION['usuari'] . "</p>";
		date_default_timezone_set('Europe/Andorra');
		echo "<p>Data i hora: " . date('d/m/Y h:i:s') . "</p>";
		?>
	</label>
</body>

</html>