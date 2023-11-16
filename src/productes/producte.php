<?php
session_start();
if (!isset($_SESSION['usuari'])) {
	header("Location: ../error_acces.php");
}
?>
<!DOCTYPE html>
<html lang="ca">

<head>
	<meta charset="utf-8">
	<title>Selecció de producte - Rellotgeria</title>
	<link rel="stylesheet" href="../Assets/Stylesheets/agenda.css">
</head>

<body>
	<?php
	require("../biblioteca.php");
	$nomFitxer = DIRECTORI_CISTELLA . $_SESSION['usuari'];
	$_SESSION['producte'] = fLlegeixFitxer($nomFitxer);
	if ($_SESSION['producte']) {
		echo "<b><u>Productes actuals a la cistella: </u></b>" . "<br>";

		foreach ($_SESSION['producte'] as $producte) {
			echo $producte . "<br>";
		}

		echo "<br>";
	} else {
		echo "Cap producte a la cistella<br>";
	}
	if (isset($_POST['producte'])) {
		$_SESSION['producte'] = $_POST['producte'] . "\n";
		header("Location: ./desar_cistella.php");
	}
	?>

	<b><u>LLISTA DE PRODUCTES:</u></b><br>
	<form action="producte.php" method="POST">
		<input type="radio" name="producte" value="bombetes30W" /> Bombetes de 30 W<br />
		<input type="radio" name="producte" value="bombetes60W" /> Bombetes de 60 W<br />
		<input type="radio" name="producte" value="bombetes100W" /> Bombetes de 100 W<br /><br>
		<input value="Selecciona" type="submit"></td><br>
	</form>
</body>

<label class="diahora">
	<?php
	echo "<p>Usuari utilitzant l'agenda: " . $_SESSION['usuari'] . "</p>";
	date_default_timezone_set('Europe/Andorra');
	echo "<p>Data i hora: " . date('d/m/Y h:i:s') . "</p>";
	?>

</html>