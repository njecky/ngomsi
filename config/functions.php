<?php

/**
 * nav_item
 *
 * @param  mixed $lien
 * @param  mixed $titre
 * @return string
 */
function nav_item(string $lien, string $titre):string{
    $classe = 'nav-item';
    if ($_SERVER['SCRIPT_NAME'] === $lien){
      $classe .=' active';
    }
    return <<<HTML
    <li class="$classe">
      <a class="nav-link" href="$lien">$titre</a>
    </li>
  HTML;
  }
  
  /**
   * nav_menu
   *
   * @param  mixed $linkClass
   * @return string
   */
  function nav_menu(string $linkClass =''): string {
    return
    nav_item('index.php?page=home', 'Accueil', $linkClass).
    nav_item('index.php?page=contact', 'Contact', $linkClass).
    nav_item('index.php?page=sing', 'Nos Produits', $linkClass);    
  }
   
   /**
    * tes
    *
    * @param  mixed $data
    * @return void
    */
   function tes($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * debug
 *
 * @param  mixed $variable
 * @return void
 */
function debug($variable){
  echo '<pre>' .print_r($variable, true) . '</pre>';
}

/**
 * is_admin
 *
 * @param  mixed $email
 * @param  mixed $password
 * @return void
 */
function is_admin($email,$password){
  global $db;
  $a = [
        'email'     =>    $email,
        'password'  =>    sha1($password)
    ];
    //créer la requête sql
    $sql = "SELECT * FROM admin WHERE email = :email AND password = :password";
    $req = $db->prepare($sql);
    $req->execute($a);
    $exist =$req->rowCount($sql);
    return $exist;
}

function is_client($email,$password){
  global $db;
  $a = [
        'email'     =>    $email,
        'password'  =>    sha1($password)
    ];
    //créer la requête sql
    $sql = "SELECT * FROM client WHERE email = :email AND password = :password";
    $req = $db->prepare($sql);
    $req->execute($a);
    $exist =$req->rowCount($sql);
    return $exist;
}

//Permet de vérifier si le client est connecté
function vérifierclient(){
  if (isset($_SESSION['id'])) {
    header("Location:index.php?page=dashboard");
  }
}


function inTable($table){
  global $db;
  $query = $db->query("SELECT COUNT(id) FROM $table");
  return $nombre = $query->fetch();
}

// Function de recherche
function recherche(){
  global $db;
  $req = $db->query("SELECT * FROM client WHERE nom LIKE '%q%' ORDER BY id ASC");
    $result = [];
    while ($rows = $req->fetchObject()){
        $result[] = $rows;
    }
    return $result;
}
function afficategorie(){
  global $db;
  $query = "SELECT * FROM categorie ORDER BY id ASC";
  $stmt = $db->query($query);
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $rows;
}

function detail(){
  global $db;
  $req =$db->query("
    SELECT produit.id,
            produit.titre,
            produit.description,
            produit.prix,
            produit.quantite,
            produit.image,
            categorie.libelle
    FROM produit
    JOIN categorie
    ON produit.categorie_id = categorie.id
    WHERE produit.id='{$_GET['id']}';
    ");
  $result = $req->fetchObject();
  return $result;
}

function comment($nom,$email,$message){

    global $db;

    $v = array(
        'nom'      => $nom,
        'email'     => $email,
        'comment'   => $message,
        'produit_id'   => $_GET["id"]
    );
    $sql = "INSERT INTO commentaire(nom, email, comment, produit_id, date) VALUES(:nom, :email, :comment, :produit_id, NOW())";
    $req = $db->prepare($sql);
    $req->execute($v);
}

function getcomment(){
    global $db;
    $req = $db->query("SELECT * FROM commentaire WHERE produit_id = '{$_GET['id']}' ORDER BY date DESC");
    $results = [];
    while($rows = $req->fetchObject()){
        $results[] = $rows;
    }

    return $results;
}

function getcomments(){
    global $db;
    $req = $db->query("
      SELECT commentaire.id,
            commentaire.nom,
            commentaire.email,
            commentaire.date,
            commentaire.produit_id,
            commentaire.comment,
            produit.titre
      FROM commentaire
      JOIN produit
      ON commentaire.produit_id = produit.id
      WHERE commentaire.seen = '0'
      ORDER BY commentaire.date ASC");
    $results = [];
    while($rows = $req->fetchObject()){
        $results[] = $rows;
    }

    return $results;
}

function affichéadministrateur(){
  global $db;
    $req = $db->query("SELECT * FROM admin ORDER BY id ASC");
    $results = [];
    while($rows = $req->fetchObject()){
        $results[] = $rows;
    }

  return $results;
}

function affichéadministrateurspécifique(){
  global $db;
  $req = $db->query("SELECT * FROM admin ORDER BY id ASC LIMIT 1");
  $results = [];
  while($rows = $req->fetchObject()){
    $results[] = $rows;
  }
  return $results;
}

/**
 * avatar
 *
 * @param  mixed $id
 * @return void
 */
function avatar($id){
  global $db;
  $avatar = $db->prepare("SELECT avatar FROM client WHERE id = ?");
  $avatar->execute(array($id));
  $avatar = $avatar->fetch();
  $avatar = $avatar['avatar'];
  return $avatar;
}

/**
 * price
 *
 * @param  mixed $number
 * @param  mixed $sigle
 * @return void
 */
function price(float $number, string $sigle = "FCFA"){
  return number_format($number, 0, '', ' '). ' '.$sigle;
}