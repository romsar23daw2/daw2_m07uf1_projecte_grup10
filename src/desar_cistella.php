<?php
require("./funcions.php");

session_start();
if (!isset($_SESSION['usuari'])) {
    header("Location: ./Errors/error_acces.php");
    exit;
}

if (isset($_POST['resp'])) {
    if ($_POST['resp'] == "y") {

        foreach ($_SESSION['producte'] as $producte) {
            fCreaCistella(
                $_SESSION['usuari'],
                $producte
            );
        }

        header("Location: ./menu.php");
    } else {
        header("Location: ./menu.php");
    }
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

        <?php
        // echo $_SESSION['producte'] . "<br>" . "<br>";
        foreach ($_SESSION['producte'] as $producte) {
            echo $producte . "<br>";
        }
        ?>

        <form action="desar_cistella.php" method="post">
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