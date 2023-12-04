<?php
require("./funcions.php");

if ((isset($_POST['usuari'])) && (isset($_POST['ctsnya']))) {
    // Here I have thee diferent variables, which I use to check the user type.
    $autenticat_admin = fAutenticacioAdmin($_POST['usuari']);
    $autenticat_gestor = fAutenticacioGestor($_POST['usuari']);
    $autenticat_client = fAutenticacioClient($_POST['usuari']);

    if ($autenticat_admin) {
        session_start(); // Inici de sessió
        $_SESSION['usuari'] = $_POST['usuari'];
        $_SESSION['tipus_usuari'] = 2;  // Here I set the user type for the admin.
        $_SESSION['expira'] = time() + TEMPS_EXPIRACIO;

        // Almacena la dirección de correo electrónico del gestor en la sesión
        $_SESSION['gestorEmail'] = fAconsegueixemail($_POST['usuari']);

        header("Location: menu.php");
    } elseif ($autenticat_gestor) {
        session_start(); // Inici de sessió.
        $_SESSION['usuari'] = $_POST['usuari'];
        $_SESSION['tipus_usuari'] = 1;  // Here I set the user type for gestor.
        $_SESSION['expira'] = time() + TEMPS_EXPIRACIO;

        // Almacena la dirección de correo electrónico del gestor en la sesión
        $_SESSION['gestorEmail'] = fAconsegueixemail($_POST['usuari']);

        header("Location: menu.php");
    } elseif ($autenticat_client) {
        session_start(); // Inici de sessió
        $_SESSION['usuari'] = $_POST['usuari'];
        $_SESSION['tipus_usuari'] = 0;  // Here I set the user type for client.
        $_SESSION['expira'] = time() + TEMPS_EXPIRACIO;
        header("Location: menu.php");
    }

    if (!isset($_SESSION['usuari'])) {
        header("Location: ./Errors/error_login.php");
    }
}
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="utf-8">
    <title>Iniciar sessió - Rellotgeria</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./Assets/Stylesheets/agenda.css">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h3><b>Inici de sessió la botiga de rellotges</b></h3>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="usuari">Indica el teu nom d'usuari:</label>
                <input type="text" class="form-control" name="usuari" required>
            </div>
            <div class="form-group">
                <label for="ctsnya">Indica la teva contrasenya:</label>
                <input type="password" class="form-control" name="ctsnya" required>
            </div>
            <button type="submit" class="btn btn-primary">Envia</button>
        </form>
        <p class="mt-3"><a href="index.php">Torna a la pàgina inicial</a></p>

        <label class="diahora mt-3">
            <?php
            date_default_timezone_set('Europe/Andorra');
            echo "<p>Data i hora: " . date('d/m/Y h:i:s') . "</p>";
            ?>
        </label>
    </div>
</body>

</html>