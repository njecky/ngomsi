<?php 

$categories = afficategorie();

$erreur ="";
$error = "";


if (isset($_POST['ajouter'])) {
  $titre = tes(tes($_POST["titre"]));
  $description = tes(tes($_POST["description"]));
  $prix = tes(tes($_POST["prix"]));
  $quantite = tes(tes($_POST["quantite"]));
  $catego = tes(tes($_POST["categorie"]));

  if (!empty($_POST['titre']) AND !empty($_POST['description']) AND !empty($_POST['prix']) AND !empty($_POST['quantite']) AND !empty($_POST['categorie'])) {
    $titrelength = strlen($titre);
    if ($titrelength <= 255) {
      //Vérifier si l'email est unique dans la base de donnée
      $reqtitre = $db->prepare("SELECT * FROM produit WHERE titre = ?");
      $reqtitre->execute(array($titre));
      $titreexist = $reqtitre->rowCount();
      if ($titreexist == 0) {
        if (is_numeric($quantite)) {
          if (is_numeric($prix)) {
            // Pour la photo
            //$photos = $_FILES['photo']['name'];
            $photo_tmp = $_FILES['photo']['tmp_name'];
            if (!empty($photo_tmp)) {
            //La taille de l'image
              $taillemax = 3097152;
              if ($_FILES['photo']['size'] <= $taillemax) {
              //La gestion des extension d'image
                $ext = strtolower(substr(strrchr($_FILES['photo']['name'], '.'), 1));
                $extensionsValides = array('jpg','jpeg','gif','png');
                if (in_array($ext, $extensionsValides)) {
                  $chemin ="../assets/img/produit/".$titre.".".$ext;
                  $photo = move_uploaded_file($_FILES['photo']['tmp_name'], $chemin);
                  if ($photo) {
                    $req = $db->prepare("INSERT INTO produit (titre, description, prix, quantite, image, categorie_id) VALUES(?, ?, ?, ?, ?, ?)");
                    $req->execute(array($titre,$description,$prix,$quantite,$titre.$extensionUpload,$catego));
                    $error = "Un nouveau produit a été enregistré avec succès";
                  }
                }else{
                  $erreur = "Veillez rentrer une image ayant les extensions suivants : jpg, jpeg, gif, png";
                }
              }else{
                $erreur = "la photo du produit ne doit pas dépasser 3 Mo";
              }
            }else{
              $erreur ="Veuillez rentrer une image";
            }
          }else{
            $erreur = "Le prix du produit doit être un nomber ex:800";
          }
        }else{
          $erreur = "La quantité doit être un nombre";
        }
      }else{
        $erreur = "Veuillez changé le titre du produit car il éxiste déjà dans notre base de donnée  mercie !";
      }
    }else{
      $erreur = "Le titre du produit ne doit pas dépassé 255 caractères !";
    }
  }else{
    $erreur = "Veuillez remplir toute les renseignements !";
  }
}

?>

