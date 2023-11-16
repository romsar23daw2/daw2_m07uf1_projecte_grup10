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
	<title>Dades de clients - Rellotgeria</title>
	<link rel="stylesheet" href="./Assets/Stylesheets/agenda.css">
</head>

<body>

	<?php if ($_SESSION['tipus_usuari'] == 2) : ?>
		<!-- If logged in with the admin, show all managers. In this case, as I need to use a function inside the PHP code, I echo the table in individual parts. -->
		<div>
			<h3><b>Llista de clients:</b></h3>
			<table>
				<thead>
					<tr>
						<th>Identificador</th>
						<th>Nom de usuari</th>
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
					$llista = fLlegeixFitxer(FITXER_CLIENTS);
					fCreaTaulaClients($llista);
					?>
				</tbody>
			</table>
		</div>

		<div>
			<h3><b>Generar PDF de la llista de clients:</b></h3>
			<button>Generar PDF</button>
		</div>
	<?php elseif ($_SESSION['tipus_usuari'] == 1) : ?>
		<!-- If logged in with the manager, create a table showing the clients that a manager has, not using the ID but the username of the manager. -->
		<div>
			<h3><b>Llista de clients:</b></h3>
			<table>
				<thead>
					<tr>
						<th>Identificador</th>
						<th>Nom de usuari</th>
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
					$llista = fLlegeixFitxer(FITXER_CLIENTS);
					fCreaTaulaClientsPerGestor($_SESSION['usuari'], $llista);
					?>
				</tbody>
			</table>
		</div>
	<?php elseif ($_SESSION['tipus_usuari'] == 0) : ?>
		<!-- If logged in with the client, show the personal data from the client. -->
		<div>
			<h3><b>Dades personals:</b></h3>
			<table>
				<thead>
					<tr>
						<th>Identificador</th>
						<th>Nom de usuari</th>
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
					$llista = fLlegeixFitxer(FITXER_CLIENTS);
					fVeureDadesPersonalsClient($_SESSION['usuari'], $llista);
					?>
				</tbody>
			</table>
		</div>
	<?php else : ?>
		<!-- If it's someone else, it shouldn't be here, so redirect to "error_autoritzacio". -->
		<?php header("Location: ./Errors/error_autoritzacio.php"); ?>
	<?php endif; ?>

	<p><a href="menu.php">Torna al menú</a></p>

	<label class="diahora">
		<?php
		echo "<p>Usuari utilitzant l'agenda: " . $_SESSION['usuari'] . "</p>";
		date_default_timezone_set('Europe/Andorra');
		echo "<p>Data i hora: " . date('d/m/Y h:i:s') . "</p>";
		?>
	</label>

</body>

</html>