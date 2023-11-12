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
	<h3><b>Llista de clients:</b></h3>
	<table>
		<thead>
			<tr>
				<th>Identificador</th>
				<th>Nom d'usuari</th>
				<th>Contrasenya</th>
				<th>Nom complet</th>
				<th>Correu electrònic</th>
				<th>Telèfon de contacte</th>
				<th>Adreça postal</th>
				<th>Número targeta visa</th>
				<th>Gestor assignat</th>
			</tr>
		</thead>

		<tbody>
			<?php
			require("biblioteca.php");
			$llista = fLlegeixFitxer(FITXER_USUARIS);
			fCreaTaulaClients($llista);
			?>
		</tbody>

	</table>
	<p><a href="menu.php">Torna al menú</a></p>

	<label class="diahora">
		<?php
		echo "<p>Usuari utilitzant l'agenda: " . $_SESSION['usuari'] . "</p>";
		date_default_timezone_set('Europe/Andorra');
		echo "<p>Data i hora: " . date('d/m/Y h:i:s') . "</p>";
		?>
		<label class="diahora">
</body>

</html>