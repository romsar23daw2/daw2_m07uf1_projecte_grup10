<?php
require("biblioteca.php");
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

// Check if I enterd an id before calling fModificarGestor().
if (($_POST['id_nou_gestor'])) {
	$gestor_trobat = fLocalitzarUsuari(($_POST['id_nou_gestor']));
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
	<h3><b>Modificació d'un gestor:</b></h3>

	<form action="modificar_gestor.php" method="POST">
		<p>
			<?php
			// In order to just show this part of the form when I don't have a valid manager.
			if (!$gestor_trobat) {
				echo '<div>
							<label>ID del gestor a cercar:</label>
							<input type="number" name="id_nou_gestor" min=1 max=100 required><br>
							<button type="submit">Cercar gestor.</button>
						</div>';
			} elseif ($gestor_trobat) {
				echo '<div>
								<label>Nou nom de usuari:</label>
								<input type="text" name="nom_usuari" required><br>

								<label>Nova contrasenya del gestor:</label>
								<input type="password" name="cts_nou_gestor" pattern="(?=^.{8,}$)(?=.*\d)(?=.*[!@#$%^&*]+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Mínims: 8 caràcters, una majúscula, una minúscula, un número i un caràter especial" required><br>

								<label>Nou nom complet del gestor:</label>
								<input type="text" name="nom_complet_nou_gestor" required><br>

								<label>Nou correu del gestor:</label>
								<input type="text" name="correu_nou_gestor" required><br>

								<label>Nou telèfon de contacte del gestor:</label>
								<input type="number" name="telefon_nou_gestor" required><br>

								<button type="submit" name="tipus_usuari" value=<?php echo GESTOR ?>Modificar gestor.</button>	
							</div>';
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

		if (isset($_SESSION['afegit'])) {
			if ($_SESSION['afegit']) echo "<p style='color:red'>El gestor ha estat registrat correctament</p>";
			else {
				echo "L'Usuari no ha estat registrat<br>";
				echo "Comprova si hi ha algún problema del sistema per poder enregistrar nous usuaris<br>";
			}

			unset($_SESSION['afegit']);
		}
		?>
	</label>
</body>

</html>