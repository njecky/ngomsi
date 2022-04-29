<?php 
if (isset($_SESSION['id'])) {
  $rquser = $db->prepare("SELECT * FROM client WHERE id =?");
  $rquser->execute(array($_SESSION['id']));
  $user = $rquser->fetch();

  if (isset($_POST['nom']) AND !empty($_POST['nom']) AND $_POST['nom'] != $user['nom']) {
    $nom = tes($_POST['nom']);
    $insertpseudo = $db->prepare("UPDATE client SET nom = ? WHERE id = ?");
    $insertpseudo->execute(array($nom, $_SESSION['id']));
    header("Location:index.php?page=dashboard");
  }

  if (isset($_POST['email']) AND !empty($_POST['email']) AND $_POST['email'] != $user['email'])
  {
    $email = tes($_POST['email']);
    $insertmail = $db->prepare("UPDATE client SET email = ? WHERE id = ?");
    $insertmail->execute(array($email, $_SESSION['id']));
    header("Location:index.php?page=dashboard");
  }
   if (isset($_POST['telephone']) AND !empty($_POST['telephone']) AND $_POST['telephone'] != $user['telephone'])
  {
    $telephone = tes($_POST['telephone']);
    $instelephone = $db->prepare("UPDATE client SET telephone = ? WHERE id = ?");
    $instelephone->execute(array($telephone, $_SESSION['id']));
    header("Location:index.php?page=dashboard");
  }

  if (isset($_POST['password']) AND !empty($_POST['password']) AND isset($_POST['Password']) AND !empty($_POST['Password']))
  {
    $password = sha1($_POST['password']);
    $Password = sha1($_POST['Password']);

    if ($password == $Password)
    {
      $insertmdp = $db->prepare("UPDATE client SET password = ? WHERE id = ?");
      $insertmdp->execute(array($password, $_SESSION['id']));
      header("Location:index.php?page=dashboard");
    }
    else
    {
      $msg = "Vos deux mot de passes ne correspondent pas !";
    }
  }

  if (isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) {
    $taillemax = 6097152;
    $extensionsValides = array('jpg','jpeg','gif','png');
    if ($_FILES['avatar']['size'] <= $taillemax) {
      $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
      if (in_array($extensionUpload, $extensionsValides)) {
        $chemin ="../assets/img/client/".$_SESSION['id'].".".$extensionUpload;
        $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
        if ($resultat) {
          $updateavatar = $db->prepare("UPDATE client SET avatar = :avatar WHERE id = :id");
          $updateavatar->execute(array(
            'avatar' => $_SESSION['id']. ".".$extensionUpload,
            'id'=> $_SESSION['id']
          ));
           header("Location:index.php?page=dashboard");
        }else{
          $msg = "Erreur durant l'importation de votre photo de profil";
        }
      }else{
        $msg = "Votre photo de profil doit être aux formats jpg, jpeg, gif, ou png";
      }
    }else{
      $msg = "Votre photo de profil ne doit pas dépasser 6 Mo";
    }
  }
?>
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image">
            <img src="../assets/img/client/<?=$user['avatar']?>"alt="<?=$user['nom']?>" class="img-thumbnail avatar"width="900px" height="900px">
          </div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Edition de mon profil !</h1>
              </div>
              <form class="user" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control form-control-user" id="nom" placeholder="Votre nom complet" name="nom" style="font-size: .8rem;border-radius: 10rem;padding: 1.5rem 1rem;"value="<?=$user['nom']?>"/>
                  </div>
                  <div class="col-sm-6">
                    <label for="email">Email</label>
                    <input type="email" class="form-control form-control-user" id="email" placeholder="Votre email" name="email" style="font-size: .8rem;border-radius: 10rem;padding: 1.5rem 1rem;"value="<?=$user['email']?>"/>
                  </div>
                  <div class="col-sm-6">
                    <label for="tel">Téléphone</label>
                    <input type="tel" class="form-control form-control-user" id="tel" placeholder="Votre numéro de téléphone" name="telephone" style="font-size: .8rem;border-radius: 10rem;padding: 1.5rem 1rem;"value="<?=$user['telephone']?>"/>
                  </div>
                  <div class="col-sm-6">
                    <label for="password">Password</label>
                    <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Votre mot de passe"style="font-size: .8rem;border-radius: 10rem;padding: 1.5rem 1rem;">
                  </div>
                  <div class="col-sm-6">
                    <label for="repassword">Confimation password</label>
                    <input type="password" class="form-control form-control-user" id="repassword" name="Password" placeholder="Confirmer Votre mot de passe"style="font-size: .8rem;border-radius: 10rem;padding: 1.5rem 1rem;">
                  </div>
                  <div class="form-group">
                    <label for="avatar">Avatar</label>
                    <input type="file" class="form-control form-control-user" id="avatar" name="avatar">
                  </div>
                </div>
                 <input type="submit"class="btn btn-info btn-user btn-block" name="m" value="Mettre à jour mon profit"style="border-radius: 25px;font-weight: 700px; cursor: pointer; outline: none;">
              </form>
              <?php if(isset($msg)){echo $msg;}?>
              <div class="text-center">
                <a class="small" href="index.php?page=dashboard">Forgot Password?</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php 
}?>