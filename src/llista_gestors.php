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
	<title>Llista de gestors - Rellotgeria</title>
	<link rel="stylesheet" href="./Assets/Stylesheets/agenda.css">
</head>

<body>

	<?php if ($_SESSION['tipus_usuari'] == 2) : ?>
		<!-- If logged in with the admin, show the list of managers. In this case, as I need to use a function inside the PHP code, I echo the table in individual parts. -->
		<div>
			<h3><b>Llista de gestors:</b></h3>
			<table>
				<thead>
					<tr>
						<th>Identificador</th>
						<th>Nom de usuari</th>
						<th>Nom complet</th>
						<th>Correu electrònic</th>
						<th>Telèfon de contacte</th>
					</tr>
				</thead>
				<tbody>
					<?php
					require("biblioteca.php");
					$llista = fLlegeixFitxer(FITXER_GESTORS);
					fCreaTaulaGestors($llista);
					?>
				</tbody>
			</table>
		</div>

		<div>
			<h3><b>Generar PDF de la llista de gestors:</b></h3>
			<button>Generar PDF</button>
		</div>
	<?php else : ?>
		<!-- Only an admin can access here. -->
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