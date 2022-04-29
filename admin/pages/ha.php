<?php 

$erreur ="";
$error = "";

if (isset($_POST['ajouter']) AND isset($_SESSION['id'])) {

  $nom =tes(tes($_POST["nom"]));
  $site =tes(tes($_POST["site"]));
  $telephone =tes(tes($_POST["telephone"]));
  $v = $_SESSION['id'];
  if (!empty($_POST['nom']) AND !empty($_POST['site']) AND !empty($_POST['telephone'])) {
    $nomlength = strlen($nom);
    if ($nomlength <= 255) {
      //Vérifier si le titre est unique dans la base de donnée
      $reqtitre = $db->prepare("SELECT * FROM partenaire WHERE noms = ?");
      $reqtitre->execute(array($nom));
      $titexist = $reqtitre->rowCount();

      if ($titexist == 0) { 
      if (!filter_var($site, FILTER_VALIDATE_URL) === false) {
        if (!preg_match("/^\d\d(.)\d\d\\1\d\d\\1\d\d\\1\d\d$/", $telephone)) {
            if (isset($_FILES['photo']['tmp_name'])) {
              $taillemax = 6097152;
              $extensionsValides = array('jpg','jpeg','gif','png','tif','psd','pdf','eps','ai','indd','svg');
              if ($_FILES['photo']['size'] <= $taillemax) {
                $extensionUpload = strtolower(substr(strrchr($_FILES['photo']['name'], '.'), 1));
                if (in_array($extensionUpload, $extensionsValides)) {
                  $chemin ="../assets/img/partenaire/".$nom.".".$extensionUpload;
                  $resultat = move_uploaded_file($_FILES['photo']['tmp_name'], $chemin);
                  if ($resultat) {
                    $req = $db->prepare("INSERT INTO partenaire (noms, site, phone, photo, admin_id) VALUES(?, ?, ?, ?, ?)");
                    $req->execute(array($nom,$site,$telephone,$nom.$extensionUpload,$v));
                    $error = "Cette opération c'est passer avec succès";
                  }else{
                    $erreur = "Une erreur sait produit durant l'importation de la photo du partenaire";
                  }
                }else{
                  $erreur = "Veillez mettre la photo du partenaire et doit être aux formats jpg, jpeg, gif, png, tif, psd, pdf, eps, ai, indd ou svg";
                }
              }else{
                 $erreur = "la photo du partenaire ne doit pas dépasser 6 Mo";
              }
            }
        }else{
          $erreur = "Le numéro de téléphone n'est invalide";
        }
      }else{
        $erreur = "URL n'est pas valide";
      }
      }else{
        $erreur = "Veuillez changé le nom du partenaire car il éxiste déjà dans notre base de donnée !";
      }
    }else{
      $erreur = "Le nom de la catégorie ne doit pas dépassé 255 caractères !";
    }
  }else{
    $erreur = "Veuillez renseigner !";
  }
}
//Modifier un partenaire
if (isset($_POST['modifier_P'])) {
  if (isset($_SESSION['id'])) {
    $rquser = $db->prepare("SELECT * FROM partenaire WHERE id =?");
    $rquser->execute(array($_SESSION['id']));
    $user = $rquser->fetch();

    if (isset($_POST['Noms']) AND !empty($_POST['Noms']) AND $_POST['Noms'] != $user['noms']) {
      $Id = $_POST['Id'];
      $Noms = tes($_POST['Noms']);
      if (isset($_POST['Id']) AND is_numeric($Id)) {
        $insertpseudo = $db->prepare("UPDATE partenaire SET noms = ? WHERE id = $Id");
        $insertpseudo->execute(array($Noms));
        $error = "ok";
      }

      if (isset($_POST['Site']) AND !empty($_POST['Site']) AND $_POST['Site'] != $user['site'])
      {
        $Id = $_POST['Id'];
        $Site = tes($_POST['Site']);
      if (isset($_POST['Id']) AND is_numeric($Id)) {
        $insertpseudo = $db->prepare("UPDATE partenaire SET site = ? WHERE id = $Id");
        $insertpseudo->execute(array($Site));
        $error = "ok";
      }
      }
      if (isset($_POST['Telephone']) AND !empty($_POST['Telephone']) AND $_POST['Telephone'] != $user['phone'])
      {
        $Id = $_POST['Id'];
        $Telephone = tes($_POST['Telephone']);
      if (isset($_POST['Id']) AND is_numeric($Id)) {
        $insertpseudo = $db->prepare("UPDATE partenaire SET phone = ? WHERE id = $Id");
        $insertpseudo->execute(array($Telephone));
        $error = "ok";
      }
      }
      if (isset($_FILES['Photo']) AND !empty($_FILES['Photo']['name'])) {
    $taillemax = 6097152;
    $extensionsValides = array('jpg','jpeg','gif','png','tif','psd','pdf','eps','ai','indd','svg');
    if ($_FILES['Photo']['size'] <= $taillemax) {
      $extensionUpload = strtolower(substr(strrchr($_FILES['Photo']['name'], '.'), 1));
      if (in_array($extensionUpload, $extensionsValides)) {
        $chemin ="../assets/img/partenaire/".$Noms.".".$extensionUpload;
        $resultat = move_uploaded_file($_FILES['Photo']['tmp_name'], $chemin);
        if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
          if ($resultat) {
          $updateavatar = $db->prepare("UPDATE partenaire SET photo = :photo WHERE id = :id");
          $updateavatar->execute(array(
            'photo' =>$Noms. ".".$extensionUpload,
            'id'=> $_SESSION['id']
          ));
          $error = "l'opération c'est passé avec succès²";
        }else{
          $msg = "Une erreur sait produit durant l'importation de la photo du partenaire";
        }
        }
      }else{
        $msg = "Veillez mettre la photo du partenaire et doit être aux formats jpg, jpeg, gif, png, tif, psd, pdf, eps, ai, indd ou svg";
      }
    }else{
      $msg = "Votre photo de profil ne doit pas dépasser 6 Mo";
    }
  }
    }

  }
}
//Supprimé une catégorie
if (isset($_POST['delete']) AND isset($_SESSION['id'])) {
  $id = $_POST['Ids'];
  $t=$_SESSION['id'];

  if (!empty($t) && is_numeric($id)) {
    $requery = "DELETE FROM partenaire WHERE id=$id";
    $db->exec($requery);
    $error ="Cette opération a été effectué avec succès";
  }
}

