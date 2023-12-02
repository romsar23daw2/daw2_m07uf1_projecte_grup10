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

// Check if I entered a valid product ID.
if (isset($_POST['id_producte_trobat'])) {
  // Session that I use to store the id of the manager that was found. I need this in order to be able to modify the id of the manager.
  $_SESSION['id_producte_trobat'] = $_POST['id_producte_trobat'];
  $producte_trobat = fLocalitzarProducte($_POST['id_producte_trobat']);
}

// Parameters of the manager.
$parametres_complets =  (isset($_POST['nom_producte'])) && (isset($_POST['id_producte'])) && (isset($_POST['preu_producte'])) && (isset($_POST['iva_producte'])) && (isset($_POST['disponibilitat_producte']));

if ($parametres_complets) {
  // Here i access $_SESSION['id_producte_trobat'] in order to be able to compare the id from the manager, without needing to enter it again, and because of this, I'm able to change the ID of the manager.
  $modificat = fModificarProducte($_SESSION['id_producte_trobat'], $_POST['nom_producte'], $_POST['id_producte'], $_POST['preu_producte'], $_POST['iva_producte'], $_POST['disponibilitat_producte']);
  $_SESSION['modificat'] = $modificat;

  header("refresh: 5; url=menu.php"); // Passats 5 segons el navegador demana menu.php i es torna a menu.php.
}
?>

<!DOCTYPE html>
<html lang="ca">

<head>
  <meta charset="utf-8">
  <title>Modificació de producte - Rellotgeria</title>
  <link rel="stylesheet" href="./Assets/Stylesheets/agenda.css">
</head>

<body>
  <!-- If I'm a manager. -->
  <?php if ($_SESSION['tipus_usuari'] == 1) : ?>
    <form action="modificar_producte.php" method="POST">
      <h3><b>Modificació d'un producte:</b></h3>
      <p>
        <?php
        // In order to just show this part of the form when I don't have a valid manager.
        if (!$producte_trobat) {
        ?>
      <div>

        <label>ID del producte a cercar:</label>
        <input type="number" name="id_producte_trobat" required><br>
        <br>
        <button type="submit">Cercar producte.</button>
      </div>
    <?php
        } elseif ($producte_trobat) {
    ?>
      <div>
        <label>Nou nom del producte:</label>
        <input type="text" name="nom_producte"><br>

        <label>Nou ID del producte:</label>
        <input type="number" name="id_producte" required><br>

        <label>Nou preu del producte:</label>
        <input type="text" name="preu_producte" required><br>

        <label>Nou IVA del producte:</label>
        <input type="text" name="iva_producte" required><br>

        <label>Diponibilitat del producte:</label>
        <input type="text" name="disponibilitat_producte" required><br>

        <!-- php GESTOR; is to add the type of user at the end.  -->
        <button type="submit" name="modificar_producte">Modificar el producte.</button>
      </div>
    </form>
  <?php
        }
  ?>
  </p>
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
    if ($_SESSION['modificat']) echo "<p style='color:red'>El producte ha estat modificat correctament</p>";
    else {
      echo "El producte no ha estat registrat<br>";
      echo "Comprova si hi ha algún problema del sistema per poder modificar productes<br>";
    }

    unset($_SESSION['modificat']);
  }
  ?>
</body>

</html>