<?php
define('TEMPS_EXPIRACIO', 900);  # TEMPS D'EXPIRACIÓ DE LA SESSIÓ EN SEGONS (15').
define('TIMEOUT', 5);  # TEMPS DE VISUALITZACIÓ DEL MISSATGE INFORMATIU SOBRE LA CREACIÓ D'USUARIS

define('ADMIN', "2");
define('GESTOR', "1");
define('USR', "0");

define('FITXER_ADMINISTRADOR', "./usuaris/administrador");
define('FITXER_GESTORS', "./usuaris/gestors");
define('FITXER_USUARIS', "./usuaris/usuaris");

define('DIRECTORI_COMANDES', "./comandes/");
define('DIRECTORI_CISTELLES', "./cistelles/");

function fLlegeixFitxer($nomFitxer)
{
	if ($fp = fopen($nomFitxer, "r")) {
		$midaFitxer = filesize($nomFitxer);
		$dades = explode(PHP_EOL, fread($fp, $midaFitxer));
		array_pop($dades); //La darrera línia, és una línia en blanc i s'ha d'eliminar de l'array
		fclose($fp);
	}

	return $dades;
}

// Function that I use to check if I have the right user type (3 = admin) when I try to create a new manager or client.
// MODIFY, now just works with admin.
function fAutoritzacio($nomUsuariComprova)
{
	$usuaris = fLlegeixFitxer(FITXER_ADMINISTRADOR);

	foreach ($usuaris as $usuari) {
		$dadesUsuari = explode(":", $usuari);
		$nomUsuari = $dadesUsuari[0];
		$tipusUsuari = $dadesUsuari[3];

		if (($nomUsuari == $nomUsuariComprova) && ($tipusUsuari == ADMIN)) {
			$autoritzat = true;
			break;
		} else  $autoritzat = false;
	}

	return  $autoritzat;  // Here I return the user type as well as if it's authorized.
}

// Function that I use to check if the admin user is authenticated.
function fAutenticacioAdmin($nomUsuariComprova)
{
	$usuaris = fLlegeixFitxer(FITXER_ADMINISTRADOR);

	foreach ($usuaris as $usuari) {
		$dadesUsuari = explode(":", $usuari);
		$nomUsuari = $dadesUsuari[0];  // The name is on the first index of the array.
		$ctsUsuari = $dadesUsuari[1];

		if (($nomUsuari == $nomUsuariComprova) && (password_verify($_POST['ctsnya'], $ctsUsuari))) {
			$autenticat = true;
			break;
		} else  $autenticat = false;
	}

	return $autenticat;
}

// Function that I use to check if a manager is authentified.
function fAutenticacioGestor($nomUsuariComprova)
{
	$usuari_gestor = fLlegeixFitxer(FITXER_GESTORS);

	foreach ($usuari_gestor as $usuari_g) {
		$dadesUsuari = explode(":", $usuari_g);
		$nomUsuari = $dadesUsuari[1]; // Here as I have an id before the name, the name is on the second index of the array.
		$ctsUsuari = $dadesUsuari[2];

		if (($nomUsuari == $nomUsuariComprova) && (password_verify($_POST['ctsnya'], $ctsUsuari))) {
			$autenticat = true;
			break;
		} else  $autenticat = false;
	}

	return $autenticat;
}

// Function that I use to check if a manager is authentified.
function fAutenticacioClient($nomUsuariComprova)
{
	$usuari_client = fLlegeixFitxer(FITXER_USUARIS);

	foreach ($usuari_client as $usuari_c) {
		$dadesUsuari = explode(":", $usuari_c);
		$nomUsuari = $dadesUsuari[1]; // Here as I have an id before the name, the name is on the second index of the array.
		$ctsUsuari = $dadesUsuari[2];

		if (($nomUsuari == $nomUsuariComprova) && (password_verify($_POST['ctsnya'], $ctsUsuari))) {
			$autenticat = true;
			break;
		} else  $autenticat = false;
	}

	return $autenticat;
}

// Function to modify the credentials from the admin.
function fModificacioDadesAdmin($nomUsuari, $ctsnya, $correu, $tipus)
{
	$ctsnya_hash = password_hash($ctsnya, PASSWORD_DEFAULT);
	$dades_administrador = $nomUsuari . ":" . $ctsnya_hash . ":" . $correu . ":"  . $tipus . "\n";

	if ($fp = fopen(FITXER_ADMINISTRADOR, "w")) {
		if (fwrite($fp, $dades_administrador)) {
			$afegit = true;
		} else {
			$afegit = false;
		}

		fclose($fp);
	} else {
		$afegit = false;
	}

	return $afegit;
}

// Function to register a new manager.
function fRegistrarGestor($id, $nomUsuari, $ctsnya, $nomComplet, $correu, $telefon, $tipus)
{
	$ctsnya_hash = password_hash($ctsnya, PASSWORD_DEFAULT);
	$dades_nou_gestor = $id . ":" . $nomUsuari . ":" . $ctsnya_hash . ":" . $nomComplet . ":" . $correu . ":" . $telefon . ":"  . $tipus . "\n";

	if ($fp = fopen(FITXER_GESTORS, "a")) {
		if (fwrite($fp, $dades_nou_gestor)) {
			$afegit = true;
		} else {
			$afegit = false;
		}

		fclose($fp);
	} else {
		$afegit = false;
	}

	return $afegit;
}

