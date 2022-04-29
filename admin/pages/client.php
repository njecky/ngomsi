<?php 

$erreur ="";
$error = "";

//Ajouter un client
if (isset($_POST['ajouter'])) {
  $nom = tes(tes($_POST["nom"]));
  $telephone = tes(tes($_POST["telephone"]));
  $email = tes(tes($_POST["email"]));
  $Email = tes(tes($_POST["Email"]));
  $password = sha1(tes($_POST["password"]));
  $Password = sha1(tes($_POST["Password"]));
  $sexe = tes(tes($_POST["sexe"]));
  if (!empty($_POST['nom']) AND !empty($_POST['telephone']) AND !empty($_POST['email']) AND !empty($_POST['Email']) AND !empty($_POST['Password']) AND !empty($_POST['password']) AND !empty($_POST['sexe'])) {
    $nomlength = strlen($nom);
    $sexelength = strlen($sexe);

    if ($nomlength <= 255) {
      if (!preg_match("/^\d\d(.)\d\d\\1\d\d\\1\d\d\\1\d\d$/", $telephone)) {
        if ($sexelength <= 8) {
          if ($email == $Email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
              //Vérifier si l'email est unique dans la base de donnée
              $reqmail = $db->prepare("SELECT * FROM client WHERE email = ?");
              $reqmail->execute(array($email));
              $mailexist = $reqmail->rowCount();
              if ($mailexist == 0) {
                if ($password == $Password) {
                  $insertmbr = $db->prepare("INSERT INTO client(nom, telephone, sexe, email, password, avatar) VALUES(?, ?, ?, ?, ?, ?)");
                  $insertmbr->execute(array($nom, $telephone,$sexe, $email, $password, "avatar-10.png"));
                  $error = "Votre opération c'est passer avec succès";
                }else{
                  $erreur = "Vos mots de passes ne correspondent pas !";
                }
              }else{
                $erreur = "Veuillez changé d'adresse email car il éxiste déjà dans notre base de donnée !";
              }
            }else{
              $erreur = "Votre adresse email n'est pas valide !";
            }
          }else{
            $erreur = "Vos adresses email ne correspondent pas !";
          }
        }else{
          $erreur ="Votre sexe ne doit pas dépassé 8 caractères !";
        }
      }else{
        $erreur = "Le numéro de téléphone n'est invalide";
      }
    }else{
      $erreur = "Le nom de la catégorie ne doit pas dépassé 255 caractères !";
    }
  }else{
    $erreur = "Veuillez remplir toute les renseignements !";
  }
}
//Modifier un client
if (isset($_POST['Modifier'])) {
  if (isset($_SESSION['id'])) {
  $rquser = $db->prepare("SELECT * FROM client WHERE id =?");
  $rquser->execute(array($_SESSION['id']));
  $user = $rquser->fetch();

  if (isset($_POST['Nom']) AND !empty($_POST['Nom']) AND $_POST['Nom'] != $user['nom']) {
    $Id = $_POST['id'];
    $nom = tes($_POST['Nom']);
    if (isset($_POST['id']) AND is_numeric($Id)) {
      $insertpseudo = $db->prepare("UPDATE client SET nom = ? WHERE id = $Id");
      $insertpseudo->execute(array($nom));
      $error = "ok";
    }
  }

  if (isset($_POST['Email']) AND !empty($_POST['Email']) AND $_POST['Email'] != $user['email'])
  {
    $Id = $_POST['id'];
    $email = tes($_POST['Email']);
    if (isset($_POST['id']) AND is_numeric($Id)) {
      $insertmail = $db->prepare("UPDATE client SET email = ? WHERE id = $Id");
      $insertmail->execute(array($email));
      $error = "ok";
    }
  }
  }
}

