<?php 

$erreur ="";
$error = "";

if (isset($_POST['ajouter']) AND isset($_SESSION['id'])) {

  $nom =tes(tes($_POST["categoie"]));
  $v = $_SESSION['id'];
  if (!empty($_POST['categoie'])) {
    $nomlength = strlen($nom);
    if ($nomlength <= 255) {
      $req = $db->prepare("INSERT INTO categorie (libelle, admin_id) VALUES(?, ?)");
      $req->execute(array($nom,$v));
      $error = "Votre compte a été bien créer";
      //header("Location:index.php?page=ca");
     // affichagecat();
    }else{
      $erreur = "Le nom de la catégorie ne doit pas dépassé 255 caractères !";
    }
  }else{
    $erreur = "Veuillez renseigner !";
  }
}

//Modifier une catégorie
if (isset($_POST['Modifier']) AND isset($_POST['id']) AND isset($_SESSION['id'])) {
  $id = $_POST['id'];
  $Nom = tes($_POST['Categoie']);
  $t=$_SESSION['id'];

  if (!empty($Nom) && !empty($t) && is_numeric($id)) {
    $requery = "update categorie set libelle='$Nom'where id=$id";
    $db->exec($requery);
  }
}
//Supprimé une catégorie
if (isset($_POST['delete']) AND isset($_SESSION['id'])) {
  $id = $_POST['id'];
  $t=$_SESSION['id'];

  if (!empty($t) && is_numeric($id)) {
    $requery = "DELETE FROM categorie WHERE id=$id";
    $db->exec($requery);
    $error ="Cette opération a été effectué avec succès";
  }
}

?>
<!-- sidebar-wrapper  -->
<main class="page-content main">
  <form>
    <div class="form-row align-items-center">
      <div class="col-sm-3 my-1">
        <input type="text" name="recherche" class="form-control" id="recherche" placeholder="Search for...">
      </div>
      <div class="col-auto my-1">
        <button type="submit" class="btn btn-outline-primary mr-2 align-bottom btn-sm mr-1">Recherche</button>
      </div>
      <div class="col-auto my-1">
        <button type="button" class="btn btn-outline-secondary mr-2 align-bottom btn-sm mr-1"data-toggle="modal" data-target="#ModalCenter"><i class='bx bxs-plus-circle bx-sm'></i>Add Catégorie</button>
      </div>
    </div>
  </form>
  <hr>
  <div class="container">
      <h1 align="center">La liste des catégories</h1>
    </div>
    <div class="table-responsive">
      <table class="table table-borderd table-hover table-stripped">
        <thead>
          <tr>
            <th class="w-25">ID</th>
            <th class="w-25">Nom</th>
            <th class="w-25">Adminitrateur</th>
            <th class="w-25">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $categoriesParge = 4;
            $categoriesTotalesReq = $db->query('SELECT * FROM categorie');
            $categoriesTotales = $categoriesTotalesReq->rowCount();
            $pagesTotales = ceil($categoriesTotales/$categoriesParge);

            if (isset($_GET['categorie']) AND !empty($_GET['categorie']) AND $_GET['categorie']>0 AND $_GET['categorie'] <= $categoriesTotales) {
              $_GET['categorie'] =intval($_GET['categorie']);
              $pageCourante = $_GET['categorie'];
            }else{
              $pageCourante = 1;
            }
            $depart = ($pageCourante-1)*$categoriesParge;
            $select = $db->prepare('
              SELECT categorie.id,categorie.libelle, admin.nom AS administrateur
              FROM categorie 
              LEFT JOIN admin 
              ON admin_id = admin.id 
              ORDER BY id ASC LIMIT '.$depart.','.$categoriesParge);
            $select->execute();
            while ($catégorie=$select->fetch(PDO::FETCH_OBJ)){
          ?>
          <tr id="categorie_<?=$catégorie->id?>">
            <td><?=$catégorie->id?></td>
            <td><?=$catégorie->libelle?></td>
            <td><?=$catégorie->administrateur?></td>
            <td>
              <a href='#catégorie_<?=$catégorie->id?>'data-toggle='modal' data-target='#delete<?=$catégorie->id?>'><i class='bx bxs-trash bx-border-circle bx-sm'></i></a>
              <a  href='#catégorie_<?=$catégorie->id?>'data-toggle='modal' data-target='#edit<?=$catégorie->id?>'><i class='bx bx-edit bx-border-circle bx-sm'></i></a>
                  <!--delete une catégorie-->
              <div class="modal fade" id="delete<?=$catégorie->id?>" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
    <div role="document" class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="ModalLongTitle" class="modal-title">
                  Etes vous sur de vouloir supprimer cette catégorie ...?
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
                <form action="" method="post">
                  <input type="number"name="id"class="form-control mb-4"placeholder="ex:1"value="<?=$catégorie->id?>">
                  <input type="text"name="Categoie"id="categoie"class="form-control mb-4"value="<?=$catégorie->libelle?>">
                  <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Annuler</button> 
                    <button type="submit" class="btn btn-warning" id="open"name="delete"><i class='bx bx-save'></i>Supprimé</button>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>

                <!--Modifier une catégorie-->
              <div class="modal fade" id="edit<?=$catégorie->id?>" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
    <div role="document" class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="ModalLongTitle" class="modal-title">
                  Modifier la catégorie
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
                <form action="" method="post">
                  <input type="number"name="id"class="form-control mb-4"placeholder="ex:1"value="<?=$catégorie->id?>">
                  <input type="text"name="Categoie"id="categoie"class="form-control mb-4"value="<?=$catégorie->libelle?>">
                  <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Annuler</button> 
                    <button type="submit" class="btn btn-warning" id="open"name="Modifier"><i class='bx bx-save'></i>Modifier</button>
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
        <li class="<?php if($pageCourante == '1'){echo "disabled";}?>"><a href="?page=categorie&categorie=<?php if($pageCourante != '1'){echo $pageCourante-1;}else{echo $pageCourante;}?>"style="border-radius: 50% !important;margin: 0 5px;">«</a></li>
          <?php
            for ($i=1; $i <=$pagesTotales ; $i++) {
              if ($i == $pageCourante) {
          ?>
        <li class="active"><a href="?page=categorie&categorie=<?=$i;?>"style="border-radius: 50% !important;margin: 0 5px;"><?=$i;?></a></li>
          <?php
            }else{
          ?>
          <li><a href="?page=categorie&categorie=<?=$i;?>"style="border-radius: 50% !important;margin: 0 5px;"><?=$i;?></a></li>
          <?php
        }
      } 
      ?>
  <li class="<?php if($pageCourante == $pagesTotales){echo "disabled";}?>"><a href="?page=categorie&categorie=<?php if($pageCourante != $pagesTotales){echo $pageCourante+1;}else{echo $pageCourante;}?>"style="border-radius: 50% !important;margin: 0 5px;">»</a></li>
  </ul>
</div>

<div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
    <div role="document" class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="ModalLongTitle" class="modal-title">
                  D'AJOUT D'UNE NOUVELLE CATEGORIE
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
                <form action="" method="post">
                  <p class="h4 mb-4">
                    Le formulaire d'ajout d'une catégorie
                  </p>
                  <input type="text"name="categoie"id="categoie"class="form-control mb-4"placeholder="ex:Cosmétique"value="<?php if (isset($nom)) { echo $nom;}?>">

                  <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Annuler</button> 
                    <button type="submit" class="btn btn-warning" id="open"name="ajouter"><i class='bx bx-save'></i>Ajouter</button>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>