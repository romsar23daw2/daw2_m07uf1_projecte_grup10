<?php
require("./funcions.php");

// Now I import the file where I have the method to modify a client.
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

// Check if I entered an id before calling fModifica client().
if (isset($_POST['id_client_trobat'])) {
    // Session that I use to store the id of the manager that was found. I need this in order to be able to modify the id of the manager.
    $_SESSION['id_client_trobat'] = $_POST['id_client_trobat'];
    $client_trobat = fLocalitzarClient($_POST['id_client_trobat']);
}

// Parameters of the manager.
$parametres_complets = (isset($_POST['nom_usuari'])) && (isset($_POST['cts_nou_client'])) && (isset($_POST['nom_complet_nou_client'])) && (isset($_POST['correu_nou_client'])) && (isset($_POST['telefon_nou_client'])) && (isset($_POST['adreca_nou_client'])) && (isset($_POST['num_visa_nou_client']))  && (isset($_POST['nom_gestor_nou_client']));

if ($parametres_complets) {
    // Here i access $_SESSION['id_client_trobat'] in order to be able to compare the id from the manager, without needing to enter it again, and because of this, I'm able to change the ID of the manager.
    $client_modificat = new Client($_POST['id_client_trobat'], $_POST['nom_usuari'], $_POST['cts_nou_client'], $_POST['nom_complet_nou_client'], $_POST['correu_nou_client'], $_POST['telefon_nou_client'], $_POST['adreca_nou_client'], $_POST['num_visa_nou_client'], $_POST['nom_gestor_nou_client'], $_POST['tipus_usuari']);

    $modificat = $client_modificat->fModificarClient($_SESSION['id_client_trobat'], $client_modificat);
    $_SESSION['modificat'] = $modificat;

    header("refresh: 5; url=menu.php"); // Passats 5 segons el navegador demana menu.php i es torna a menu.php.
}
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="utf-8">
    <title>Modificar client - Rellotgeria</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body class="container mt-5">

    <h3><b>Modificació d'un client:</b></h3>

    <form action="modificar_borrar_client.php" method="POST">
        <p>
            <?php
            if (!$client_trobat) {
            ?>
        <div>
            <label>ID del client a cercar:</label>
            <input type="number" name="id_client_trobat" min="1" max="1000" value="put" required><br>
            <br>
            <button type="submit" class="btn btn-primary">Cercar client</button>
        </div>
    <?php
            } elseif ($client_trobat) {
    ?>
        <div>
            <label>Nou nom d'usuari:</label>
            <input type="text" name="nom_usuari" required><br>

            <label>Nova contrasenya del client:</label>
            <input type="password" name="cts_nou_client" pattern="(?=^.{8,}$)(?=.*\d)(?=.*[!@#$%^&*]+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Mínims: 8 caràcters, una majúscula, una minúscula, un número i un caràter especial" required><br>

            <label>Nou nom complet del client:</label>
            <input type="text" name="nom_complet_nou_client" required><br>

            <label>Nou correu del client:</label>
            <input type="text" name="correu_nou_client" required><br>

            <label>Nou telèfon de contacte del client:</label>
            <input type="number" name="telefon_nou_client" required><br>

            <label>Nova adreça postal del client:</label>
            <input type="number" name="adreca_nou_client" required><br>

            <label>Nou número de visa del client:</label>
            <input type="number" name="num_visa_nou_client" required><br>

            <label>Nou nom del gestor assignat pel client:</label>
            <input type="text" name="nom_gestor_nou_client"><br>
            </p>

            <button type="submit" name="tipus_usuari" value=<?php echo CLIENT ?> class="btn btn-primary">Modificar client</button>
        </div>
        </p>
    </form>

    <h3><b>Esborrar client:</b></h3><br>

    <form action="#" method="post">
        <button type="submit" name="esborrar_client" class="btn btn-danger">Esborrar client</button><br><br>
    </form>
<?php
            }
?>
</form>

<p class="mt-3"><a href="menu.php" class="btn btn-secondary">Torna al menú</a></p>

<label class="diahora mt-4">
    <?php
    echo "<p>Usuari utilitzant l'agenda: " . $_SESSION['usuari'] . "</p>";

    date_default_timezone_set('Europe/Andorra');
    echo "<p>Data i hora: " . date('d/m/Y h:i:s') . "</p>";

    if (isset($_SESSION['modificat'])) {
        if ($_SESSION['modificat']) echo "<p style='color:red'>El client ha estat modificat correctament</p>";
        else {
            echo "L'Usuari no ha estat registrat<br>";
            echo "Comprova si hi ha algún problema del sistema per poder enregistrar nous usuaris<br>";
        }

        unset($_SESSION['modificat']);
    }
    ?>
</label>
</body>

</html>
