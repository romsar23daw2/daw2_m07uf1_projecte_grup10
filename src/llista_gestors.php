<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;

if (!isset($_SESSION['usuari'])) {
    header("Location: ./Errors/error_acces.php");
    exit;
} elseif (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)) {
    header("Location: ./logout_expira_sessio.php");
    exit;
}

if ($_SESSION['tipus_usuari'] != 2) {
    // 		<!-- If logged in with the admin, show the list of managers. In this case, as I need to use a function inside the PHP code, I echo the table in individual parts. -->

    header("Location: ./Errors/error_autoritzacio.php");
    exit;
}

if (isset($_GET['generar_pdf']) && $_SESSION['tipus_usuari'] == 2) {
    ob_start();
?>
    <div>
        <h3><b>Llista de gestors:</b></h3>
        <table>
            <thead>
                <tr>
                    <th>Identificador</th>
                    <th>Nom de usuari</th>
                    <th>Nom complet</th>
                    <th>Correu electrònic</th>
                    <th>Telèfon de contacte</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require("./funcions.php");
                $llista = fLlegeixFitxer(FITXER_GESTORS);
                fCreaTaulaGestors($llista);

                ?>
            </tbody>
        </table>
    </div>
<?php
    $html = ob_get_clean();

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("llista_gestors.pdf");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="utf-8">
    <title>Llista de gestors - Rellotgeria</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body class="container mt-5">
    <?php if ($_SESSION['tipus_usuari'] == 2) : ?>
        <div>
            <?php
            require("./funcions.php");

            // If the FITXER_GESTORS doesn't exist, or is empty, means that there aren't managers.
            if (!fLlegeixFitxer(FITXER_GESTORS)) :
                echo "No hi ha cap gestor registrat.";
            ?>

            <?php else : ?>
                <h3><b>Llista de gestors:</b></h3>
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Identificador</th>
                            <th scope="col">Nom de usuari</th>
                            <th scope="col">Nom complet</th>
                            <th scope="col">Correu electrònic</th>
                            <th scope="col">Telèfon de contacte</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $llista = fLlegeixFitxer(FITXER_GESTORS);
                        fCreaTaulaGestors($llista);
                        ?>
                    </tbody>
                </table>
        </div>
        <div>
            <h3><b>Generar PDF de la llista de gestors:</b></h3><br>
            <form method="get">
                <button type="submit" name="generar_pdf" class="btn btn-primary">Generar PDF</button>
            </form>
        </div>
    <?php endif; ?>

<?php else : ?>
    <!-- Only an admin can access here. -->
    <?php header("Location: ./Errors/error_autoritzacio.php"); ?>
    <?php exit; ?>
<?php endif; ?>

<p class="mt-3"><a href="menu.php" class="btn btn-secondary">Torna al menú</a></p>

<label class="diahora mt-4">
    <?php
    echo "<p>Usuari utilitzant l'agenda: " . $_SESSION['usuari'] . "</p>";
    date_default_timezone_set('Europe/Andorra');
    echo "<p>Data i hora: " . date('d/m/Y h:i:s') . "</p>";
    ?>
</label>
</body>

</html>