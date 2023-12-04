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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<<<<<<< HEAD
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
=======
<body class="bg-light">
    <div class="container mt-5">
        <?php if ($_SESSION['tipus_usuari'] == 2) { ?>
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Menú del administrador:</h3>
                    <ul class="list-group">
                        <li class="list-group-item"><a href="./registre_gestor.php">Registrar nou gestor</a></li>
                        <li class="list-group-item"><a href="./registre_client.php">Registrar nou client</a></li>
                        <li class="list-group-item"><a href="./llista_gestors.php">Llista de gestors</a></li>
                        <li class="list-group-item"><a href="./modificar_gestor.php">Modificar o esborrar dades de un gestor</a></li>
                        <li class="list-group-item"><a href="./llista_clients.php">Llista de clients</a></li>
                        <li class="list-group-item"><a href="./modificar_client.php">Modificar o esborrar dades de un client</a></li>
                        <li class="list-group-item"><a href="./modificar_dades_administrador.php">Modificació de dades del administrador</a></li>
                    </ul>
                    <a href="./logout.php" class="btn btn-danger mt-3">Finalitza la sessió</a>
                </div>
            </div>
        <?php } elseif ($_SESSION['tipus_usuari'] ==  1) { ?>
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Menú del gestor:</h3>
                    <ul class="list-group">
                        <li class="list-group-item"><a href="./llista_clients.php">Llista de clients</a></li>
                        <li class="list-group-item"><a href="./professional.php">Enviar correu al administrador per esborrar client</a></li>
                        <li class="list-group-item"><a href="./producte.php">Gestió de productes</a></li>
                    </ul>
                    <a href="./logout.php" class="btn btn-danger mt-3">Finalitza la sessió</a>
                </div>
            </div>
        <?php } elseif ($_SESSION['tipus_usuari'] == 0) { ?>
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Menú del client:</h3>
                    <ul class="list-group">
                        <li class="list-group-item"><a href="./llista_clients.php">Visualitzar dades personals</a></li>
                        <li class="list-group-item"><a href="./sendmail_Torrente">Enviar correu al gestor</a></li>
                        <li class="list-group-item"><a href="./producte.php">Gestionar cistella</a></li>
                        <li class="list-group-item"><a href="./serveis.php">Gestionar comanda</a></li>
                    </ul>
                    <a href="./logout.php" class="btn btn-danger mt-3">Finalitza la sessió</a>
                </div>
            </div>
        <?php } ?>

        <div class="mt-3">
            <p class="text-muted">
                Usuari utilitzant l'agenda: <?php echo $_SESSION['usuari']; ?>
                <br>
                Data i hora: <?php date_default_timezone_set('Europe/Andorra'); echo date('d/m/Y h:i:s'); ?>
            </p>
        </div>
    </div>
>>>>>>> origin/atm
</body>

</html>
