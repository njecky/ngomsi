<?php

vérifierclient();

$erreur ="";
  if (isset($_POST['v'])) {
    $email = tes(tes($_POST["email"]));
    $password = tes(sha1(tes($_POST["password"])));

    if (!empty($_POST['email']) AND !empty($_POST['password'])) {
      $requser = $db->prepare("SELECT * FROM client WHERE email = ? AND password = ?");
      $requser->execute(array($email, $password));
      $userexist = $requser->rowCount();

      if ($userexist == 1) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $userinfo = $requser->fetch();
          $_SESSION['id'] = $userinfo['id'];
          $_SESSION['nom'] = $userinfo['nom'];
          $_SESSION['sexe'] = $userinfo['sexe'];
          $_SESSION['telephone'] = $userinfo['telephone'];
          $_SESSION['email'] = $userinfo['email'];
          $_SESSION['avatar'] = $userinfo['avatar'];
          header("Location:index.php?page=dashboard");
        }else{
          $erreur = "Votre adresse mail n'est pas valide !";
        }
      }else if(is_client($email,$password) == 0){
        $erreur = "Identifiants éronnés";
      }
    }else{
      $erreur = "Veuillez remplir tout les champs !";
    }
  }
?>
 <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"><img src="../assets/img/client/client.jpg" alt="client.jpg" class="img-thumbnail avatar" style="width: 500px;height: 400px;position:center;top: -90px;left: 110px;"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Client</h1>
                  </div>
                  <?php if ($erreur) : ?>
                    <div class="alert alert-danger">
                      <?= $erreur ?> 
                    </div>
                  <?php endif ?>
                  <form class="user" method="post">
                    <div class="form-group">
                      <input type="email" name="email"class="form-control form-control-user" id="email" aria-describedby="emailHelp" placeholder="Enter Email Address..." style="border-radius: 10rem;"required>
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" class="form-control form-control-user" id="password" placeholder="Enter votre password" style="border-radius: 10rem;"required>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                         <a href="index.php?page=inter">Remember Me</a><br>
                         <a href="index.php?page=inscription">S'inscrition</a><br>
                         <a href="../index.php?page=home">Retourner A l'accueuil du site</a>
                      </div>
                    </div>
                    <input type="submit"class="btn btn-info btn-user btn-block" name="v" value="Connexion"style="border-radius: 25px;font-weight: 700px; cursor: pointer; outline: none;">
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>