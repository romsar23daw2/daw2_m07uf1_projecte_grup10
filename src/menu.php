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
	<title>Menú - Rellotgeria</title>
	<link rel="stylesheet" href="./Assets/Stylesheets/agenda.css">
</head>

<body>
	<!-- If I'm the admin. -->
	<?php if ($_SESSION['tipus_usuari'] == 2) { ?>
		<div>
			<h3><b>Menú del visualitzador:</b></h3>
			<p>
				<a href="./registre_gestor.php">Registrar nou gestor.</a><br>
				<a href="./registre_client.php">Registrar nou client.</a>
			</p>

			<p>
				<a href="./llista_gestors.php">Llista de gestors.</a><br>
				<a href="./modificar_gestor.php">Modificar dades d'un gestor.</a><br>
				<a href="./llista_clients.php">Llista de clients.</a><br>
				<a href="./modificar_client.php">Modificar dades d'un client.</a><br>
			</p>

			<p><a href="./modificar_administrador.php">Modificació de dades de l'administrador.</a></p>

			<p><a href="./logout.php">Finalitza la sessió.</a></p>
		</div>

		<!-- If I'm a manager. -->
	<?php } elseif ($_SESSION['tipus_usuari'] ==  1) { ?>
		<div>
			<h3><b>Menú del visualitzador:</b></h3>
			<p>
				<a href="./llista_clients.php">Llista de clients.</a><br>
				<a href="./professional.php">Eviar correu al administrador per esborrar client.</a><br>
			</p>

			<p><a href="./cistella_gestio_productes.php">Gestió de productes.</a></p>

			<p><a href="./logout.php">Finalitza la sessió.</a></p>
		</div>

		<!-- If I'm a client. -->
	<?php } elseif ($_SESSION['tipus_usuari'] == 0) { ?>
		<div>
			<h3><b>Menú del visualitzador:</b></h3>
			<p><a href="./llista_clients.php">Visualitzar dades personals.</a><br></p>

			<p>
				<a href="./enviar_mensaje.php">Eviar correu al gestor per modificacio/esborrament del compte de client.</a><br>
				<a href="./enviar_mensaje.php">Eviar correu al gestor per petició de justificació de comanda rebutjada.</a><br>
			</p>

			<p>
				<a href="./cistella_gestio_productes.php">Gestionar cistella.</a><br>
				<a href="./serveis.php">Gestionar comanda.</a><br>
			</p>

			<p><a href="./logout.php">Finalitza la sessió.</a></p>
		</div>
	<?php } ?>

	<label class="diahora">
		<?php
		echo "<p>Usuari utilitzant l'agenda: " . $_SESSION['usuari'] . "</p>";
		date_default_timezone_set('Europe/Andorra');
		echo "<p>Data i hora: " . date('d/m/Y h:i:s') . "</p>";
		?>
	</label>
</body>

</html>