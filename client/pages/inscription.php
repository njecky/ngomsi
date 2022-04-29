<?php

vérifierclient();

$erreur = null;
$error = null;

if (isset($_POST['i'])) {
  $nom = tes(tes($_POST["nom"]));
  $email = tes(tes($_POST["email"]));
  $Email = tes(tes($_POST["Email"]));
  $telephone = tes(tes($_POST["telephone"]));
  $password = sha1(tes($_POST["password"]));
  $Password = sha1(tes($_POST["Password"]));
  $sexe = tes(tes($_POST["sexe"]));

  if (!empty($_POST['nom']) AND !empty($_POST['email']) AND !empty($_POST['Email']) AND !empty($_POST['telephone']) AND !empty($_POST['password']) AND !empty($_POST['Password']) AND !empty($_POST['sexe'])) {
    $nomlength = strlen($nom);
    $sexelength = strlen($sexe);

    if ($nomlength <= 255) {
      if (!preg_match("/^\d\d(.)\d\d\\1\d\d\\1\d\d\\1\d\d$/", $telephone)) {
        if ($sexelength <= 5) {
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
                  $error = "Votre compte a été bien créer";
                  header("Location:index.php?page=login");
                }else{
                  $erreur = "Vos mots de passes ne correspondent pas !";
                } 
              }else{
                $erreur = "Veuillez changé d'adresse email car il éxiste déjà dans notre base de donnée  mercie";
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
      $erreur = "Votre nom ne doit pas dépassé 255 caractères !";
    }
  }else{
    $erreur = "Veuillez remplir tout les champs";
  }
}
?>
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
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
              <form class="user" method="post">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control form-control-user" id="nom" placeholder="Votre nom complet" name="nom" style="font-size: .8rem;border-radius: 10rem;padding: 1.5rem 1rem;" value="<?php if (isset($nom)) { echo $nom;}?>"required/>
                  </div>
                  <div class="col-sm-6">
                    <label for="email">Email</label>
                    <input type="email" class="form-control form-control-user" id="email" placeholder="Votre email" name="email" style="font-size: .8rem;border-radius: 10rem;padding: 1.5rem 1rem;" value="<?php if (isset($email)) { echo $email;}?>"required/>
                  </div>
                  <div class="col-sm-6">
                    <label for="email">Confimation d'Email</label>
                    <input type="email" class="form-control form-control-user" id="email" placeholder="Confirmer votre email" name="Email" style="font-size: .8rem;border-radius: 10rem;padding: 1.5rem 1rem;" value="<?php if (isset($Email)) { echo $Email;}?>"required/>
                  </div>
                  <div class="col-sm-6">
                    <label for="tel">Téléphone</label>
                    <input type="tel" class="form-control form-control-user" id="tel" placeholder="Votre numéro de téléphone" name="telephone" style="font-size: .8rem;border-radius: 10rem;padding: 1.5rem 1rem;" value="<?php if (isset($telephone)) { echo $telephone;}?>"required/>
                  </div>
                  <div class="col-sm-6">
                    <label for="password">Password</label>
                    <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Votre mot de passe"style="font-size: .8rem;border-radius: 10rem;padding: 1.5rem 1rem;"required>
                  </div>
                  <div class="col-sm-6">
                    <label for="repassword">Confimation password</label>
                    <input type="password" class="form-control form-control-user" id="repassword" name="Password" placeholder="Confirmer Votre mot de passe"style="font-size: .8rem;border-radius: 10rem;padding: 1.5rem 1rem;"required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="sexe"required>Sexe</label>
                  <select id="sexe" name="sexe" class="form-control">
                    <option selected value="<?php if (isset($sexe)) { echo $sexe;}?>">Choose...</option>
                    <option name="sexe" value="Homme">Homme</option>
                    <option name="sexe" value="Femme">Femme</option>
                  </select>
                </div>
                 <input type="submit"class="btn btn-info btn-user btn-block" name="i" value="Register Account"style="border-radius: 25px;font-weight: 700px; cursor: pointer; outline: none;">
              </form>
              <div class="text-center">
                <a class="small" href="index.php?page=inter">Forgot Password?</a>
              </div>
              <div class="text-center">
                <a class="small" href="index.php?page=login">Already have an account? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>