<?php
require("../funcions.php");

session_start();

if (!isset($_SESSION['usuari'])) {
    header("Location: ../Errors/error_acces.php");
    exit;
} elseif (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)) {
    header("Location: ../logout_expira_sessio.php");
    exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

session_start(); // Inicia la sesión, asegúrate de llamar a esto al principio del script


if (isset($_POST["send"])) {
    // Verifica si el usuario está autenticado
    if (isset($_SESSION['tipus_usuari']) && $_SESSION['tipus_usuari'] === 0) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            // Here I set up the email of the client.
            $mail->Username = 'projectephpa@gmail.com';
            $mail->Password = 'kiexjyrzuhfyrfor';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            // Associative array that contains the mails of the managers, in this case, remains the same as the mail of the client as I could't use my phone number to create Google accouts anymore.
            $correus_usuaris = [
                'client00' => 'a90487918@gmail.com',
                'client01' => 'a90487918@gmail.com',
            ];

            // Verifica si el usuario actual tiene un correo asociado
            if (isset($correus_usuaris[$_SESSION['usuari']])) {
                $correu_desti = $correus_usuaris[$_SESSION['usuari']];
                $mail->addAddress($correu_desti);
            } else {
                throw new Exception("No pots enviar un missatge des d'aquest usuari.");
            }

            $mail->isHTML(true);

            $mail->Subject = $_POST["subject"];
            $mail->Body = $_POST["message"];

            $mail->send();

            echo "<script>alert('Enviat correctament');</script>";
            echo "<script>document.location.href = 'index.php';</script>";
        } catch (Exception $e) {
            echo "El missatge no ha pogut estar enviat, l'error és: {$mail->ErrorInfo}<br>";
            echo "Exception: {$e->getMessage()}";
        }
    } elseif (isset($_SESSION['tipus_usuari']) && $_SESSION['tipus_usuari'] === 1) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            // Here I set up the email of the manager.
            $mail->Username = 'a90487918@gmail.com';
            $mail->Password = 'kjtwkvqrkcdtbzoz';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            // Associative array that contains user emails, in this case, I'll always have the same.
            $correus_usuaris = [
                'gestor00' => '15586185.clot@fje.edu',
                'gestor00' => '15586185.clot@fje.edu',
            ];

            // Verifica si el usuario actual tiene un correo asociado
            if (isset($correus_usuaris[$_SESSION['usuari']])) {
                $correu_desti = $correus_usuaris[$_SESSION['usuari']];
                $mail->addAddress($correu_desti);
            } else {
                throw new Exception("No pots enviar un missatge des d'aquest usuari.");
            }

            $mail->isHTML(true);

            $mail->Subject = $_POST["subject"];
            $mail->Body = $_POST["message"];

            $mail->send();

            echo "<script>alert('Enviat correctament');</script>";
            echo "<script>document.location.href = 'index.php';</script>";
        } catch (Exception $e) {
            echo "El missatge no ha pogut estar enviat, l'error és: {$mail->ErrorInfo}<br>";
            echo "Exception: {$e->getMessage()}";
        }
    } else {
        // If the user is not authorized.
        header("Location: ../Errors/error_acces.php");
    }
}
