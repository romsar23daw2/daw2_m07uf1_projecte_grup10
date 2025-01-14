<?php
define('TEMPS_EXPIRACIO', 900);  # TEMPS D'EXPIRACIÓ DE LA SESSIÓ EN SEGONS (15').
define('TIMEOUT', 5);  # TEMPS DE VISUALITZACIÓ DEL MISSATGE INFORMATIU SOBRE LA CREACIÓ D'USUARIS

define('ADMIN', "2");
define('GESTOR', "1");
define('CLIENT', "0");

define('FITXER_ADMINISTRADOR', "./usuaris/administrador.txt");
define('FITXER_GESTORS', "./usuaris/gestors.txt");
define('FITXER_CLIENTS', "./usuaris/clients.txt");
define('FITXER_PRODUCTES', "./productes/productes.txt");

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
		$idUsuari = $dadesUsuari[0];  // Agrega esta línea para obtener el ID del cliente
		$nomUsuari = $dadesUsuari[1]; // Aquí obtengo el nombre de usuario.
		$ctsUsuari = $dadesUsuari[2];

		if (($nomUsuari == $nomUsuariComprova) && (password_verify($_POST['ctsnya'], $ctsUsuari))) {
			$autenticat = true;

			// Aquí establezco $_SESSION['id_cliente'] con el ID del cliente autenticado
			$_SESSION['id_cliente'] = $idUsuari;

			break;
		} else  $autenticat = false;
	}

	return $autenticat;
}


// Function that I use to check the ID of a manager.
function fLocalitzarGestor($id_usuari_comprova)
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

	// echo "El gestor amb id " . $id_usuari_comprova[$valor] .  " no existeix.";
	echo "El gestor amb id " . $id_usuari_comprova .  " no existeix.";
	return false;
}

// Function that I use to check the ID of a client.
function fLocalitzarClient($id_usuari_comprova)
{
	$usuaris = fLlegeixFitxer(FITXER_CLIENTS);

	foreach ($usuaris as $usuari) {
		$dadesUsuari = explode(":", $usuari);
		$id = $dadesUsuari[0];
		$nom = $dadesUsuari[1];

		if ($id == $id_usuari_comprova) {
			echo "Modificant el client amb nom " . $nom .  " i ID equivalent a " . $id . ".";
			return true;
		}
	}

	echo "El client amb id " . $id_usuari_comprova .  " no existeix.";
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

// Function to create the cart for the client.
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

function fGenerarLlistaProductes($llista)
{
	foreach ($llista as $entrada) {
		$dadesEntrada = explode(":", $entrada);
		$nom_producte = $dadesEntrada[0];
		$id_producte = $dadesEntrada[1];
		$preu_producte = $dadesEntrada[2];
		$iva_producte = $dadesEntrada[3];
		$disponibilitat_producte = $dadesEntrada[4];

		echo "<tr><td>$nom_producte</td><td>$id_producte</td><td>$preu_producte</td><td>$iva_producte</td><td>$disponibilitat_producte</td><tr>";
	}

	return 0;
}

// victor try it to finish
function fComprovarDisponibilitat($id_p, $llista)
{
	foreach ($llista as $entrada) {
		$dadesEntrada = explode(":", $entrada);
		$id_producte = $dadesEntrada[1];
		$disponibilitat_producte = $dadesEntrada[4];

		if ($id_p == $id_producte && trim($disponibilitat_producte) == 'Disponible') {
			return true;
		}
	}
	return false;
}

// Function I use to find a product.
function fLocalitzarProducte($id_producte)
{
	$productes = fLlegeixFitxer(FITXER_PRODUCTES);

	foreach ($productes as $producte) {
		$dadesProducte = explode(":", $producte);
		$nom = $dadesProducte[0];
		$id = $dadesProducte[1];

		if ($id == $id_producte) {
			echo "Modificant el producte amb nom " . $nom .  " i ID equivalent a " . $id . "." . "<br><br>";
			return true;
		}
	}

	echo "El producte amb id " . $id_producte .  " no existeix.";
	return false;
}

function fAconsegueixemail($id_usuari_comprova)
{
	$usuaris = fLlegeixFitxer(FITXER_GESTORS);

	foreach ($usuaris as $usuari) {
		$dadesUsuari = explode(":", $usuari);
		$id = $dadesUsuari[0];
		$email = $dadesUsuari[4];

		if ($id == $id_usuari_comprova) {
			echo "El correu del gestor és " . $email .  " i ID equivalent a " . $id . ".";
			return true;
		}
	}

	return false;
}

// Method to create a new product.
function fCrearProducte($nom_producte, $id_producte, $preu_producte, $iva_producte, $disponibilitat_producte)
{
	$dades_nou_producte = $nom_producte . ":" . $id_producte . ":" . $preu_producte . ":" . $iva_producte . ":" . $disponibilitat_producte . "\n";

	if ($fp = fopen(FITXER_PRODUCTES, "a")) {
		if (fwrite($fp, $dades_nou_producte)) {
			$creat = true;
		} else {
			$creat = false;
		}

		fclose($fp);
	} else {
		$creat = false;
	}

	return $creat;
}

// Function to modify a product.
function fModificarProducte($id_producte_comprova, $nom_producte, $id_producte, $preu_producte, $iva_producte, $disponibilitat_producte)
{
	$productes = fLlegeixFitxer(FITXER_PRODUCTES);

	// Here I must use &$producte, as a pointer because I need to modify it later.
	foreach ($productes as &$producte) {
		$dadesProducte = explode(":", $producte);
		$id = $dadesProducte[1];

		if ($id == $id_producte_comprova) {
			$dadesProducte[0] =  $nom_producte;
			$dadesProducte[1] = $id_producte;
			$dadesProducte[2] = $preu_producte;
			$dadesProducte[3] = $iva_producte;
			$dadesProducte[4] = $disponibilitat_producte;

			$producte = implode(":", $dadesProducte);
			// Here I declare a variable that stores each line from the usuaris, it has a \n at the ending in order to have an enpty line at the bottom.
			$linies_actualitzades = implode("\n", $productes) . "\n";

			if (file_put_contents(FITXER_PRODUCTES, $linies_actualitzades) !== false) {
				return true;
			} else {
				echo "Ha ocorregut un error escrivint al fitxer de productes.";
				return false;
			}
		}
	}

	return false;
}
