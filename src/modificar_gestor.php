<?php
require("./biblioteca.php");
session_start();

if (!isset($_SESSION['usuari'])) {
	header("Location: ./Errors/error_acces.php");
} else {
	$autoritzat_admin = fAutoritzacio($_SESSION['usuari']);

	if (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)) {
		header("Location: ./logout_expira_sessio.php");
	} else if (!$autoritzat_admin) {
		header("Location: ./Errors/error_autoritzacio.php");
	}
}

// Check if I entered an id before calling fModificarGestor().
if (isset($_POST['id_gestor_trobat'])) {
	// Session that I use to store the id of the manager that was found. I need this in order to be able to modify the id of the manager.
	$_SESSION['id_gestor_trobat'] = $_POST['id_gestor_trobat'];
	$gestor_trobat = fLocalitzarGestor($_POST['id_gestor_trobat']);
}

// Parameters of the manager.
$parametres_complets =  (isset($_POST['id_gestor'])) && (isset($_POST['nom_usuari'])) && (isset($_POST['cts_nou_gestor'])) && (isset($_POST['nom_complet_nou_gestor'])) && (isset($_POST['correu_nou_gestor'])) && (isset($_POST['telefon_nou_gestor'])) && (isset($_POST['tipus_usuari']));

if ($parametres_complets) {
	// Here i access $_SESSION['id_gestor_trobat'] in order to be able to compare the id from the manager, without needing to enter it again, and because of this, I'm able to change the ID of the manager.
	$modificat = fModificarGestor($_SESSION['id_gestor_trobat'], $_POST['id_gestor'], $_POST['nom_usuari'], $_POST['cts_nou_gestor'], $_POST['nom_complet_nou_gestor'], $_POST['correu_nou_gestor'], $_POST['telefon_nou_gestor'], $_POST['tipus_usuari']);
	$_SESSION['modificat'] = $modificat;

	header("refresh: 5; url=menu.php"); // Passats 5 segons el navegador demana menu.php i es torna a menu.php.
}
?>

<!DOCTYPE html>
<html lang="ca">

<head>
	<meta charset="utf-8">
	<title>Modificar gestor - Rellotgeria</title>
	<link rel="stylesheet" href="./Assets/Stylesheets/agenda.css">
</head>

<body>
	<h3><b>Modificació d'un gestor:</b></h3>

	<form action="modificar_gestor.php" method="POST">
		<p>
			<?php
			// In order to just show this part of the form when I don't have a valid manager.
			if (!$gestor_trobat) {
			?>
		<div>

			<label>ID del gestor a cercar:</label>
			<input type="number" name="id_gestor_trobat" min=1 max=100 required><br>
			<br>
			<button type="submit">Cercar gestor.</button>
		</div>
	<?php
			} elseif ($gestor_trobat) {
	?>
		<div>
			<label>Nou ID del gestor:</label>
			<input type="number" name="id_gestor" min=1 max=100 required><br>

			<label>Nou nom de usuari:</label>
			<input type="text" name="nom_usuari" required><br>

			<label>Nova contrasenya del gestor:</label>
			<input type="password" name="cts_nou_gestor" pattern="(?=^.{8,}$)(?=.*\d)(?=.*[!@#$%^&*]+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Mínims: 8 caràcters, una majúscula, una minúscula, un número i un caràcter especial" required><br>

			<label>Nou nom complet del gestor:</label>
			<input type="text" name="nom_complet_nou_gestor" required><br>

			<label>Nou correu del gestor:</label>
			<input type="text" name="correu_nou_gestor" required><br>

			<label>Nou telèfon de contacte del gestor:</label>
			<input type="number" name="telefon_nou_gestor" required><br>

			<!-- php GESTOR; is to add the type of user at the end.  -->
			<button type="submit" name="tipus_usuari" value=<?php echo GESTOR ?>>Modificar el gestor.</button>
		</div>
	</form>
<?php
			}
?>
</p>
</form>

<p><a href="menu.php">Torna al menú.</a></p>

<label class="diahora">
	<?php
	echo "<p>Usuari utilitzant l'agenda: " . $_SESSION['usuari'] . "</p>";

	date_default_timezone_set('Europe/Andorra');
	echo "<p>Data i hora: " . date('d/m/Y h:i:s') . "</p>";

	if (isset($_SESSION['modificat'])) {
		if ($_SESSION['modificat']) echo "<p style='color:red'>El gestor ha estat modificat correctament</p>";
		else {
			echo "L'Usuari no ha estat registrat<br>";
			echo "Comprova si hi ha algún problema del sistema per poder enregistrar nous usuaris<br>";
		}

		unset($_SESSION['modificat']);
	}
	?>
</label>
</body>

</html>