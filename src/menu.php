<?php
session_start();

if (!isset($_SESSION['usuari'])) {
	header("Location: error_acces.php");
}

if (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)) {
	header("Location: logout_expira_sessio.php");
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
			<h3><b>Menú del visualitzador</b></h3>
			<a href="personal.php">Agenda personal</a><br>
			<a href="professional.php">Agenda professional</a><br>
			<a href="serveis.php">Agenda de serveis</a><br>
			<p><a href="registre.php">Registre de nous usuaris</a></p>
			<p><a href="logout.php">Finalitza la sessió</a></p>
		</div>';
	} else if ($_SESSION['usuari'] == "gestor0") {
		echo "<p>Gestor de l'aplicació.</p>";
		echo '<div>
			<h3><b>Menú del visualitzador</b></h3>
			<a href="personal.php">Llista de clients.</a><br>
			<a href="professional.php">Eviar correu per esborrar client.</a><br>
			<a href="serveis.php">Agenda de serveis</a><br>
			<p><a href="registre.php">Registre de nous usuaris</a></p>
			<p><a href="logout.php">Finalitza la sessió</a></p>
		</div>';
	} else if ($_SESSION['usuari'] == "usuari0") {
		echo "<p>Usuari de l'aplicació.</p>";
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