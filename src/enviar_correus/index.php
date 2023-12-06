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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Email</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <form class="bg-white p-4 rounded shadow-sm" action="send.php" method="post">
            <div class="form-group">
                <!-- If I'm a client. -->
                <?php if ($_SESSION['tipus_usuari'] == 0) { ?>
                    <label for="subject">Asumpte</label>
                    <select class="form-control" id="subject" name="subject">
                        <option value="petició de modificacio/esborrament del compte de client">Petició de modificació/esborrament del compte de client</option>
                        <option value="petició de justificació de comanda rebutjada">Petició de justificació de comanda rebutjada</option>
                    </select>
            </div>
            <div class="form-group">
                <label for="message">Missatge</label>
                <input type="text" class="form-control" id="message" name="message" value="">
            </div>
            <div class="form-group">
                <a href="../menu.php" class="btn btn-secondary">Tornar</a>

                <button type="submit" class="btn btn-success" name="send">Enviar</button>
            </div>
        <?php } elseif ($_SESSION['tipus_usuari'] == 1) { ?>
            <label for="subject">Asumpte</label>
            <select class="form-control" id="subject" name="subject">
                <option value="petició d'addició/modificació/esborrament de client">Petició d'addició/modificació/esborrament de client</option>
            </select>
    </div>
    <div class="form-group">
        <label for="message">Missatge</label>
        <input type="text" class="form-control" id="message" name="message" value="">
    </div>
    <div class="form-group">
        <a href="../menu.php" class="btn btn-secondary">Tornar</a>

        <button type="submit" class="btn btn-success" name="send">Enviar</button>
    </div>
<?php } else {
                    header("Location: ../Errors/error_acces.php");
                } ?>
</form>
</div>
</body>

</html>