<?php
require("./funcions.php");

session_start();
if (!isset($_SESSION['usuari'])) {
    header("Location: ./Errors/error_acces.php");
    exit;
}

if (isset($_POST['resp'])) {
    if ($_POST['resp'] == "y") {
        $llistaProductes = fLlegeixFitxer(FITXER_PRODUCTES);
        if (fComprovarDisponibilitat($_SESSION['producte'], $llistaProductes)) {
            if (!fCreaCistella($_SESSION['usuari'], $_SESSION['producte'])) {
                header("Location: ./Errors/logout_error_cistella.php");
                exit;
            }
        } else {
            // hay javascript, pero solo para que salga una alerta. Comprobar si inflinje las normas de Collados.
            echo "<script>alert('El producto no está disponible.'); window.location.href='./cistella_gestio_productes.php';</script>";
            exit;
        }
    }
    header("Location: ./menu.php");
}
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="utf-8">
    <title>Desar cistella - Rellotgeria</title>
    <link rel="stylesheet" href="./Assets/Stylesheets/agenda.css">
</head>

<body>
    <?php if ($_SESSION['tipus_usuari'] == 0) { ?>
        <h3><b>Cistella</b></h3>
        <p>Vols desar la cistella?:</p>
        <form action="desar_cistella.php" method="POST">
            <input type="radio" name="resp" value="y" />Sí<br />
            <input type="radio" name="resp" value="n" checked />No<br />
            <br>
            <input type="submit" value="Afegir a la cistella" />
        </form>
    <?php } else {
        header("Location: ./Errors/error_acces.php");
    } ?>

    <label class="diahora">
        <?php
        echo "<p>Usuari utilitzant l'agenda: " . $_SESSION['usuari'] . "</p>";
        date_default_timezone_set('Europe/Andorra');
        echo "<p>Data i hora: " . date('d/m/Y h:i:s') . "</p>";
        ?>
    </label>
</body>

</html>
