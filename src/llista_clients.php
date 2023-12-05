<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php'; // Asegúrate de que el autoloader de Composer está incluido
use Dompdf\Dompdf;

if (!isset($_SESSION['usuari'])) {
	header("Location: ./Errors/error_acces.php");
	exit;
} elseif (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)) {
	header("Location: ./logout_expira_sessio.php");
	exit;
}

if (isset($_GET['generar_pdf']) && $_SESSION['tipus_usuari'] == 2) {
	ob_start();
?>
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
				require("./funcions.php");
				$llista = fLlegeixFitxer(FITXER_CLIENTS);
				fCreaTaulaClients($llista);
				?>
			</tbody>
		</table>
	</div>
<?php
	// Here I create a PDF of the current page. 
	$html = ob_get_clean();

	$dompdf = new Dompdf();
	$dompdf->loadHtml($html);
	$dompdf->setPaper('A4', 'portrait');
	$dompdf->render();
	$dompdf->stream("llista_clients.pdf");
	exit;
}
?>

<!DOCTYPE html>
<html lang="ca">

<head>
	<meta charset="utf-8">
	<title>Dades de clients - Rellotgeria</title>
	<link rel="stylesheet" href="./Assets/Stylesheets/agenda.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>

	<?php if ($_SESSION['tipus_usuari'] == 2) : ?>
		<div class="container mt-4">
			<h3 class="mb-4"><b>Llista de clients:</b></h3>
			<table class="table table-bordered">
				<thead class="thead-dark">
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
					require("./funcions.php");
					$llista = fLlegeixFitxer(FITXER_CLIENTS);
					fCreaTaulaClients($llista);
					?>
				</tbody>
			</table>
		</div>

		<div class="container text-center mt-4">
			<h3><b>Generar PDF de la llista de clients:</b></h3><br>
			<form method="get">
				<input type="submit" class="btn btn-primary" name="generar_pdf" value="Generar PDF">
			</form>
		</div>
	<?php elseif ($_SESSION['tipus_usuari'] == 1) : ?>
		<div class="container mt-4">
			<h3 class="mb-4"><b>Llista de clients:</b></h3>
			<table class="table table-bordered">
				<thead class="thead-dark">
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
					require("./funcions.php");
					$llista = fLlegeixFitxer(FITXER_CLIENTS);
					fCreaTaulaClientsPerGestor($_SESSION['usuari'], $llista);
					?>
				</tbody>
			</table>
		</div>
	<?php elseif ($_SESSION['tipus_usuari'] == 0) : ?>
		<div class="container mt-4">
			<h3 class="mb-4"><b>Dades personals:</b></h3>
			<table class="table table-bordered">
				<thead class="thead-dark">
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
					require("./funcions.php");
					$llista = fLlegeixFitxer(FITXER_CLIENTS);
					fVeureDadesPersonalsClient($_SESSION['usuari'], $llista);
					?>
				</tbody>
			</table>
		</div>
	<?php else : ?>
		<?php header("Location: ./Errors/error_autoritzacio.php"); ?>
	<?php endif; ?><br>

	<p class="text-center mt-4"><a href="menu.php" class="btn btn-secondary">Torna al menú</a></p><br<br><br>

		<div class="mt-3 d-flex justify-content-center">
            <p class="text-muted">
                Usuari utilitzant l'agenda: <?php echo $_SESSION['usuari']; ?>
                <br>
                Data i hora: <?php date_default_timezone_set('Europe/Andorra');
                                echo date('d/m/Y h:i:s'); ?>
            </p>
        </div>



	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>
