<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

session_start(); 


if (isset($_POST["send"])) {
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

            $mail->setFrom('a48465927@gmail.com'); 

            // Define un array asociativo de usuarios y sus correos electrónicos correspondientes
            $usuariosCorreos = [
                'client00' => 'a48465927@gmail.com',
                'client01' => 'atm192000@gmail.com',
            ];

            if (isset($usuariosCorreos[$_SESSION['usuari']])) {
                $correoDestino = $usuariosCorreos[$_SESSION['usuari']];
                $mail->addAddress($correoDestino);
            } else {
                throw new Exception("No pots enviar un missatge a aquest usuari");
            }

            $mail->isHTML(true);

            $mail->Subject = $_POST["subject"];
            $mail->Body = $_POST["message"];

            $mail->send();

            echo "<script>alert('Missatge enviat');</script>";
            echo "<script>document.location.href = 'index.php';</script>";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}<br>";
            echo "Exception: {$e->getMessage()}";
        }
    } else {
        echo "Acces denegat";
    }
}
?>