?>
<!-- sidebar-wrapper  -->
<main class="page-content main">
  <form method="post" action="#"enctype="multipart/form-data">
    <div class="form-row align-items-center">
      <div class="col-sm-3 my-1">
        <label class="sr-only" for="recherche"></label>
        <input type="text" name="" class="form-control" id="recherche" placeholder="Search for...">
      </div>
      <div class="col-auto my-1">
        <button type="submit" class="btn btn-outline-primary mr-2 align-bottom btn-sm mr-1">Submit</button>
      </div>
      <div class="col-auto my-1">
        <button type="button" class="btn btn-outline-secondary mr-2 align-bottom btn-sm mr-1" data-toggle="modal" data-target="#ModalCenter"><i class='bx bxs-plus-circle bx-sm'></i>Add partenaire</button>
      </div>
      <div class="col-auto my-1">
        <button type="button" class="btn btn-outline-info mr-2 align-bottom btn-sm mr-1"><i class='bx bx-printer bx-sm'></i>Print</button>
      </div>
    </div>
  </form>
  <hr>
  <div class="container">
    <h1 align="center">La liste des patenaires</h1>
  </div>

  <div class="table-responsive">
    <table class="table table-hover table-sm">
      <thead>
        <tr>
          <th class="w-1">Id</th>
          <th class="w-1">Nom</th>
          <th class="w-1">Site</th>
          <th class="w-1">Téléphone</th>
          <th class="w-1">Administrateur</th>
          <th class="w-1">Photo</th>
          <th class="w-1">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
            $partenairesParge = 3;
            $partenairesTotalesReq = $db->query('SELECT id FROM partenaire');
            $partenairesTotales = $partenairesTotalesReq->rowCount();
            $pagesTotales = ceil($partenairesTotales/$partenairesParge);

        if (isset($_GET['ha']) AND !empty($_GET['ha']) AND $_GET['ha']>0 AND $_GET['ha'] <= $partenairesTotales) {
            $_GET['ha'] =intval($_GET['ha']);
            $pageCourante = $_GET['ha'];
        }else{
            $pageCourante = 1;
        }
        $depart = ($pageCourante-1)*$partenairesParge;
            $select = $db->prepare('SELECT partenaire.id,partenaire.noms,partenaire.site,partenaire.phone,partenaire.photo, admin.nom AS administrateur
              FROM partenaire 
              LEFT JOIN admin 
              ON admin_id = admin.id 
              ORDER BY id ASC LIMIT '.$depart.','.$partenairesParge);
            $select->execute();
            while ($partenaire=$select->fetch(PDO::FETCH_OBJ)){
        ?>
        <tr id="partenaire<?= $partenaire->id?>">
          <td><?=$partenaire->id?></td>
          <td><?=$partenaire->noms?></td>
          <td><?=$partenaire->site?></td>
          <td><?=$partenaire->phone?></td>
          <td><?=$partenaire->administrateur?></td>
          <td><img src="../assets/img/partenaire/<?=$partenaire->noms?>" alt="<?=$partenaire->noms?>"width="90px" height="90px"/></td>
          <td>
            <a href="#partenaire_<?=$partenaire->id?>"data-toggle='modal' data-target='#delete<?=$partenaire->id?>'><i class='bx bxs-trash bx-border-circle bx-sm'></i></a>
            <a href="#partenaire_<?=$partenaire->id?>"data-toggle='modal' data-target='#edit<?=$partenaire->id?>'><i class='bx bx-edit bx-border-circle bx-sm'></i></a>
            <!--delete un partenaire-->
              <div class="modal fade" id="delete<?=$partenaire->id?>" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
    <div role="document" class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="ModalLongTitle" class="modal-title">
                   Etes vous sur de vouloir supprimer ce partenaier...?
                </h5>
                <button type="button" class="close" dat-dismiss="modal" aria-label="Close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <?php if ($erreur) : ?>
                <div class="alert alert-danger">
                  <?= $erreur ?> 
                </div>
              <?php endif ?>
              <?php if ($error) : ?>
                <div class="alert alert-success">
                  <?= $error ?>
                </div>
              <?php endif ?>
                <form action="" method="post"enctype="multipart/form-data">
                  <input type="number"name="Ids"class="form-control mb-4"placeholder="ex:1"value="<?=$partenaire->id?>">
                  <input type="text"name="Noms"id="Noms"class="form-control mb-4"value="<?=$partenaire->noms?>">
                  <input type="url"name="Site"id="Site"class="form-control mb-4"value="<?=$partenaire->site?>">
                  <input type="text"name="Telephone"id="Telephone"class="form-control mb-4"value="<?=$partenaire->phone?>">
                  <input type="file" class="form-control form-control-user"name="Photo" readonly/>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Annuler</button> 
                    <button type="submit" class="btn btn-warning" id="open"name="delete"><i class='bx bx-edit'></i>Supprimé</button>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>

                <!--Modifier une catégorie-->
              <div class="modal fade" id="edit<?=$partenaire->id?>" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
    <div role="document" class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="ModalLongTitle" class="modal-title">
                  Modifier les informations du partenaier
                </h5>
                <button type="button" class="close" dat-dismiss="modal" aria-label="Close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <?php if ($erreur) : ?>
                <div class="alert alert-danger">
                  <?= $erreur ?> 
                </div>
              <?php endif ?>
              <?php if ($error) : ?>
                <div class="alert alert-success">
                  <?= $error ?>
                </div>
              <?php endif ?>
                <form action="" method="post"enctype="multipart/form-data">
                  <input type="number"name="Id"class="form-control mb-4"placeholder="ex:1"value="<?=$partenaire->id?>">
                  <input type="text"name="Noms"id="Noms"class="form-control mb-4"value="<?=$partenaire->noms?>">
                  <input type="url"name="Site"id="Site"class="form-control mb-4"value="<?=$partenaire->site?>">
                  <input type="text"name="Telephone"id="Telephone"class="form-control mb-4"value="<?=$partenaire->phone?>">
                  <input type="file" class="form-control form-control-user"name="Photo" readonly/>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Annuler</button> 
                    <button type="submit" class="btn btn-warning" id="open"name="modifier_P"><i class='bx bx-edit'></i>Modifier</button>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>
          </td>
        </tr>
         <?php
      }
          ?>
      </tbody>
    </table>
  </div>
  <div class="container">
    <ul class="pagination justify-content-center" style="border-radius: 50% !important;margin: 0 5px;">
      <li class="<?php if($pageCourante == '1'){echo "disabled";}?>"><a href="?page=ha&ha=<?php if($pageCourante != '1'){echo $pageCourante-1;}else{echo $pageCourante;}?>"style="border-radius: 50% !important;margin: 0 5px;">«</a></li>
          <?php
          for ($i=1; $i <=$pagesTotales ; $i++) {
            if ($i == $pageCourante) {
              ?>
      <li class="active"><a href="?page=ha&ha=<?=$i;?>"style="border-radius: 50% !important;margin: 0 5px;"><?=$i;?></a></li>
          <?php
            }else{
          ?>
      <li><a href="?page=ha&ha=<?=$i;?>"style="border-radius: 50% !important;margin: 0 5px;"><?=$i;?></a></li>
      <?php
    }
  }
  ?>
      <li class="<?php if($pageCourante == $pagesTotales){echo "disabled";}?>"><a href="?page=ha&ha=<?php if($pageCourante != $pagesTotales){echo $pageCourante+1;}else{echo $pageCourante;}?>"style="border-radius: 50% !important;margin: 0 5px;">»</a></li>
    </ul>
  </div>
</main>


<div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
    <div role="document" class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="ModalLongTitle" class="modal-title">
                    NOUVEAU PARTENAIRE
                </h5>
                <button type="button" class="close" dat-dismiss="modal" aria-label="Close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <?php if ($erreur) : ?>
                <div class="alert alert-danger">
                  <?= $erreur ?> 
                </div>
              <?php endif ?>
              <?php if ($error) : ?>
                <div class="alert alert-success">
                  <?= $error ?>
                </div>
              <?php endif ?>
                <form action="#" method="post" enctype="multipart/form-data">
                  <p class="h4 mb-4">
                    Le formulaire d'ajout d'un partenaire
                  </p>
                  <input type="text" name="nom" id="nom" class="form-control mb-4" placeholder="ex:Njecky Félix Désiré">
                  <input type="url" name="site" id="site" class="form-control mb-4" placeholder="ex:w.w.w.google.com">
                  <input type="text" name="telephone" id="telephone" class="form-control mb-4" placeholder="ex:(+237)655779711">
                  <input type="file" class="form-control form-control-user"name="photo" readonly/>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Annuler</button> 
                    <button type="submit" class="btn btn-warning" id="open"name="ajouter"><i class='bx bx-save'></i>Ajouter</button>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>