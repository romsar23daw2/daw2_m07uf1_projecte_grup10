<?php
session_start();

if ($_SESSION['tipus_usuari'] != 1) {
    header("Location: ./Errors/error_acces.php");
    exit();
}

// Obtén el nombre de usuario del gestor de la sesión
$nombreUsuarioGestor = $_SESSION['usuari'];

// Ruta del archivo que contiene los mensajes del gestor
$rutaArchivo = __DIR__ . "/mensajes_gestor/" . $nombreUsuarioGestor . ".txt";

// Verifica si el archivo existe antes de intentar leerlo
if (file_exists($rutaArchivo)) {
    // Lee el contenido del archivo de manera segura
    $mensajes = file_get_contents($rutaArchivo, FILE_USE_INCLUDE_PATH | FILE_TEXT);
    $mensajes = htmlspecialchars($mensajes); // Escapa contenido HTML
} else {
    $mensajes = "No hay mensajes disponibles.";
}
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="utf-8">
    <title>Ver Mensajes - Rellotgeria</title>
    <link rel="stylesheet" href="./Assets/Stylesheets/agenda.css">
</head>

<body>
    <h3><b>Mensajes Recibidos</b></h3>
    <div>
        <?php echo nl2br($mensajes); ?>
    </div>

    <p><a href="menu.php">Volver al menú</a></p>

    <label class="diahora">
        <?php
        echo "<p>Usuario utilizando la agenda: " . $_SESSION['usuari'] . "</p>";
        date_default_timezone_set('Europe/Andorra');
        echo "<p>Fecha y hora: " . date('d/m/Y h:i:s') . "</p>";
        ?>
    </label>
</body>

</html>
