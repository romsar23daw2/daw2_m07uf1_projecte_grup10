<?php
session_start();

if (!isset($_SESSION['usuari'])) {
	header("Location: ./Errors/error_acces.php");
} elseif (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)) {
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
	if ($_SESSION['tipus_usuari'] == 2) {
		echo '<div>';
		echo '<h3><b>Llista de gestors:</b></h3>';
		echo '<table>';
		echo '<thead>';
		echo '<tr>';
		echo '<th>Identificador</th>';
		echo '<th>Nom de usuari</th>';
		echo '<th>Nom complet</th>';
		echo '<th>Correu electrònic</th>';
		echo '<th>Telèfon de contacte</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';

		require("biblioteca.php");
		$llista = fLlegeixFitxer(FITXER_GESTORS);
		fCreaTaulaGestors($llista);

		echo '</tbody>';
		echo '</table>';
		echo '</div>';
	} else {
		// Only an admin can access here.
		header("Location: ./Errors/error_autoritzacio.php");
	}
	?>

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