//Supprimé un client
if (isset($_POST['delete'])) {
  $id = $_POST['IdS'];
  if (!empty($id) && is_numeric($id)) {
    $requery = "DELETE FROM client WHERE id=$id";
    $db->exec($requery);
    $error ="Cette opération a été effectué avec succès";
  }
}
?>
<!-- sidebar-wrapper  -->
<main class="page-content main">
  <form method="get" action="#">
    <div class="form-row align-items-center">
      <div class="col-sm-3 my-1">
        <label class="sr-only" for="recherche">Recherche</label>
        <input type="search" name="q" class="form-control" id="recherche" placeholder="Search for...">
      </div>
      <div class="col-auto my-1">
        <button type="submit"class="btn btn-outline-primary mr-2 align-bottom btn-sm mr-1">Submit</button>
      </div>
      <div class="col-auto my-1">
        <button type="button" class="btn btn-outline-secondary mr-2 align-bottom btn-sm mr-1" data-toggle="modal" data-target="#ModalCenter"><i class='bx bxs-plus-circle bx-sm'></i>Add Client</button>
      </div>
      <div class="col-auto my-1">
        <button type="button" class="btn btn-outline-info mr-2 align-bottom btn-sm mr-1"><i class='bx bx-printer bx-sm'></i>Print</button>
      </div>
    </div>
  </form>
  <hr>
  <div class="container">
      <h1 align="center">La liste des clients</h1>
    </div>
  <div class="table-responsive">
    <table class="table table-hover table-sm">
      <thead>
        <tr>
          <th class="w-24">Id</th>
          <th class="w-24">Nom</th>
          <th class="w-24">Téléphone</th>
          <th class="w-24">Sexe</th>
          <th class="w-24">Email</th>
          <th class="w-24">Photo</th>
          <th class="w-24">Action</th>
        </tr>
      </thead>
      <tbody>
         <?php
          $clientsParge = 3;
          $clientsTotalesReq = $db->query('SELECT id FROM client');
          $clientsTotales = $clientsTotalesReq->rowCount();
          $pagesTotales = ceil($clientsTotales/$clientsParge);

        if (isset($_GET['client']) AND !empty($_GET['client']) AND $_GET['client']>0 AND $_GET['client'] <= $clientsTotales) {
            $_GET['client'] =intval($_GET['client']);
            $pageCourante = $_GET['client'];
        }else{
            $pageCourante = 1;
        }

        $depart = ($pageCourante-1)*$clientsParge;
        $select = $db->prepare('SELECT * FROM client ORDER BY id ASC LIMIT '.$depart.','.$clientsParge);
        $select->execute();
        while ($client=$select->fetch(PDO::FETCH_OBJ)){
        ?>
        <tr id="client_<?= $client->id?>">
          <td><?=$client->id?></td>
          <td><?=$client->nom?></td>
          <td><?=$client->telephone?></td>
          <td><?=$client->sexe?></td>
          <td><?=$client->email?></td>
          <td>
            <img src="../assets/img/client/<?=$client->id?>" alt="<?=$client->nom?>"width="100px" height="100px"/>
          </td>
          <td>
            <a href="#client_<?=$client->id?>"data-toggle="modal" data-target="#delete<?=$client->id?>"><i class='bx bxs-trash bx-border-circle bx-sm'></i></a>
            <a href="#client_<?=$client->id?>"data-toggle="modal" data-target="#edit<?=$client->id?>"><i class='bx bx-edit bx-border-circle bx-sm'></i></a>
            <!--Modifier un client-->
            <div class="modal fade" id="edit<?=$client->id?>" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
              <div role="document" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 id="ModalLongTitle" class="modal-title">
                      Modifier Les informations du client
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
                      <input type="number"class="form-control form-control-user" id="id"name="id"placeholder="ex:1"value="<?=$client->id?>"><br>
                      <input type="text" class="form-control form-control-user" id="Nom" placeholder="Votre nom complet" name="Nom"value="<?=$client->nom?>"><br>
                      <input type="email" class="form-control form-control-user" id="email" placeholder="Votre email" name="Email"value="<?=$client->email?>">
                      <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Annuler</button> 
                        <button type="submit" class="btn btn-warning" id="open"name="Modifier"><i class='bx bx-save'></i>Modifier</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!--delete un client-->
              <div class="modal fade" id="delete<?=$client->id?>" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
                <div role="document" class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 id="ModalLongTitle" class="modal-title">
                        Etes vous sur de vouloir supprimer ce client...?
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
                        <input type="number" class="form-control form-control-user" id="id"name="IdS"placeholder="ex:1"value="<?=$client->id?>"><br>
                        <input type="text" class="form-control form-control-user" id="Nom" placeholder="Votre nom complet" name="Nom"value="<?=$client->nom?>"><br>
                        <input type="email" class="form-control form-control-user" id="email" placeholder="Votre email" name="Email"value="<?=$client->email?>"><br>
                        <input type="text" class="form-control form-control-user" id="téléphone" placeholder="Votre numérTelephone"value="<?=$client->telephone?>">
                        <div class="modal-footer">
                          <button type="button" class="btn btn-light" data-dismiss="modal">Annuler</button> 
                          <button type="submit" class="btn btn-warning" id="open"name="delete"><i class='bx bx-save'></i>Supprimé</button>
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
      <li class="<?php if($pageCourante == '1'){echo "disabled";}?>"><a href="?page=client&client=<?php if($pageCourante != '1'){echo $pageCourante-1;}else{echo $pageCourante;}?>"style="border-radius: 50% !important;margin: 0 5px;">«</a></li>
        <?php
        for ($i=1; $i <=$pagesTotales ; $i++) {
          if ($i == $pageCourante) {
        ?>
      <li class="active"><a href="?page=client&client=<?=$i;?>"style="border-radius: 50% !important;margin: 0 5px;"><?=$i;?></a></li>
        <?php
          }else{
            ?>
      <li><a href="?page=client&client=<?=$i;?>"style="border-radius: 50% !important;margin: 0 5px;"><?=$i;?></a></li>
        <?php
      }
    } 
    ?>
    <li class="<?php if($pageCourante == $pagesTotales){echo "disabled";}?>"><a href="?page=client&client=<?php if($pageCourante != $pagesTotales){echo $pageCourante+1;}else{echo $pageCourante;}?>"style="border-radius: 50% !important;margin: 0 5px;">»</a></li>
  </ul>
</div>
</main>

<!--AJouter un client dans la base de donnée -->
<div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
    <div role="document" class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="ModalLongTitle" class="modal-title">
                  D'AJOUT D'UNE NOUVEAU CLIENT
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
                    Le formulaire d'ajout d'un client
                  </p>
                  <input type="text" name="nom" id="nom" class="form-control mb-4" placeholder="ex:Paulinne"value="<?php if (isset($nom)) { echo $nom;}?>"/>
                  <input type="tel" name="telephone" id="telephone" class="form-control mb-4" placeholder="ex:(+237 ou ...)6521478921"value="<?php if (isset($telephone)) { echo $telephone;}?>"/>
                   <select id="sexe" name="sexe" class="form-control">
                    <option selected value="<?php if (isset($sexe)) { echo $sexe;}?>">Choose...</option>
                    <option name="sexe" value="Homme">Homme</option>
                    <option name="sexe" value="Femme">Femme</option>
                  </select><br/>
                  <input type="email"name="email" id="email" class="form-control mb-4" placeholder="ex:njecky@gmail.com"value="<?php if (isset($email)) { echo $email;}?>">
                  <input type="email" name="Email" id="Email" class="form-control mb-4" placeholder="ex:njecky@gmail.com"value="<?php if (isset($Email)) { echo $Email;}?>">
                  <input type="password" name="password" id="password" class="form-control mb-4" placeholder="ex:bojour14">
                  <input type="password" name="Password" id="Password" class="form-control mb-4" placeholder="ex:bojour14">
                  <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Annuler</button> 
                    <button type="submit" class="btn btn-warning" id="open"name="ajouter"><i class='bx bx-save'></i>Ajouter</button>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>