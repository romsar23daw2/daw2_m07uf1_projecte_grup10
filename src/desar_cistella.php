<?php
require("./biblioteca.php");

session_start();
if (!isset($_SESSION['usuari'])) {
  header("Location: ./Errors/error_acces.php");
}
if (isset($_POST['resp'])) {
  if ((isset($_POST['resp'])) && ($_POST['resp'] == "y")) {
    if (!fCreaCistella($_SESSION['usuari'], $_SESSION['producte'])) {
      header("Location: ./Errors/logout_error_cistella.php");
    }
  }

  header("Location: ./menu.php"); // After sending the answer automatically send the user to menu.php.
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
    <form action="desar_cistella.php" method="POST">
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
</body>

</html>