<?php
// Now I declare a class that has the properties of a use, in order to use
class Usuari
{
  public function __construct(public $nomUsuari, public $ctsnya, public $correu)
  {
    $this->nomUsuari = $nomUsuari;
    $this->ctsnya = $ctsnya;
    $this->correu = $correu;;
  }
}

// Class that defines the properties that an object of a manager could have, extends the class Usuari.
class Admin extends Usuari
{
  // Here I declare the attributes that I'll use, here are some that are missing, but is because I get them from Usuari, such as $nomUsuari, ctsnya and $correu, which are on the constructor.

  private $tipus;

  // Here I define the constructor.
  public function __construct($nomUsuari, $ctsnya, $correu, $tipus)
  {
    $this->nomUsuari = $nomUsuari;
    $this->ctsnya = $ctsnya;
    $this->correu = $correu;
    $this->tipus = $tipus;
  }

  // Method to modify the credentials from the admin.
  public function fModificacioDadesAdmin($noves_dades_admin)
  {
    $ctsnya_hash = password_hash($this->ctsnya, PASSWORD_DEFAULT);
    $noves_dades_admin = $this->nomUsuari . ":" . $ctsnya_hash . ":" . $this->correu . ":"  . $this->tipus . "\n";

    if ($fp = fopen(FITXER_ADMINISTRADOR, "w")) {
      if (fwrite($fp, $noves_dades_admin)) {
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
}

// Class that defines the properties that an object of a manager could have, extends the class Usuari.
class Gestor extends Usuari
{
  // Here I declare the attributes that I'll use, here are some that are missing, but is because I get them from Usuari, such as $nomUsuari, ctsnya and $correu, which are on the constructor.
  private $id;
  private $nomComplet;
  private $telefon;
  private $tipus;

  // Here I define the constructor.
  public function __construct($id, $nomUsuari, $ctsnya, $nomComplet, $correu, $telefon, $tipus)
  {
    $this->id = $id;
    $this->nomUsuari = $nomUsuari;
    $this->ctsnya = $ctsnya;
    $this->nomComplet = $nomComplet;
    $this->correu = $correu;
    $this->telefon = $telefon;
    $this->tipus = $tipus;
  }

  // Method to register a new manager.
  public function fRegistrarGestor($dades_nou_gestor)
  {
    $ctsnya_hash = password_hash($this->ctsnya, PASSWORD_DEFAULT);
    $dades_nou_gestor = $this->id . ":" . $this->nomUsuari . ":" . $ctsnya_hash . ":" . $this->nomComplet . ":" . $this->correu . ":" . $this->telefon . ":" . $this->tipus . "\n";

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

  // Method to modify a manager.
  function fModificarGestor($id_usuari_comprova, $noves_dades_gestor)
  {
    $usuaris = fLlegeixFitxer(FITXER_GESTORS);

    // Here I must use &$usuari, as a pointer because I need to modify it later.
    foreach ($usuaris as &$usuari) {
      $noves_dades_gestor = explode(":", $usuari);
      $this->id = $noves_dades_gestor[0];

      if ($this->id == $id_usuari_comprova) {
        $noves_dades_gestor[0] = $this->id;
        $noves_dades_gestor[1] = $this->nomUsuari;
        $noves_dades_gestor[2] = password_hash($this->ctsnya, PASSWORD_DEFAULT);
        $noves_dades_gestor[3] = $this->nomComplet;
        $noves_dades_gestor[4] = $this->correu;
        $noves_dades_gestor[5] = $this->telefon;
        $noves_dades_gestor[6] = $this->tipus;

        $usuari = implode(":", $noves_dades_gestor);
        // Here I declare a variable that stores each line from the usuaris, it has a \n at the ending in order to have an enpty line at the bottom.
        $linies_actualitzades = implode("\n", $usuaris) . "\n";

        if (file_put_contents(FITXER_GESTORS, $linies_actualitzades) !== false) {
          return true;
        } else {
          echo "Ha ocorregut un error escrivint al fitxer de gestors.";
          return false;
        }
      }
    }

    return false;
  }
}

// Class that defines the properties that an object of a manager could have, extends the class Usuari.
class Client extends Usuari
{
  // Here I declare the attributes that I'll use, here are some that are missing, but is because I get them from Usuari, such as $nomUsuari, ctsnya and $correun, which are on the constructor.
  private $id;
  private $nomComplet;
  private $telefon;
  private $adrecaPostal;
  private $numeroVisa;
  private $nomGestorAssignat;
  private $tipus;

  // Here I define the constructor.
  public function __construct($id, $nomUsuari, $ctsnya, $nomComplet, $correu, $telefon, $adrecaPostal, $numeroVisa, $nomGestorAssignat, $tipus)
  {
    $this->id = $id;
    $this->nomUsuari = $nomUsuari;
    $this->ctsnya = $ctsnya;
    $this->nomComplet = $nomComplet;
    $this->correu = $correu;
    $this->telefon = $telefon;
    $this->adrecaPostal = $adrecaPostal;
    $this->numeroVisa = $numeroVisa;
    $this->nomGestorAssignat = $nomGestorAssignat;
    $this->tipus = $tipus;
  }

  // Method to register a new client.
  public function fRegistrarClient($dades_nou_client)
  {
    $ctsnya_hash = password_hash($this->ctsnya, PASSWORD_DEFAULT);
    $dades_nou_client = $this->id . ":" . $this->nomUsuari . ":" . $ctsnya_hash . ":" . $this->nomComplet . ":" . $this->correu . ":" . $this->telefon . ":" . $this->adrecaPostal . ":" . $this->numeroVisa . ":" . $this->nomGestorAssignat . ":" . $this->tipus . "\n";

    if ($fp = fopen(FITXER_CLIENTS, "a")) {
      if (fwrite($fp, $dades_nou_client)) {
        $afegit = true;
      } else {
        $afegit = false;
      }

      fclose($fp);
    }

    // Create an empty file with the username of the client in DIRECTORI_COMANDA.
    if ($fp = fopen(DIRECTORI_COMANDA . $this->nomUsuari, "w")) { // "DIRECTORI_COMANDA . $nomUsuari" is to create the name of the user in the directory.
      if (fwrite($fp, "")) {
        $afegit = true;
        fclose($fp);
      }
    }

    // Create an empty file with the username of the client in DIRECTORI_CISTELLA.
    if ($fp = fopen(DIRECTORI_CISTELLA . $this->nomUsuari, "w")) {
      if (fwrite($fp, "")) {
        $afegit = true;
        fclose($fp);
      }
    } else {
      $afegit = false;
    }

    return $afegit;
  }

  // Method to modify a client.
  function fModificarClient($id_usuari_comprova, $noves_dades_gestor)
  {
    $usuaris = fLlegeixFitxer(FITXER_CLIENTS);

    // Here I must use &$usuari, as a pointer because I need to modify it later.
    foreach ($usuaris as &$usuari) {
      $noves_dades_gestor = explode(":", $usuari);
      $this->id = $noves_dades_gestor[0];

      if ($this->id == $id_usuari_comprova) {
        $noves_dades_gestor[0] = $this->id;
        $noves_dades_gestor[1] = $this->nomUsuari;
        $noves_dades_gestor[2] = password_hash($this->ctsnya, PASSWORD_DEFAULT);
        $noves_dades_gestor[3] = $this->nomComplet;
        $noves_dades_gestor[4] = $this->correu;
        $noves_dades_gestor[5] = $this->telefon;
        $noves_dades_gestor[6] = $this->adrecaPostal;
        $noves_dades_gestor[7] = $this->telefon;
        $noves_dades_gestor[8] = $this->adrecaPostal;
        $noves_dades_gestor[9] = $this->tipus;

        $usuari = implode(":", $noves_dades_gestor);
        // Here I declare a variable that stores each line from the usuaris, it has a \n at the ending in order to have an enpty line at the bottom.
        $linies_actualitzades = implode("\n", $usuaris) . "\n";

        if (file_put_contents(FITXER_CLIENTS, $linies_actualitzades) !== false) {
          return true;
        } else {
          echo "Ha ocorregut un error escrivint al fitxer de clients.";
          return false;
        }
      }
    }

    return false;
  }
}
