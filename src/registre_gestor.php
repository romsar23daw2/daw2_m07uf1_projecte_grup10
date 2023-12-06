<?php
require("./funcions.php");

// Now I import the file where I have the method to create a new manager.
require("./classes-gestor-client-admin.php");
session_start();

if (!isset($_SESSION['usuari'])) {
    header("Location: ./Errors/error_acces.php");
} else {
    $autoritzat_admin = fAutoritzacio($_SESSION['usuari']);

    if (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)) {
        header("Location: ./logout_expira_sessio.php");
    } else if (!$autoritzat_admin) {
        header("Location: ./Errors/error_autoritzacio.php");
    }
}

$parametres_complets = (isset($_POST['id_nou_gestor'])) && (isset($_POST['nom_usuari'])) && (isset($_POST['cts_nou_gestor'])) && (isset($_POST['nom_complet_nou_gestor'])) && (isset($_POST['correu_nou_gestor'])) && (isset($_POST['telefon_nou_gestor'])) && (isset($_POST['tipus_usuari']));

if ($parametres_complets) {
    $nou_gestor = new Gestor(
        $_POST['id_nou_gestor'],
        $_POST['nom_usuari'],
        $_POST['cts_nou_gestor'],
        $_POST['nom_complet_nou_gestor'],
        $_POST['correu_nou_gestor'],
        $_POST['telefon_nou_gestor'],
        $_POST['tipus_usuari']
    );

    // $nou_gestor->fRegistrarGestor($nou_gestor) is because I use $nou_gestor to create a new manager, and I need to specify the class if I don't, I can't access the method.
    $afegit = $nou_gestor->fRegistrarGestor($nou_gestor);
    $_SESSION['afegit'] = $afegit;

    header("refresh: 5; url=menu.php");
}
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="utf-8">
    <title>Registrar gestor - Rellotgeria</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body class="container mt-5">

    <h3><b>Registre d'un nou gestor:</b></h3>

    <form action="registre_gestor.php" method="POST">
        <div class="form-group">
            <label for="id_nou_gestor">ID del nou gestor:</label>
            <input type="number" class="form-control" id="id_nou_gestor" name="id_nou_gestor" min="1" max="100" required>
        </div>

        <div class="form-group">
            <label for="nom_usuari">Nom d'usuari:</label>
            <input type="text" class="form-control" id="nom_usuari" name="nom_usuari" required>
        </div>

        <div class="form-group">
            <label for="cts_nou_gestor">Contrasenya del nou gestor:</label>
            <input type="password" class="form-control" id="cts_nou_gestor" name="cts_nou_gestor" pattern="(?=^.{8,}$)(?=.*\d)(?=.*[!@#$%^&*]+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Mínims: 8 caràcters, una majúscula, una minúscula, un número i un caràter especial" required>
        </div>

        <div class="form-group">
            <label for="nom_complet_nou_gestor">Nom complet del nou gestor:</label>
            <input type="text" class="form-control" id="nom_complet_nou_gestor" name="nom_complet_nou_gestor" required>
        </div>

        <div class="form-group">
            <label for="correu_nou_gestor">Correu del nou gestor:</label>
            <input type="text" class="form-control" id="correu_nou_gestor" name="correu_nou_gestor" required>
        </div>

        <div class="form-group">
            <label for="telefon_nou_gestor">Telèfon de contacte del nou gestor:</label>
            <input type="number" class="form-control" id="telefon_nou_gestor" name="telefon_nou_gestor" required>
        </div>

        <button type="submit" class="btn btn-primary" name="tipus_usuari" value=<?php echo GESTOR ?>>Crear nou gestor.</button>
    </form>

    <p class="mt-3"><a href="menu.php" class="btn btn-secondary">Torna al menú</a></p>

    <label class="diahora mt-4">
        <?php
        echo "<p>Usuari utilitzant l'agenda: " . $_SESSION['usuari'] . "</p>";
        date_default_timezone_set('Europe/Andorra');
        echo "<p>Data i hora: " . date('d/m/Y h:i:s') . "</p>";

        if (isset($_SESSION['afegit'])) {
            if ($_SESSION['afegit']) echo "<p style='color:red'>El gestor ha estat registrat correctament</p>";
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