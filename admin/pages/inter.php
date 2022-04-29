  <?php

$erreur = null;
$error = null;
if (isset($_POST['premiere'])) {
  //vérifie si le champ mail est bien rempli:
  if (!empty($_POST['email'])) {
    $email = tes($_POST['email']);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailexist = $db->prepare("SELECT id,nom FROM admin WHERE email = ?");
      $emailexist->execute(array($email));
      $emailexist_count = $emailexist->rowCount();
      if ($emailexist_count == 1) {
        $nom = $emailexist->fetch();
        $nom = $nom['nom'];
        var_dump($nom);
        $_SESSION['recup_mail'] = $email;
        $recup_code = "";
        for ($i=0; $i < 8 ; $i++) {
          $recup_code .= mt_rand(0,9);
        }
        $_SESSION['recup_code'] = $recup_code;

        $mail_recup_exist = $db->prepare("SELECT id FROM recuperation WHERE email = ?");
        $mail_recup_exist->execute(array($recup_mail));
        $mail_recup_exist = $mail_recup_exist->rowCount();

        if ($mail_recup_exist == 1) {
          $recup_insert = $db->prepare("UPDATE recuperation SET code = ? WHERE email = ?");
          $recup_insert->execute(array($recup_code,$recup_mail));
        }else{
          $recup_insert = $db->prepare("INSERT INTO recuperation(code,email) VALUES (?, ?)");
          $recup_insert->execute(array($recup_code,$recup_mail));
        }
      }else{
         header("Location:../index.php?page=home");
      }
    }else{
      $erreur = "Votre adresse email est invalide !";
    }
  }else{
    $erreur = "Veuillez entrez votre adresse email";
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
              <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                    <p class="mb-4">We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!</p>
                  </div>
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
                  <form class="user" method="post" action="#">
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" name="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..."style="border-radius: 10rem;">
                    </div>
                    <input type="submit" name="premiere" class="btn btn-primary btn-user btn-block"  value="Reset Password"style="border-radius: 10rem;">
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="index.php?page=login">Already have an account? Login!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>