<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php'; // Asegúrate de que el autoloader de Composer está incluido
use Dompdf\Dompdf;

require("./funcions.php");

$nomFitxer = DIRECTORI_CISTELLA . $_SESSION['usuari'];
$_SESSION['producte'] = fLlegeixFitxer($nomFitxer);

if (!isset($_SESSION['usuari'])) {
    header("Location: ./Errors/error_acces.php");
    exit;
} elseif (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)) {
    header("Location: ./logout_expira_sessio.php");
    exit;
}

if (isset($_POST['producte'])) {
    foreach ($_POST['producte'] as $producte) {
        // I've done this line with ChatGPT.
        $_SESSION['producte'][] = $producte . "\n";
    }

    header("Location: ./desar_cistella.php");
}

if (isset($_GET['generar_pdf']) && $_SESSION['tipus_usuari'] == 1) {
    ob_start();
?>
    <div>
        <h3><b>Llista de Productes:</b></h3>
        <table>
            <thead>
                <tr>
                    <th>Nom producte</th>
                    <th>ID producte</th>
                    <th>Preu producte</th>
                    <th>IVA producte</th>
                    <th>Disponibilitat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $llista = fLlegeixFitxer(FITXER_PRODUCTES);
                fGenerarLlistaProductes($llista);
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
    $dompdf->stream("llista_productes.pdf");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="utf-8">
    <title>Selecció de producte - Rellotgeria</title>
    <link rel="stylesheet" href="./Assets/Stylesheets/agenda.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body class="bg-light">

    <?php if ($_SESSION['tipus_usuari'] == 0) : ?>
        <?php if ($_SESSION['producte']) : ?>
            <div class="container mt-4">
                <b><u>Productes en la cistella: </u></b><br>
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <?php foreach ($_SESSION['producte'] as $indexProducte => $producte) : ?>
                                <td><?php echo $producte; ?></td>
                                <?php if ($indexProducte % 2 == 1) : ?>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                    </table>
                </div>
                <br>
            </div>
        <?php else : ?>
            <div class="container mt-4">
                Cap producte a la cistella<br>
            </div>
        <?php endif; ?>

        <div class="container mt-4">
            <h3><b>Productes de la botiga:</b></h3>
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Nom producte</th>
                        <th>ID producte</th>
                        <th>Preu producte</th>
                        <th>IVA producte</th>
                        <th>Disponibilitat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $llista = fLlegeixFitxer(FITXER_PRODUCTES);
                    fGenerarLlistaProductes($llista);
                    ?>
                </tbody>
            </table>

            <h3><b>Productes que es venen la botiga:</b></h3>
            <form action="./cistella_gestio_productes.php" method="POST">
                <?php
                $llistaProductes = fLlegeixFitxer(FITXER_PRODUCTES);
                foreach ($llistaProductes as $producte) {
                    $dadesProducte = explode(":", $producte);
                    $nomProducte = $dadesProducte[0];
                    $disponibilitat = $dadesProducte[4];

                    // Mostrar solo si el producto está disponible
                    // Show only if the product is available.

                    if ($disponibilitat == "Disponible") {
                        echo '<input type="checkbox" name="producte[]" value="' . $nomProducte . '" /> ' . $nomProducte . '<br />';
                    }
                }
                ?>
                <br>
                <input value="Selecciona" type="submit"><br><br>
            </form>
        </div>

    <?php elseif ($_SESSION['tipus_usuari'] == 1) : ?>
        <div class="container mt-4">
            <h3><b>Productes de la botiga:</b></h3>
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Nom producte</th>
                        <th>ID producte</th>
                        <th>Preu producte</th>
                        <th>IVA producte</th>
                        <th>Disponibilitat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $llista = fLlegeixFitxer(FITXER_PRODUCTES);
                    fGenerarLlistaProductes($llista);
                    ?>
                </tbody>
            </table>
        </div>

        <div class="container mt-4">
            <h3>Gestió de productes</h3>

            <form action="./crear_producte.php" method="POST">
                <input class="btn btn-primary" type="submit" name="crear_producte" value="Crear producte">
            </form><br>

            <form action="./modificar_producte.php" method="POST">
                <input class="btn btn-primary" type="submit" name="modificar_productes" value="Modificar producte">
            </form><br>

            <form action="#" method="POST">
                <input class="btn btn-danger" type="submit" name="esborrar_producte" value="Esborar producte">
            </form><br>

            <h3><b>Generar PDF de la llista dels productes:</b></h3>
            <form method="get">
                <input class="btn btn-success" type="submit" name="generar_pdf" value="Generar PDF">
            </form><br>
        </div>

    <?php else :
        header("Location: ./Errors/error_acces.php");
    ?>
    <?php endif; ?>

    <label class="diahora container mt-4">
        <p><a href="./menu.php">Torna al menú</a></p>

        <?php
        echo "<p>Usuari utilitzant l'agenda: " . $_SESSION['usuari'] . "</p>";
        date_default_timezone_set('Europe/Andorra');
        echo "<p>Data i hora: " . date('d/m/Y h:i:s') . "</p>";
        ?>
    </label>

</body>

</html>