// Function to register a new client.
function fRegistrarClient($id, $nomUsuari, $ctsnya, $nomComplet, $correu, $telefon, $adrecaPostal, $numeroVisa, $idGestorAssignat,  $tipus)
{
	$ctsnya_hash = password_hash($ctsnya, PASSWORD_DEFAULT);
	$dades_nou_client = $id . ":" . $nomUsuari . ":" . $ctsnya_hash . ":" . $nomComplet . ":" . $correu . ":" . $telefon . ":" . $adrecaPostal . ":" . $numeroVisa  . ":" . $idGestorAssignat . ":" . $tipus . "\n";

	if ($fp = fopen(FITXER_USUARIS, "a")) {
		if (fwrite($fp, $dades_nou_client)) {
			$afegit = true;
		} else {
			$afegit = false;
		}

		fclose($fp);
	}

	if ($fp = fopen(DIRECTORI_COMANDES . $nomUsuari, "w")) {  // "DIRECTORI_COMANDES . $nomUsuari" is to create the name of the user in the directory.
		if (fwrite($fp, "")) {
			$afegit = true;
			fclose($fp);
		}
	}

	if ($fp = fopen(DIRECTORI_CISTELLES . $nomUsuari, "w")) {
		if (fwrite($fp, "")) {
			$afegit = true;
			fclose($fp);
		}
	} else {
		$afegit = false;
	}

	return $afegit;
}

// Function that I use to check the ID of a manager.
function fLocalitzarUsuari($id_usuari_comprova)
{
	$usuaris = fLlegeixFitxer(FITXER_GESTORS);

	foreach ($usuaris as $usuari) {
		$dadesUsuari = explode(":", $usuari);
		$id = $dadesUsuari[0];

		if ($id == $id_usuari_comprova) {
			return true;
		}
	}

	echo "El gestor amb id " . $id_usuari_comprova .  " no existeix.";
	return false;
}

// Function modify the credentials of a manager.
function fModificarGestor($id_usuari_comprova)
{
	$usuaris = fLlegeixFitxer(FITXER_GESTORS);

	foreach ($usuaris as $usuari) {
		$dadesUsuari = explode(":", $usuari);
		$id = $dadesUsuari[0];

		if ($id == $id_usuari_comprova) {
			return true;
		}
	}

	echo "El gestor amb id " . $id_usuari_comprova .  " no existeix.";
	return false;
}

// Function to create the table of the managers.
function fCreaTaulaGestors($llista)
{
	foreach ($llista as $entrada) {
		$dadesEntrada = explode(":", $entrada);
		$id = $dadesEntrada[0];
		$nom = $dadesEntrada[1];
		// $contrasenya = $dadesEntrada[2];
		$nom_complet = $dadesEntrada[3];
		$correu_electronic = $dadesEntrada[4];
		$telefon_contacte = $dadesEntrada[5];

		echo "<tr><td>$id</td><td>$nom</td><td>$nom_complet</td><td>$correu_electronic</td><td>$telefon_contacte</td><tr>";
	}

	return 0;
}

// Function to create the table of the clients.
function fCreaTaulaClients($llista)
{
	foreach ($llista as $entrada) {
		$dadesEntrada = explode(":", $entrada);
		$id = $dadesEntrada[0];
		$nom = $dadesEntrada[1];
		// $contrasenya = $dadesEntrada[2];
		$nom_complet = $dadesEntrada[3];
		$correu_electronic = $dadesEntrada[4];
		$telefon_contacte = $dadesEntrada[5];
		$adreca_postal = $dadesEntrada[6];
		$num_visa = $dadesEntrada[7];
		$gestor_assignat = $dadesEntrada[8];

		echo "<tr><td>$id</td><td>$nom</td><td>$nom_complet</td><td>$correu_electronic</td><td>$telefon_contacte</td><td>$adreca_postal</td><td>$num_visa</td><td>$gestor_assignat</td><tr>";
	}

	return 0;
}

// Function to show the clients from a specific manager.
function fCreaTaulaClientsPerGestor($nom_usuari, $llista)
{
	foreach ($llista as $entrada) {
		$dadesEntrada = explode(":", $entrada);
		$id = $dadesEntrada[0];
		$nom = $dadesEntrada[1];
		// $contrasenya = $dadesEntrada[2];
		$nom_complet = $dadesEntrada[3];
		$correu_electronic = $dadesEntrada[4];
		$telefon_contacte = $dadesEntrada[5];
		$adreca_postal = $dadesEntrada[6];
		$num_visa = $dadesEntrada[7];
		$gestor_assignat = $dadesEntrada[8];

		// Check if the name of the manager (I get it using the user session, not the ID) is the same as $gestor_assignat from the table:
		if ($nom_usuari == $gestor_assignat) {
			echo "<tr><td>$id</td><td>$nom</td><td>$nom_complet</td><td>$correu_electronic</td><td>$telefon_contacte</td><td>$adreca_postal</td><td>$num_visa</td><td>$gestor_assignat</td><tr>";
		}
	}

	return 0;
}
