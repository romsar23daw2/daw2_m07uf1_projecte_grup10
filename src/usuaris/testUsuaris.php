<?php
function fTipusUsuari($nomFitxer)
{
  $ultim_caracter = [];

  if ($fp = fopen($nomFitxer, "r")) {
    while (($linia = fgets($fp)) !== false) {
      $llargaria = strlen($linia);
      $ultim_caracter[] = ($llargaria > 1) ? $linia[$llargaria - 2] : null;
    }

    fclose($fp);

    return $ultim_caracter;
  }
}

$nomFitxer = "./usuaris";
$total_usuaris = fTipusUsuari($nomFitxer);

$nCmptAdmin = 0;
$nCmptGestor = 0;
$nCmptUsuariNormal = 0;

foreach ($total_usuaris as $tipus_usuari) {
  if ($tipus_usuari == 2) {
    $nCmptAdmin++;
  } else if ($tipus_usuari == 1) {
    $nCmptGestor++;
  } else if ($tipus_usuari == 0) {
    $nCmptUsuariNormal++;
  }
}

echo "L'usuari administrador ha aparescut: " .  $nCmptAdmin . " cops. <br>";
echo "L'usuari gestor ha aparescut: " .  $nCmptGestor . " cops. <br>";
echo "L'usuari normal ha aparescut: " .  $nCmptUsuariNormal . " cops. <br>";
