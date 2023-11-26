<?php
session_start();
require("./biblioteca.php");

$nomFitxer = DIRECTORI_CISTELLA . $_SESSION['usuari'];
$_SESSION['producte'] = fLlegeixFitxer($nomFitxer);

if (!isset($_SESSION['usuari'])) {
	header("Location: ./Errors/error_acces.php");
} elseif (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)) {
	header("Location: ./logout_expira_sessio.php");
}

if (isset($_POST['producte'])) {
	$_SESSION['producte'] = $_POST['producte'] . "\n";
	header("Location: ./desar_cistella.php");
}
?>

<!DOCTYPE html>
<html lang="ca">

<head>
	<meta charset="utf-8">
	<title>Selecció de producte - Rellotgeria</title>
	<link rel="stylesheet" href="./Assets/Stylesheets/agenda.css">
</head>

<body>
	<!-- If I'm a client. -->
	<?php if ($_SESSION['tipus_usuari'] == 0) : ?>
		<?php if ($_SESSION['producte']) {
			echo "<b><u>Productes actuals a la cistella: </u></b>" . "<br>";
			echo "<br>" . "<table>" . "<tr>";

			foreach ($_SESSION['producte'] as $indexProducte => $producte) {
				echo "<td>";
				echo $producte;
				echo "</td>";

				if ($indexProducte % 2 == 1) {
					echo "</tr>";
				}
			}
			echo "</table>" . "<br>";
		} else {
			echo "Cap producte a la cistella<br>";
		}
		?>

		<div>
			<h3><b>Productes que es venen la botiga:</b></h3>
			<table>
				<thead>
					<tr>
						<th>Nom producte</th>
						<th>ID producte</th>
						<th>Preu producte</th>
						<th>IVA producte</th>
						<th>Disponibilitat</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$llista = fLlegeixFitxer(FITXER_PRODUCTES);
					fGenerarLlistaProductes($llista);
					?>
				</tbody>
			</table>

			<br><b><u>LLISTA DE PRODUCTES:</u></b><br>
			<form action="./cistella_gestio_productes.php" method="POST">
				<input type="radio" name="producte" value="bombetes30W" /> Bombetes de 30 W<br />
				<input type="radio" name="producte" value="bombetes60W" /> Bombetes de 60 W<br />
				<input type="radio" name="producte" value="bombetes100W" /> Bombetes de 100 W<br /><br>
				<input value="Selecciona" type="submit"><br><br>
			</form>
		</div>

	<?php elseif ($_SESSION['tipus_usuari'] == 1) : ?>
		<div>
			<h3><b>Llista de productes actuals:</b></h3>
			<table>
				<thead>
					<tr>
						<th>Nom producte</th>
						<th>ID producte</th>
						<th>Preu producte</th>
						<th>IVA producte</th>
						<th>Disponibilitat</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$llista = fLlegeixFitxer(FITXER_PRODUCTES);
					fGenerarLlistaProductes($llista);
					?>
				</tbody>
			</table>
		</div>

		<div>
			<h3>Gestió de productes</h3>
			<form action="./modificar_producte.php" method="POST">
				<input type="submit" name="modificar_productes" value="Modificar producte">
			</form>

			<!-- To finish. -->
			<form action="./afegir_producte.php" method="POST">
				<input type="submit" name="afegir_producte" value="Afegir producte">
			</form>

			<h3><b>Generar PDF de la llista dels productes:</b></h3>
			<form method="post">
				<input type="submit" name="generar_pdf" value="Generar PDF">
			</form>
		</div>
	<?php else :
		// No one else can acess to this.
		header("Location: ./Errors/error_acces.php");
	?>
	<?php endif; ?>

	<label class="diahora">
		<p><a href="./menu.php">Torna al menú</a></p>

		<?php
		echo "<p>Usuari utilitzant l'agenda: " . $_SESSION['usuari'] . "</p>";
		date_default_timezone_set('Europe/Andorra');
		echo "<p>Data i hora: " . date('d/m/Y h:i:s') . "</p>";
		?>
</body>

</html>