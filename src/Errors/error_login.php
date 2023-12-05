<!DOCTYPE html>
<html lang="ca">

<head>
	<meta charset="utf-8">
	<title>Error d'inici sessió - Rellotgeria</title>
	<!-- Enlace a Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../Assets/Stylesheets/agenda.css">
	<style>
		body {
			background-color: #f8f9fa;
		}

		.error-container {
			max-width: 400px;
			margin: 50px auto;
			background-color: #fff;
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		}

		.diahora {
			margin-top: 20px;
			font-size: 14px;
			color: #6c757d;
		}
	</style>
</head>

<body>
	<div class="container error-container">
		<h2 class="mb-4"><b>Error d'inici de sessió</b></h2>
		<p>Per poder accedir a l'agenda has de tenir un compte d'usuari i una contrasenya d'accés.</p>
		<p>El nom d'usuari i/o la contrasenya suministrats no són vàlids.</p>
		<p><a href="../index.php" class="btn btn-primary">Torna a la pàgina inicial</a></p>
		<p><a href="../login.php" class="btn btn-secondary">Torna a la pàgina d'inici de sessió</a></p>
	</div>

	<div class="container diahora">
		<?php
		date_default_timezone_set('Europe/Andorra');
		echo "<p>Data i hora: " . date('d/m/Y h:i:s') . "</p>";
		?>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
