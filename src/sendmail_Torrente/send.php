<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Verifica la sesión del cliente antes de procesar el formulario
session_start();
if (!isset($_SESSION['nombre_de_usuario_cliente'])) {
    // Si no hay una sesión activa, redirige al cliente a la página de inicio de sesión o muestra un mensaje de error.
    header("Location: ../login.php");
    exit();
}

if (isset($_POST["send"])) {
    try {
        // Obtén el gestor asignado al cliente desde tu lógica de autenticación.
        $gestor_asignado = obtenerGestorAsignado($_SESSION['nombre_de_usuario_cliente']);

        if ($gestor_asignado !== null) {
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'a48465927@gmail.com';
            $mail->Password ='ghiikpskvgwsgpyt';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('a48465927@gmail.com');
            $mail->addAddress($gestor_asignado);

            $mail->isHTML(true);

            $mail->Subject = $_POST["subject"];
            $mail->Body = $_POST["message"];

            $mail->send();

            echo "
            <script>
            alert('Correo enviado exitosamente');
            window.location.href = 'index.php';
            </script>
            ";
        } else {
            throw new Exception("No se pudo obtener el gestor asignado al cliente.");
        }
    } catch (Exception $e) {
        echo "
        <script>
        alert('Error al enviar el correo: " . $mail->ErrorInfo . "');
        </script>
        ";
    }
}

// Función para obtener el gestor asignado al cliente
function obtenerGestorAsignado($nombre_de_usuario_cliente) {
    // Obtenemos el contenido del archivo "gestors"
    $gestorsContent = file_get_contents("gestors");

    // Dividimos el contenido en líneas
    $lineas = explode("\n", $gestorsContent);

    // Buscamos la línea correspondiente al cliente actual
    foreach ($lineas as $linea) {
        $datos = explode(":", $linea);
        if ($datos[3] == $nombre_de_usuario_cliente) {
            // Devolvemos el correo electrónico del gestor asignado
            return $datos[6];
        }
    }

    // Devolvemos null si no se encontró el gestor asignado
    return null;
}
?>
