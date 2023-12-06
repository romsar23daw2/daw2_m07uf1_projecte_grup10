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

        header("Location: ./cistella_gestio_productes.php");
    } else {
        header("Location: ./cistella_gestio_productes.php");
    }
}
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="utf-8">
    <title>Desar Cistella - Rellotgeria</title>
    <!-- Enlaces a los estilos de Bootstrap y tu hoja de estilos personalizada -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./Assets/Stylesheets/agenda.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
        }

        .cistella-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .diahora-container {
            margin-top: 20px;
            font-size: 14px;
            color: #6c757d;
        }

        .diahora-item {
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <?php if ($_SESSION['tipus_usuari'] == 0) { ?>
        <div class="container cistella-container">
            <h3 class="mb-4"><b>Cistella</b></h3>
            <u>Productes:</u><br>

            <?php
            foreach ($_SESSION['producte'] as $producte) {
                echo $producte . "<br>";
            }
            ?>

            <p class="mt-4">Vols desar la cistella?</p>

            <form action="desar_cistella.php" method="post">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="resp" value="y" checked>
                    <label class="form-check-label">Sí</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="resp" value="n">
                    <label class="form-check-label">No</label>
                </div>
                <br>
                <input type="submit" class="btn btn-primary" value="Desar la Cistella" />
            </form>
        </div>
    <?php } else {
        header("Location: ./Errors/error_acces.php");
    } ?><br>

    <div class="container diashora-container">
        <div class="diahora-item">
            <?php echo "Usuari utilitzant l'agenda: " . $_SESSION['usuari']; ?>
        </div>
        <div class="diahora-item">
            <?php
            date_default_timezone_set('Europe/Andorra');
            echo "Data i hora: " . date('d/m/Y h:i:s');
            ?>
        </div>
    </div>
</body>

</html>