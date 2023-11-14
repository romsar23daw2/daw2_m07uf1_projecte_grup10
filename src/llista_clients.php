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

	<form action="llista_clients.php" method="POST">
		<p>
			<?php
			// If logged in with the admin, show all managers, in this case, as I need to use a function inside the php code, I echo the table in individual parts.

			if ($_SESSION['tipus_usuari'] == 2) {
				echo '<div>';
				echo '<h3><b>Llista de clients:</b></h3>';
				echo '<table>';
				echo '<thead>';
				echo '<tr>';
				echo '<th>Identificador</th>';
				echo '<th>Nom de usuari</th>';
				echo '<th>Nom complet</th>';
				echo '<th>Correu electrònic</th>';
				echo '<th>Telèfon de contacte</th>';
				echo '<th>Adreça postal</th>';
				echo '<th>Número targeta visa</th>';
				echo '<th>Gestor assignat</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';

				require("biblioteca.php");
				$llista = fLlegeixFitxer(FITXER_USUARIS);
				fCreaTaulaClients($llista);

				echo '</tbody>';
				echo '</table>';
				echo '</div>';
			}
			// It I'm not the admin means that I'm a manager.
			else {
				echo '<div>';
				echo '<h3><b>Llista de clients:</b></h3>';
				echo '<table>';
				echo '<thead>';
				echo '<tr>';
				echo '<th>Identificador</th>';
				echo '<th>Nom de usuari</th>';
				echo '<th>Nom complet</th>';
				echo '<th>Correu electrònic</th>';
				echo '<th>Telèfon de contacte</th>';
				echo '<th>Adreça postal</th>';
				echo '<th>Número targeta visa</th>';
				echo '<th>Gestor assignat</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';

				require("biblioteca.php");
				$llista = fLlegeixFitxer(FITXER_USUARIS);

				// Here I create a table showing the clients that a manager has, not using the ID but the username of the manager.
				fCreaTaulaClientsPerGestor($_SESSION['usuari'], $llista);

				echo '</tbody>';
				echo '</table>';
				echo '</div>';
			}
			?>
		</p>
	</form>

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