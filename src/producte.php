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
	<title>Selecció de producte - Rellotgeria</title>
	<link rel="stylesheet" href="./Assets/Stylesheets/agenda.css">
</head>

<body>

	<!-- If I'm a client. -->
	<?php if ($_SESSION['tipus_usuari'] == 0) {
		require("./biblioteca.php");
		$nomFitxer = DIRECTORI_CISTELLA . $_SESSION['usuari'];
		$_SESSION['producte'] = fLlegeixFitxer($nomFitxer);

		if ($_SESSION['producte']) {
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
		if (isset($_POST['producte'])) {
			$_SESSION['producte'] = $_POST['producte'] . "\n";
			header("Location: ./desar_cistella.php");
		}
	} else {
		// No one can acess to this.
		header("Location: ./Errors/error_acces.php");
	}
	?>

	<b><u>LLISTA DE PRODUCTES:</u></b><br>
	<form action="producte.php" method="POST">
		<input type="radio" name="producte" value="bombetes30W" /> Bombetes de 30 W<br />
		<input type="radio" name="producte" value="bombetes60W" /> Bombetes de 60 W<br />
		<input type="radio" name="producte" value="bombetes100W" /> Bombetes de 100 W<br /><br>
		<input value="Selecciona" type="submit"></td><br><br>
	</form>
</body>


<label class="diahora">
	<p><a href="./menu.php">Torna al menú</a></p>

	<?php
	echo "<p>Usuari utilitzant l'agenda: " . $_SESSION['usuari'] . "</p>";
	date_default_timezone_set('Europe/Andorra');
	echo "<p>Data i hora: " . date('d/m/Y h:i:s') . "</p>";
	?>

</html>