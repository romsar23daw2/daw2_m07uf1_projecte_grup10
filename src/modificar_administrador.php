<?php
require("./funcions.php");

// Now I import the file where I have the method to create a new manager.
require("./classes-gestor-client-admin.php");
session_start();

if (!isset($_SESSION['usuari'])) {
  header("Location: ./Errors/error_acces.php");
} else {
  $autoritzat = fAutoritzacio($_SESSION['usuari']);

  if (!isset($_SESSION['expira']) || (time() - $_SESSION['expira'] >= 0)) {
    header("Location:  ./logout_expira_sessio.php");
  } else if (!$autoritzat) {
    header("Location: ./Errors/error_autoritzacio.php");
  }
}

$parametres_complets = (isset($_POST['nom_usuari']) && isset($_POST['cts_admin']) && isset($_POST['correu_admin']) && isset($_POST['tipus_usuari']));

if ($parametres_complets) {
  $admin_modificat = new Admin(
    $_POST['nom_usuari'],
    $_POST['cts_admin'],
    $_POST['correu_admin'],
    $_POST['tipus_usuari']
  );

  $afegit = $admin_modificat->fModificacioDadesAdmin($parametres_modificats);
  $_SESSION['afegit'] = $afegit;

  header("refresh: 5; url=menu.php"); // Passats 5 segons el navegador demana menu.php i es torna a menu.php.
}
?>

<!DOCTYPE html>
<html lang="ca">

<head>
  <meta charset="utf-8">
  <title>Modificar dades - Rellotgeria</title>
  <link rel="stylesheet" href="./Assets/Stylesheets/agenda.css">
</head>

<body>
  <h3><b>Modificació de crendencials de l'administrador:</b></h3>

  <form action="modificar_dades_administrador.php" method="POST">
    <p>
      <label>Nou nom d'usuari:</label>
      <input type="text" name="nom_usuari" required><br>

      <label>Nova contrasenya:</label>
      <input type="password" name="cts_admin" pattern="(?=^.{8,}$)(?=.*\d)(?=.*[!@#$%^&*]+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Mínims: 8 caràcters, una majúscula, una minúscula, un número i un caràter especial" required><br>

      <label>Nou correu de l'administrador:</label>
      <input type="text" name="correu_admin" required><br>
    </p>

    <button type="submit" name="tipus_usuari" value=<?php echo ADMIN ?>>Modificar credencials.</button> <!-- value=<?php echo ADMIN ?> is to be able the type of user.-->
  </form>

  <p><a href="./menu.php">Torna al menú.</a></p>

  <label class="diahora">
    <?php
    echo "<p>Usuari utilitzant l'agenda: " . $_SESSION['usuari'] . "</p>";
    date_default_timezone_set('Europe/Andorra');
    echo "<p>Data i hora: " . date('d/m/Y h:i:s') . "</p>";

    if (isset($_SESSION['afegit'])) {
      if ($_SESSION['afegit']) echo "<p style='color:red'>L'Administrador ha estat modificat correctament</p>";
      else {
        echo "L'Administrador no ha estat modificat<br>";
        echo "Comprova si hi ha algún problema del sistema per poder modificar l'Administrador<br>";
      }

      unset($_SESSION['afegit']);
    }
    ?>
  </label>
</body>

</html>