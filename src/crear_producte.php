<?php
session_start();
require("./funcions.php");

$nomFitxer = DIRECTORI_CISTELLA . $_SESSION['usuari'];
$_SESSION['producte'] = fLlegeixFitxer($nomFitxer);

if (!isset($_SESSION['usuari'])) {
  header("Location: ./Errors/error_acces.php");
} elseif (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)) {
  header("Location: ./logout_expira_sessio.php");
}

// Parameters of the manager.
$parametres_complets =  (isset($_POST['nom_producte'])) && (isset($_POST['id_producte'])) && (isset($_POST['preu_producte'])) && (isset($_POST['iva_producte'])) && (isset($_POST['disponibilitat_producte']));

if ($parametres_complets) {
  // Here i access $_SESSION['id_producte_trobat'] in order to be able to compare the id from the manager, without needing to enter it again, and because of this, I'm able to change the ID of the manager.
  $modificat = fCrearProducte($_POST['nom_producte'], $_POST['id_producte'], $_POST['preu_producte'], $_POST['iva_producte'], $_POST['disponibilitat_producte']);
  $_SESSION['modificat'] = $modificat;

  header("refresh: 5; url=menu.php"); // Passats 5 segons el navegador demana menu.php i es torna a menu.php.
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

<body class="container mt-5">
  <!-- If I'm a manager. -->
  <?php if ($_SESSION['tipus_usuari'] == 1) : ?>
    <h3><b>Creació d'un producte:</b></h3><br>

    <form action="crear_producte.php" method="POST">
      <div class="form-group">
        <label>Nom del producte:</label>
        <input type="text" class="form-control" name="nom_producte"><br>
      </div>

      <div class="form-group">
        <label>ID del producte:</label>
        <input type="number" class="form-control" name="id_producte" required><br>
      </div>

      <div class="form-group">
        <label>Preu del producte:</label>
        <input type="text" class="form-control" name="preu_producte" required><br>
      </div>

      <div class="form-group">
        <label>IVA del producte:</label>
        <input type="text" class="form-control" name="iva_producte" required><br>
      </div>

      <div class="form-group">  
        <label>Diponibilitat del producte:</label>
        <input type="text" class="form-control" name="disponibilitat_producte" required><br><br>
      </div>

        <button type="submit" class="btn btn-primary" name="crear_producte">Crear producte.</button>
      </div>
    </form>
  <?php else :
    // No one else can acess to this.
    header("Location: ./Errors/error_acces.php");
  ?>
  <?php endif; ?>

  <label class="diahora mt-4">
  <p class="mt-3"><a href="./cistella_gestio_productes.php" class="btn btn-secondary">Torna a la cistella</a></p>

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