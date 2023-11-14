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

$parametres_complets = (isset($_POST['id_nou_client'])) && (isset($_POST['nom_usuari'])) && (isset($_POST['cts_nou_client'])) && (isset($_POST['nom_complet_nou_client'])) && (isset($_POST['correu_nou_client'])) && (isset($_POST['telefon_nou_client'])) && (isset($_POST['adreca_nou_client'])) && (isset($_POST['num_visa_nou_client'])) && (isset($_POST['id_gestor_nou_client'])) && (isset($_POST['tipus_usuari']));

if ($parametres_complets) {
	$afegit = fRegistrarClient($_POST['id_nou_client'], $_POST['nom_usuari'], $_POST['cts_nou_client'], $_POST['nom_complet_nou_client'], $_POST['correu_nou_client'], $_POST['telefon_nou_client'], $_POST['adreca_nou_client'], $_POST['num_visa_nou_client'], $_POST['id_gestor_nou_client'], $_POST['tipus_usuari']);
	$_SESSION['afegit'] = $afegit;

	header("refresh: 5; url=menu.php"); // Passats 5 segons el navegador demana menu.php i es torna a menu.php.
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
	<h3><b>Registre d'un nou client:</b></h3>

	<form action="registre_client.php" method="POST">
		<p>
			<label>ID del nou client:</label>
			<input type="number" name="id_nou_client" min=0 max=1000 required><br>

			<label>Nom d'usuari:</label>
			<input type="text" name="nom_usuari" required><br>

			<label>Contrasenya del nou client:</label>
			<input type="password" name="cts_nou_client" pattern="(?=^.{8,}$)(?=.*\d)(?=.*[!@#$%^&*]+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Mínims: 8 caràcters, una majúscula, una minúscula, un número i un caràter especial" required><br>

			<label>Nom complet del nou client:</label>
			<input type="text" name="nom_complet_nou_client" required><br>

			<label>Correu del nou client:</label>
			<input type="text" name="correu_nou_client" required><br>

			<label>Telèfon de contacte del nou client:</label>
			<input type="number" name="telefon_nou_client" required><br>

			<label>Adreça postal del nou client:</label>
			<input type="number" name="adreca_nou_client" required><br>

			<label>Número de visa del nou client:</label>
			<input type="number" name="num_visa_nou_client" required><br>

			<label>ID del gestor assignat pel nou client:</label>
			<input type="number" name="id_gestor_nou_client" min=0 max=100 required><br>
		</p>

		<button type="submit" name="tipus_usuari" value=<?php echo USR ?>>Crear nou client.</button> <!-- value=<?php echo GESTOR ?> is to be able the type of user.-->
	</form>

	<p><a href="menu.php">Torna al menú.</a></p>

	<label class="diahora">
		<?php
		echo "<p>Usuari utilitzant l'agenda: " . $_SESSION['usuari'] . "</p>";
		date_default_timezone_set('Europe/Andorra');
		echo "<p>Data i hora: " . date('d/m/Y h:i:s') . "</p>";

		if (isset($_SESSION['afegit'])) {
			if ($_SESSION['afegit']) echo "<p style='color:red'>El client ha estat registrat correctament</p>";
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