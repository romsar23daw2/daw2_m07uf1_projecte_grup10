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
</head>

<body>
  <!-- If I'm a manager. -->
  <?php if ($_SESSION['tipus_usuari'] == 1) : ?>
    <h3><b>Creació d'un producte:</b></h3>

    <form action="crear_producte.php" method="POST">
      <div>
        <label>Nom del producte:</label>
        <input type="text" name="nom_producte"><br>

        <label>ID del producte:</label>
        <input type="number" name="id_producte" required><br>

        <label>Preu del producte:</label>
        <input type="text" name="preu_producte" required><br>

        <label>IVA del producte:</label>
        <input type="text" name="iva_producte" required><br>

        <label>Diponibilitat del producte:</label>
        <input type="text" name="disponibilitat_producte" required><br>

        <button type="submit" name="crear_producte">Crear producte.</button>
      </div>
    </form>
  <?php else :
    // No one else can acess to this.
    header("Location: ./Errors/error_acces.php");
  ?>
  <?php endif; ?>

  <label class="diahora">
    <p><a href="./menu.php">Torna al menú</a></p>

    <?php
    echo "<p>Usuari utilitzant l'agenda: " . $_SESSION['usuari'] . "</p>";
    date_default_timezone_set('Europe/Andorra');
    echo "<p>Data i hora: " . date('d/m/Y h:i:s') . "</p>";

    if (isset($_SESSION['modificat'])) {
      if ($_SESSION['modificat']) echo "<p style='color:red'>El producte ha estat creat correctament</p>";
      else {
        echo "El producte no ha estat registrat<br>";
        echo "Comprova si hi ha algún problema del sistema per poder modificar productes<br>";
      }

      unset($_SESSION['modificat']);
    }
    ?>
</body>

</html>