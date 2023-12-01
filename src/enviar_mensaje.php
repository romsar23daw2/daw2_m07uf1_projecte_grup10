<?php
session_start();

// Función para obtener el gestor asociado al cliente
function obtenerGestorAsignado($idCliente) {
    // Implementa la lógica para obtener el gestor asociado al cliente
    // Puedes usar la información proporcionada en la lista de usuarios
    // Devuelve el nombre de usuario del gestor o null si no se encuentra
    // Ejemplo de implementación:
    $usuarios = obtenerListaUsuarios(); // Implementa la función obtenerListaUsuarios()
    
    foreach ($usuarios as $usuario) {
        $detalles = explode(':', $usuario);
        if ($detalles[0] === $idCliente) {
            return $detalles[10]; // Índice 10 corresponde al nombre de usuario del gestor asociado
        }
    }
    
    return null; // Si no se encuentra el gestor asociado
}

// Función para obtener la lista de usuarios desde los archivos .txt
function obtenerListaUsuarios() {
    $rutaArchivoClientes = "clientes.txt";
    $rutaArchivoGestores = "gestores.txt";

    // Lee el contenido de los archivos
    $contenidoClientes = file_get_contents($rutaArchivoClientes);
    $contenidoGestores = file_get_contents($rutaArchivoGestores);

    // Combina el contenido de ambos archivos
    $contenidoTotal = $contenidoClientes . "\n" . $contenidoGestores;

    // Convierte el contenido a un array de líneas
    $lineas = explode("\n", $contenidoTotal);

    // Elimina líneas vacías
    $lineas = array_filter(array_map('trim', $lineas));

    return $lineas;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mensaje"])) {
    // Obtén el ID del cliente de la sesión
    $idCliente = $_SESSION['id_cliente']; // Asegúrate de tener la variable de sesión correcta para el ID del cliente

    // Obtén el gestor asociado al cliente
    $gestorAsociado = obtenerGestorAsignado($idCliente);

    if ($gestorAsociado) {
        // Guardar el mensaje en un archivo .txt específico para el gestor
        $rutaArchivo = "mensajes_gestor/" . $gestorAsociado . ".txt";
        $contenidoMensaje = "Mensaje de " . $_SESSION['usuari'] . ":\n" . $_POST["mensaje"] . "\nFecha: " . date("Y-m-d H:i:s") . "\n\n";

        // Escribir el mensaje en el archivo
        file_put_contents($rutaArchivo, $contenidoMensaje, FILE_APPEND);

        // Redirigir a la página principal o mostrar un mensaje de éxito
        header("Location: menu.php?mensaje_enviado=true");
        exit();
    } else {
        // Manejar la situación en la que el cliente no tiene un gestor asociado
        echo "Error: No se encontró un gestor asociado.";
    }
}
?>


<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="utf-8">
    <title>Enviar Mensaje al Gestor - Rellotgeria</title>
    <link rel="stylesheet" href="./Assets/Stylesheets/agenda.css">
</head>

<body>
    <h3><b>Enviar Mensaje al Gestor</b></h3>
    <form action="enviar_mensaje.php" method="POST">
        <label for="mensaje">Mensaje:</label>
        <textarea name="mensaje" id="mensaje" rows="4" cols="50"></textarea><br><br>
        <input type="submit" value="Enviar Mensaje">
    </form>

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
