<?php

 $administrateurs = affichéadministrateurspécifique();

$erreur = null;
$error = null;

//require 'config/header.php';

/*
Traitement de formulaire d'envoie de message
*/
if (isset($_POST['sub'])) {
  $nom = tes($_POST['nom']);
  $email = tes($_POST['email']);
  $subjest =tes($_POST['subjest']);
  $message = tes($_POST['message']);

  if (!empty($_POST['nom']) AND !empty($_POST['email']) AND !empty($_POST['subjest']) AND !empty($_POST['message'])) {
    if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#",$email)) {

      // $destinataire ="njeckyf1@gmail.com";
      // $sujet = $subjest;
      // $entete = 'From : '.$email;
      // mail($destinataire, $sujet, $message, $entete);
        ?>
         <script>
            window.location.replace("index.php?page=contact");
            alert("Votre Message a été envoyé");
        </script>
        <?php
      // header("Location:index.php?page=contact");
    }else{
      $erreur = "Votre adresse email n'est invalide";
    }
  }else{
    $erreur = "Tous les champs doivent être remplis correctement";
  }
}
?>
<section class="section">
    <div class="row">

        <!--Grid column-->
        <div class="col-md-8 col-xl-9">
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
            <form id="contact-form"method="POST">

                <!--Grid row-->
                <div class="row">

                    <!--Grid column-->
                    <div class="col-md-6">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class='bx bx-user-circle bx-sm'></i></span>
                            </div>
                            <input type="text" class="form-control" name="nom" placeholder="username ou votre nom complèt"value="<?php if(isset($_POST['nom'])) echo tes($_POST['nom']); if(isset($_SESSION['id'])) echo tes($_SESSION['nom']);?>">
                        </div>
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-md-6">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class='bx bx-envelope bx-sm'></i></span>
                            </div>
                            <input type="email" class="form-control" name="email" placeholder="Entrez votre email"value="<?php if(isset($_POST['email'])) echo tes($_POST['email']);if(isset($_SESSION['id'])) echo tes($_SESSION['email']);?>">
                        </div>
                    </div>
                    <!--Grid column-->

                </div>
                <!--Grid row-->

                <!--Grid row-->
                <div class="row">
                    <div class="col-md-6">
                         <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class='bx bx-message'></i></span>
                            </div>
                            <input type="text" class="form-control" name="subjest" placeholder="Le sujet du message" value="<?php if(isset($_POST['subjest'])) echo tes($_POST['subjest']);?>">
                        </div>
                    </div>
                </div>
                <!--Grid row-->

                <!--Grid row-->
                <div class="row">

                    <!--Grid column-->
                    <div class="col-md-12">

                        <div class="md-form">
                            <textarea type="text" id="message" name="message" rows="2" class="form-control md-textarea"><?php if(isset($_POST['message'])) echo tes($_POST['message']);?></textarea>
                            <label for="message">Your message</label>
                        </div>

                    </div>
                </div>
                <!--Grid row-->
                <div class="form-group">
                        <input type="submit" value="Envoyer"name="sub"class="bx bx-navigation btn float-right login_btn btn btn-primary">
                    </div>
            </form>
            <div class="status"></div>
        </div>
        <!--Grid column-->


        <!--Grid column-->
        <div class="col-md-4 col-xl-3">
            <ul class="contact-icons">
                 <?php foreach($administrateurs as $admin){ ?>
                <li><i class="fa fa-map-marker fa-2x"></i>
                    <p><?=$admin->nom?></p>
                </li>

                <li><i class="fa fa-phone fa-2x"></i>
                    <p><?=$admin->phone?></p>
                </li>

                <li><i class="fa fa-envelope fa-2x"></i>
                    <p><?=$admin->email?></p>
                </li>
                <?php
                }

            ?>
            </ul>
        </div>
        <!--Grid column-->

    </div>

</section><br>
<!--Section: Contact v.2-->