<!-- sidebar-wrapper  -->
<main class="page-content main">
  <form>
    <div class="form-row align-items-center">
      <div class="col-sm-3 my-1">
        <input type="text" name="" class="form-control" id="nom" placeholder="Search for...">
      </div>
      <div class="col-auto my-1">
        <button type="submit" class="btn btn-outline-primary mr-2 align-bottom btn-sm mr-1">Submit</button>
      </div>
      <div class="col-auto my-1">
        <button type="button" class="btn btn-outline-secondary mr-2 align-bottom btn-sm mr-1" data-toggle="modal" data-target="#ModalCenter" ><i class='bx bxs-plus-circle bx-sm'></i>Add Produit</button>
      </div>
      <div class="col-auto my-1">
        <button type="button" class="btn btn-outline-info mr-2 align-bottom btn-sm mr-1"><i class='bx bx-printer bx-sm'></i>Print</button>
      </div>
    </div>
  </form>
  <hr>
  <div class="container">
    <h1 align="center">La liste des produits</h1>
  </div>

  <div class="table-responsive">
    <table class="table table-hover table-sm">
      <thead>
        <tr>
          <th class="w-1">Id</th>
          <th class="w-1">Titre</th>
          <th class="w-1">Description</th>
          <th class="w-1">Prix(FCFA)</th>
          <th class="w-1">Quantité</th>
          <th class="w-1">Photo</th>
          <th class="w-1">Categorie</th>
          <th class="w-1">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $prodPage = 3;
        $produitsTotalesReq = $db->query("SELECT * FROM produit");
        $produitsTotales = $produitsTotalesReq->rowCount();
        $pagesTotales = ceil($produitsTotales/$prodPage);
        if (isset($_GET['produit']) AND !empty($_GET['produit']) AND $_GET['produit']>0 AND $_GET['produit'] <= $pagesTotales) {
            $_GET['produit'] =intval($_GET['produit']);
            $pageCourante = $_GET['produit'];
        }else{
            $pageCourante = 1;
        }
        $depart = ($pageCourante-1)*$prodPage;
        $select = $db->prepare('SELECT produit.id,produit.titre,produit.description,produit.prix,produit.quantite,produit.image, categorie.libelle
            AS categorie
              FROM produit
          LEFT JOIN categorie 
              ON categorie_id = categorie.id 
              ORDER BY id ASC LIMIT '.$depart.','.$prodPage);
        $select->execute();
        while ($produit = $select->fetch(PDO::FETCH_OBJ)){
      ?>
        <tr>
          <td><?=$produit->id?></td>
          <td><?=$produit->titre?></td>
          <td><?=$produit->description?></td>
          <td><?=$produit->prix?></td>
          <td><?=$produit->quantite?></td>
          <td><img src="../assets/img/produit/<?=$produit->titre?>" alt="<?=$produit->titre?>"width="90px" height="90px"/></td>
          <td><?=$produit->categorie?></td>
          <td>
            <a href="#"title="trash ou supprimé"><i class='bx bxs-trash bx-border-circle bx-sm'></i>Supprimmer</a>
            <a href="#produit_<?=$produit->id?>"data-toggle='modal' data-target='#edit<?=$produit->id?>'title="refresh ou édité"><i class='bx bx-edit bx-border-circle bx-sm'></i>Modifier</a>

             <!--Modifier une catégorie-->
              <div class="modal fade" id="edit<?=$produit->id?>" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
    <div role="document" class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="ModalLongTitle" class="modal-title">
                  Modifier les informations du produit
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
                  <input type="number"name="Id"class="form-control mb-4"placeholder="ex:1"value="<?=$produit->id?>">
                  <input type="text"name="Noms"id="Noms"class="form-control mb-4"value="<?=$produit->titre?>">
                  <input type="number" name="prix" id="prix" class="form-control mb-4"value="<?=$produit->prix?>"placeholder="Le prix du produit">
                  <input type="number" name="quantite" id="quantite" class="form-control mb-4"value="<?=$produit->quantite?>"placeholder="La quantité du produit">
                  <select id="categorie" name="categorie" class="form-control">
                      <option><?=$produit->categorie?></option>
                  </select><br>
                   <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text" for="message">Description</span>
                  </div>
                  <textarea class="form-control" type="text" name="description" aria-label="Description" id="description" placeholder="la description du produit"><?=$produit->description?></textarea>
                </div><br>
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
        <li class="<?php if($pageCourante == '1'){echo "disabled";}?>"><a href="?page=produit&produit=<?php if($pageCourante != '1'){echo $pageCourante-1;}else{echo $pageCourante;}?>"style="border-radius: 50% !important;margin: 0 5px;">«</a></li>
            <?php
              for ($i=1; $i <=$pagesTotales ; $i++) {
                if ($i == $pageCourante) {
            ?>
        <li class="active"><a href="?page=produit&produit=<?=$i;?>"style="border-radius: 50% !important;margin: 0 5px;"><?=$i;?></a></li>
              <?php
                }else{
              ?>
        <li><a href="?page=produit&produit=<?=$i;?>"style="border-radius: 50% !important;margin: 0 5px;"><?=$i;?></a></li>
              <?php
                }
            } 
              ?>
        <li class="<?php if($pageCourante == $pagesTotales){echo "disabled";}?>"><a href="?page=produit&produit=<?php if($pageCourante != $pagesTotales){echo $pageCourante+1;}else{echo $pageCourante;}?>"style="border-radius: 50% !important;margin: 0 5px;">»</a></li>
      </ul>
    </div>
</main>
<!--AJouter un client dans la base de donnée -->
<div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
    <div role="document" class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="ModalLongTitle" class="modal-title">
                    NOUVEAU PRODUIT
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
                    <p class="h4 mb-4">
                    Le formulaire d'ajout d'un produit
                  </p>
                  <input type="text" name="titre" id="titre" class="form-control mb-4" placeholder="Le titre du produit">
                  <input type="number" name="prix" id="prix" class="form-control mb-4" placeholder="Le prix du produit">
                  <input type="number" name="quantite" id="quantite" class="form-control mb-4" placeholder="La quantité du produit">
                  <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text" for="message">Description</span>
                  </div>
                  <textarea class="form-control" type="text" name="description" aria-label="Description" id="description" placeholder="la description du produit"></textarea>
                </div>
              </div>
              <select id="categorie" name="categorie" class="form-control">
                <option selected>Selectionner une Catégorie...</option>
                <?php 
                                foreach($categories as $membre)
                                {
                                    echo '<option value="'.$membre["id"].'">'.$membre["libelle"].'</option>';
                                }
                            ?>
              </select><br>
            <input type="file" class="form-control form-control-user"name="photo" readonly/>
                  <div class="modal-footer">
                    <button type="reset" class="btn btn-light" data-dismiss="modal">Annuler</button> 
                    <button type="submit" class="btn btn-warning" id="open"name="ajouter"><i class='bx bx-save'></i>Ajouter</button>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>