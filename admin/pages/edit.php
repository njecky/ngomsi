 <?php

 if (isset($_SESSION['id'])) {
 	$rquser = $db->prepare("SELECT * FROM admin WHERE id =?");
 	$rquser->execute(array($_SESSION['id']));
 	$user = $rquser->fetch();

 	if (isset($_POST['nom']) AND !empty($_POST['nom']) AND $_POST['nom'] != $user['nom']) {
    $nom = tes($_POST['nom']);
    $insertpseudo = $db->prepare("UPDATE admin SET nom = ? WHERE id = ?");
    $insertpseudo->execute(array($nom, $_SESSION['id']));
    //header("Location:index.php?page=dashboard");
  }
  if (isset($_POST['email']) AND !empty($_POST['email']) AND $_POST['email'] != $user['email'])
  {
    $email = tes($_POST['email']);
    $insertmail = $db->prepare("UPDATE admin SET email = ? WHERE id = ?");
    $insertmail->execute(array($email, $_SESSION['id']));
    //header("Location:index.php?page=dashboard");
  }
   if (isset($_POST['telephone']) AND !empty($_POST['telephone']) AND $_POST['telephone'] != $user['phone'])
  {
    $telephone = tes($_POST['telephone']);
    $instelephone = $db->prepare("UPDATE admin SET phone = ? WHERE id = ?");
    $instelephone->execute(array($telephone, $_SESSION['id']));
    //header("Location:index.php?page=dashboard");
  }

  if (isset($_POST['password']) AND !empty($_POST['password']) AND isset($_POST['Password']) AND !empty($_POST['Password']))
  {
    $password = sha1($_POST['password']);
    $Password = sha1($_POST['Password']);

    if ($password == $Password)
    {
      $insertmdp = $db->prepare("UPDATE admin SET password = ? WHERE id = ?");
      $insertmdp->execute(array($password, $_SESSION['id']));
      //header("Location:index.php?page=dashboard");
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
        $chemin ="../assets/img/admin/".$_SESSION['id'].".".$extensionUpload;
        $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
        if ($resultat) {
          $updateavatar = $db->prepare("UPDATE admin SET avatar = :avatar WHERE id = :id");
          $updateavatar->execute(array(
            'avatar' => $_SESSION['id']. ".".$extensionUpload,
            'id'=> $_SESSION['id']
          ));
           //header("Location:index.php?page=dashboard");
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
 } 
 ?>
 <!-- sidebar-wrapper  -->
<main class="page-content main">
	<div align="center">
		<img src="../assets/img/admin/<?=$user['id']?>"alt="<?=$user['nom']?>" width="150"/>
		<br>
		<h2>Profil de <strong><?=$_SESSION['nom'];?></strong> </h2><br/>
	</div>
	<div class="col-lg-10 col-lg-offset-1">
		<form class="user" method="post" enctype="multipart/form-data">
			<div class="form-row">
				<div class="form-group col-md-6">
					<input type="text" name="nom"class="form-control form-control-user" id="nom" aria-describedby="nomHelp" placeholder="Votre nom" style="border-radius: 10rem;"value="<?=$user['nom']?>"/>
				</div>
				<div class="form-group col-md-6">
					<input type="text" name="telephone"class="form-control form-control-user" id="telephone" aria-describedby="telephoneHelp" placeholder="Votre numéro de téléphone" style="border-radius: 10rem;"value="<?=$user['phone']?>"/>
				</div>
				<div class="form-group col-md-6">
					<input type="email" name="email"class="form-control form-control-user" id="email" aria-describedby="emailHelp" placeholder="Votre email" style="border-radius: 10rem;"value="<?=$user['email']?>"/>
				</div>
				<div class="form-group col-md-6">
					<input type="password" name="password"class="form-control form-control-user" id="password" aria-describedby="passwordHelp" placeholder="Votre nouveau password" style="border-radius: 10rem;">
				</div>
				<div class="form-group col-md-6">
					<input type="password" name="Password"class="form-control form-control-user" id="Password" aria-describedby="passwordHelp" placeholder="Confimation votre nouveau password" style="border-radius: 10rem;">
				</div>
				<?php if(isset($msg)){echo $msg;}?>
				<div class="form-group col-md-6">
                    <input type="file" class="form-control form-control-user" id="avatar" name="avatar">
				</div>
			</div>
			<input type="submit" class="btn btn-primary btn-block" name="moi"style="border-radius: 25px;font-weight: 700px; cursor: pointer; outline: none;"value="Mettre à jour mon profit">
		</form>	
	</div>
</main>