<?php
require("./funcions.php");

// Now I import the file where I have the method to create a new client.
require("./classes-gestor-client-admin.php");
session_start();

if (!isset($_SESSION['usuari'])) {
    header("Location: ./Errors/error_acces.php");
    exit(); // Agregado para detener la ejecución del script después de la redirección.
} else {
    $autoritzat_admin = fAutoritzacio($_SESSION['usuari']);

    if (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)) {
        header("Location: ./logout_expira_sessio.php");
        exit(); // Agregado para detener la ejecución del script después de la redirección.
    } else if (!$autoritzat_admin) {
        header("Location: ./Errors/error_autoritzacio.php");
        exit(); // Agregado para detener la ejecución del script después de la redirección.
    }
}

$parametres_complets = (
    isset($_POST['id_nou_client']) &&
    isset($_POST['nom_usuari']) &&
    isset($_POST['cts_nou_client']) &&
    isset($_POST['nom_complet_nou_client']) &&
    isset($_POST['correu_nou_client']) &&
    isset($_POST['telefon_nou_client']) &&
    isset($_POST['adreca_nou_client']) &&
    isset($_POST['num_visa_nou_client']) &&
    isset($_POST['nom_gestor_nou_client']) &&
    isset($_POST['tipus_usuari'])
);

if ($parametres_complets) {
    $nou_client = new Client(
        $_POST['id_nou_client'],
        $_POST['nom_usuari'],
        $_POST['cts_nou_client'],
        $_POST['nom_complet_nou_client'],
        $_POST['correu_nou_client'],
        $_POST['telefon_nou_client'],
        $_POST['adreca_nou_client'],
        $_POST['num_visa_nou_client'],
        $_POST['nom_gestor_nou_client'],
        $_POST['tipus_usuari']
    );

    // $nou_client->fRegistrarClient($nou_client) is because I use $nou_client to create a new cñient, and I need to specify the class if I don't, I can't access the method.
    $afegit = $nou_client->fRegistrarClient($nou_client);
    $_SESSION['afegit'] = $afegit;

    header("refresh: 5; url=menu.php");
}
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="utf-8">
    <title>Registrar client - Rellotgeria</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body class="container mt-5">

    <h3><b>Registre d'un nou client:</b></h3>

    <form action="registre_client.php" method="POST">
        <div class="form-group">
            <label for="id_nou_client">ID del nou client:</label>
            <input type="number" class="form-control" id="id_nou_client" name="id_nou_client" min="0" max="1000" required>
        </div>

        <div class="form-group">
            <label for="nom_usuari">Nom d'usuari:</label>
            <input type="text" class="form-control" id="nom_usuari" name="nom_usuari" required>
        </div>

        <div class="form-group">
            <label for="cts_nou_client">Contrasenya del nou client:</label>
            <input type="password" class="form-control" id="cts_nou_client" name="cts_nou_client" pattern="(?=^.{8,}$)(?=.*\d)(?=.*[!@#$%^&*]+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Mínims: 8 caràcters, una majúscula, una minúscula, un número i un caràter especial" required>
        </div>

        <div class="form-group">
            <label for="nom_complet_nou_client">Nom complet del nou client:</label>
            <input type="text" class="form-control" id="nom_complet_nou_client" name="nom_complet_nou_client" required>
        </div>

        <div class="form-group">
            <label for="correu_nou_client">Correu del nou client:</label>
            <input type="text" class="form-control" id="correu_nou_client" name="correu_nou_client" required>
        </div>

        <div class="form-group">
            <label for="telefon_nou_client">Telèfon de contacte del nou client:</label>
            <input type="number" class="form-control" id="telefon_nou_client" name="telefon_nou_client" required>
        </div>

        <div class="form-group">
            <label for="adreca_nou_client">Adreça postal del nou client:</label>
            <input type="number" class="form-control" id="adreca_nou_client" name="adreca_nou_client" required>
        </div>

        <div class="form-group">
            <label for="num_visa_nou_client">Número de visa del nou client:</label>
            <input type="number" class="form-control" id="num_visa_nou_client" name="num_visa_nou_client" required>
        </div>

        <div class="form-group">
            <label for="nom_gestor_nou_client">Nom del gestor assignat pel nou client:</label>
            <input type="text" class="form-control" id="nom_gestor_nou_client" name="nom_gestor_nou_client">
        </div>

        <button type="submit" class="btn btn-primary" name="tipus_usuari" value=<?php echo CLIENT ?>>Crear client.</button>
    </form>

    <p class="mt-3"><a href="menu.php" class="btn btn-secondary">Torna al menú</a></p>

    <label class="diahora mt-4">
        <?php
        echo "<p>Usuari utilitzant l'agenda: " . $_SESSION['usuari'] . "</p>";
        date_default_timezone_set('Europe/Andorra');
        echo "<p>Data i hora: " . date('d/m/Y h:i:s') . "</p>";

        if (isset($_SESSION['afegit'])) {
            if ($_SESSION['afegit']) echo "<p style='color:red'>El client ha estat registrat correctament</p>";
            else {
                echo "L'Usuari no ha estat registrat<br>";
                echo "Comprova si hi ha algún problema del sistema per poder enregistrar nous usuaris<br>";
            }

            unset($_SESSION['afegit']);
        }
        ?>
    </label>
</body>

</html>