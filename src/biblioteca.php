<?php
define('TEMPS_EXPIRACIO', 900);  # TEMPS D'EXPIRACIÓ DE LA SESSIÓ EN SEGONS (15').
define('TIMEOUT', 5);  # TEMPS DE VISUALITZACIÓ DEL MISSATGE INFORMATIU SOBRE LA CREACIÓ D'USUARIS

define('ADMIN', "2");
define('GESTOR', "1");
define('USR', "0");

define('FITXER_ADMINISTRADOR', "./usuaris/administrador");
define('FITXER_GESTORS', "./usuaris/gestors");
define('FITXER_CLIENTS', "./usuaris/clients");

define('DIRECTORI_COMANDA', "./comandes/");
define('DIRECTORI_CISTELLA', "./cistelles/");

function fLlegeixFitxer($nomFitxer)
{
	if ($fp = fopen($nomFitxer, "r")) {
		$midaFitxer = filesize($nomFitxer);

		// If the size of the file is greated than 0:
		if ($midaFitxer > 0) {
			$dades = explode(PHP_EOL, fread($fp, $midaFitxer));  // I read line by line.
			array_pop($dades); //La darrera línia, és una línia en blanc i s'ha d'eliminar de l'array
		} else {
			// If it's less than 0 (in producte.php), I create an array where I store the values.
			$dades = [];
		}


		fclose($fp);
	}

	return $dades;
}

function fLlegeixFitxerGenTaula($nomFitxer)
{
	if ($fp = fopen($nomFitxer, "r")) {
		$midaFitxer = filesize($nomFitxer);
		$dades = explode(PHP_EOL, fread($fp, $midaFitxer));
		array_pop($dades); // The last line is a blankspace that is genated when creating a new user.
		fclose($fp);
	}

	return $dades;
}

// Function that I use to check if I have the right user type (3 = admin) when I try to create a new manager or client.
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

// Function that I use to check if a manager is authentified (by name).
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

// Function that I use to check if a user is authentified (by name).
function fAutenticacioClient($nomUsuariComprova)
{
	$usuari_client = fLlegeixFitxer(FITXER_CLIENTS);

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

// Function to modify a manager.
// I NEED TO FINISH IT.
function fModificarGestor($id, $nomUsuari, $ctsnya, $nomComplet, $correu, $telefon, $tipus)
{
	preg_replace([$id, $nomUsuari, $ctsnya, $nomComplet, $correu, $telefon, $tipus], fRegistrarGestor($id, $nomUsuari, $ctsnya, $nomComplet, $correu, $telefon, $tipus), fLlegeixFitxer(FITXER_GESTORS));
}

// Function to delete a manger.
function fBorrarGestor($id)
{
	fLocalitzarUsuari($id);
}

// Function to register a new client.
function fRegistrarClient($id, $nomUsuari, $ctsnya, $nomComplet, $correu, $telefon, $adrecaPostal, $numeroVisa, $idGestorAssignat,  $tipus)
{
	$ctsnya_hash = password_hash($ctsnya, PASSWORD_DEFAULT);
	$dades_nou_client = $id . ":" . $nomUsuari . ":" . $ctsnya_hash . ":" . $nomComplet . ":" . $correu . ":" . $telefon . ":" . $adrecaPostal . ":" . $numeroVisa  . ":" . $idGestorAssignat . ":" . $tipus . "\n";

	if ($fp = fopen(FITXER_CLIENTS, "a")) {
		if (fwrite($fp, $dades_nou_client)) {
			$afegit = true;
		} else {
			$afegit = false;
		}

		fclose($fp);
	}

	// Create an empty file with the username of the client in DIRECTORI_COMANDA.
	if ($fp = fopen(DIRECTORI_COMANDA . $nomUsuari, "w")) {  // "DIRECTORI_COMANDA . $nomUsuari" is to create the name of the user in the directory.
		if (fwrite($fp, "")) {
			$afegit = true;
			fclose($fp);
		}
	}

	// Create an empty file with the username of the client in DIRECTORI_CISTELLA.
	if ($fp = fopen(DIRECTORI_CISTELLA . $nomUsuari, "w")) {
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
		$nom = $dadesUsuari[1];

		if ($id == $id_usuari_comprova) {
			echo "Modificant el gestor amb nom " . $nom .  " i ID equivalent a " . $id . ".";
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

// Function to show the clients from a specific manager.
function fVeureDadesPersonalsClient($nom_usuari, $llista)
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
		if ($nom_usuari == $nom) {
			echo "<tr><td>$id</td><td>$nom</td><td>$nom_complet</td><td>$correu_electronic</td><td>$telefon_contacte</td><td>$adreca_postal</td><td>$num_visa</td><td>$gestor_assignat</td><tr>";
		}
	}

	return 0;
}

// Function to create the cart fr the client.
function fCreaCistella($nomUsuari, $nomProducte)
{
	$nomFitxer = DIRECTORI_CISTELLA . $nomUsuari;
	$afegit = false;

	if ($fp = fopen($nomFitxer, "a")) {
		if (fwrite($fp, $nomProducte)) {
			$afegit = true;
			fclose($fp);
		}
	}
	return $afegit;
}
