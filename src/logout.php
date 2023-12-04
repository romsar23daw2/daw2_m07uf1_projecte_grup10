<?php
if ((isset($_POST['resp'])) && ($_POST['resp'] == "y")) {
    session_start();
    //Alliberant variables de sessió. Esborra el contingut de les variables de sessió del fitxer de sessió. Buida l'array $_SESSION. No esborra cookies
    session_unset();
    //Destrucció de la cookie de sessió dins del navegador
    $cookie_sessio = session_get_cookie_params();
    setcookie("PHPSESSID", "", time() - 3600, $cookie_sessio['path'], $cookie_sessio['domain'], $cookie_sessio['secure'], $cookie_sessio['httponly']); //Neteja cookie de sessió
    //Destrucció de la informació de sessió (per exemple, el fitxer de sessió  o l'identificador de sessió) 
    session_destroy();
    header("Location: index.php");
} else {
    session_start();
    if (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)) {
        header("Location: ./logout_expira_sessio.php");
    }
}
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="utf-8">
    <title>Tancar sessió - Rellotgeria</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./Assets/Stylesheets/agenda.css">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h3><b>Finalització de sessió del visualitzador de l'agenda</b></h3>
        <p>Estàs segur que vols finalitzar la sessió?:</p>

        <form action="logout.php" method="POST">
            <div class="form-check">
                <input type="radio" class="form-check-input" name="resp" value="y" id="radioYes">
                <label class="form-check-label" for="radioYes">Sí</label>
            </div>
            <div class="form-check">
                <input type="radio" class="form-check-input" name="resp" value="n" id="radioNo" checked>
                <label class="form-check-label" for="radioNo">No</label>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Valida</button>
        </form>

        <p class="mt-3"><a href="menu.php" class="btn btn-secondary">Torna al menú de l'agenda</a></p>

        <label class="diahora mt-3">
            <?php
            if ((isset($_POST['resp'])) && ($_POST['resp'] == "n")) {
                header("Location: menu.php");
            }
            date_default_timezone_set('Europe/Andorra');
            echo "<p>Data i hora: " . date('d/m/Y h:i:s') . "</p>";
            ?>
        </label>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>