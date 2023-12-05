<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

session_start(); // Inicia la sesión, asegúrate de llamar a esto al principio del script


if (isset($_POST["send"])) {
    // Verifica si el usuario está autenticado
    if (isset($_SESSION['tipus_usuari']) && $_SESSION['tipus_usuari'] === 0) {

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'a48465927@gmail.com'; 
            $mail->Password = 'ghiikpskvgwsgpyt'; 
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('tu_correo@gmail.com'); 

            // Define un array asociativo de usuarios y sus correos electrónicos correspondientes
            $usuariosCorreos = [
                'client00' => 'a48465927@gmail.com',
                'client01' => 'atm192000@gmail.com',
                // Agrega más usuarios y correos electrónicos según sea necesario
            ];

            // Verifica si el usuario actual tiene un correo asociado
            if (isset($usuariosCorreos[$_SESSION['usuari']])) {
                $correoDestino = $usuariosCorreos[$_SESSION['usuari']];
                $mail->addAddress($correoDestino);
            } else {
                throw new Exception("No puedes enviar un mensaje a este usuario");
            }

            $mail->isHTML(true);

            $mail->Subject = $_POST["subject"];
            $mail->Body = $_POST["message"];

            $mail->send();

            echo "<script>alert('Sent Successfully');</script>";
            echo "<script>document.location.href = 'index.php';</script>";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}<br>";
            echo "Exception: {$e->getMessage()}";
        }
    } else {
        // El usuario no está autorizado, redirige o muestra un mensaje de error
        echo "Unauthorized access";
    }
}
?>
