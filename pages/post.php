<?php

//$profile = avatar();
$post = detail();
if ($post == false) {
     require"404.php";
}else{
?>

<?php
 $responses = getcomment();

$erreur = null;
$error = null;
$mo = null;

if (isset($_POST['moi'])) {
  $nom = tes($_POST['nom']);
  $email = tes($_POST['email']);
  $message = tes($_POST['message']);

  if (!empty($_POST['nom']) AND !empty($_POST['email']) AND !empty($_POST['message'])) {
    if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#",$email)) {
      comment($nom,$email,$message);
      ?>
        <script>
          window.location.replace("index.php?page=post&id=<?= $_GET['id'] ?>");
          alert("Votre commentaire a été bien envoyer");
        </script>
      <?php
    }else{
      $erreur = "Votre adresse email n'est invalide";
    }
  }else{
    $erreur = "Tous les champs n'ont pas été remplis";
  }
}
?>
  <div class="card border-0">
  <div class="row">
    <aside class="col-sm-4">
<article class="gallery-wrap"> 
<div class="img-big-wrap">
  <div><img src="assets/img/produit/<?=$post->titre?>"alt="<?=$post->titre?>"></div>
</div>
</article>
    </aside>
    <aside class="col-sm-5">
<article class="card-body m-0 pt-0 pl-5">
  <h3 class="title text-uppercase"><?=$post->titre?>"</h3>           
<div class="mb-3 mt-3"> 
    <span class="price-title">Prix :</span>
    <span class="price color-price-waanbii"><?=$post->prix?><sup>FCFA</sup></span>
</div>
<div class="mb-3 mt-3"> 
    <span class="price-title">Catégorie :</span>
    <span class="price color-price-waanbii"><?=$post->libelle?></span>
</div>
<dl class="item-property">
  <dt>Description</dt>
  <dd><p><?=$post->description?></p></dd>
</dl>
<dl class="param param-feature">
  <dt>Quantity disponible</dt>
  <dd><?=$post->quantite?></dd>
</dl>
</article>
    </aside>
    <aside class="col-sm-3">
          <div class="row">
      <dl class="param param-inline">
        <dt>Quantity: </dt>
        <dd>
          <select class="form-control form-control-sm" style="width:70px;">
            <option> 1 </option>
            <option> 2 </option>
            <option> 3 </option>
            <option> 4 </option>
            <option> 5 </option>
            <option> 6 </option>
            <option> 7 </option>
            <option> 8 </option>
            <option> 9 </option>
            <option> 10 </option>
          </select>
        </dd>
      </dl>
  </div>
    <div class="row ">
  <button class="btn btn-lg color-box-waanbii" type="button"> <i class="fa fa-shopping-cart"></i> Ajouter au panier </button>
  </div>
    </aside>
  </div>
</div><!--container.//-->
<hr>
<div class="row mb-5 justify-content-center">
   <h4>Commentaires: <?= count($responses);?></h4>
</div>
  <?php
    if ($responses != false) {
       foreach ($responses as $response) {
      ?>
        <div class="row mb-5">
            <div class="media">
              <img class="mr-3" src="assets/img/internaute.png"alt="internaute"style="width:60px">
              <div class="media-body">
                <h5 class="mt-0"><strong><?= htmlentities($response->nom);?> (<?=date("d/m/Y", strtotime($response->date))?>)</strong></h5>
                <?= htmlentities(nl2br($response->comment));?>
              </div>
            </div>
        </div>
      <?php
    }
    }else{
      $mo = "Aucun commentaire n'a été publié... Soyer le premier !";
    }
  ?>

<hr>
  <?php

}
?>
<?php debug($_SESSION); ?>
<div class="row mb-5 justify-content-center">
  <h4>Commenter:</h4>
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
            <?php if ($mo) : ?>
              <div class="alert alert-warning">
                <?= $mo ?> 
              </div>
              <?php endif ?>
            <form method="post">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="nom">Nom</label>
                  <input type="text" class="form-control " name="nom" id="nom" placeholder="Votre Nom complet" value="<?php if(isset($_POST['nom'])) echo tes($_POST['nom']); if(isset($_SESSION['id'])) echo tes($_SESSION['nom']);?>"required/>
                </div>
                <div class="form-group col-md-6">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="Votre Email"  value="<?php if(isset($_POST['email'])) echo tes($_POST['email']); if(isset($_SESSION['id'])) echo tes($_SESSION['email']);?>"required/>
                </div>
                <div class="form-group col-md-12">
                  <label for="subjest">Message</label>
                  <textarea class="form-control" typpe="text" name="message" aria-label="Message" id="message" placeholder="Votre commentaire" required><?php if(isset($_POST['message'])) echo tes($_POST['message']);?></textarea>
              </div>
              <button type="submit" class="btn float-right btn btn-primary" name="moi">Sign in</button>

            </div>
          </form>
      </div>
    </div>
  </div>
<p>&nbsp;</p>



<style type="text/css">
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .gallery-wrap .img-big-wrap img {
    height: 400px;
    width: 400px;
   /* width: auto;*/
    display: inline-block;
    cursor: zoom-in;
}


.gallery-wrap .img-small-wrap .item-gallery {
    width: 70px;
    height: auto;
    margin: 7px 2px;
    display: inline-block;
    overflow: hidden;
}

.gallery-wrap .img-small-wrap {
    text-align: center;
}
.gallery-wrap .img-small-wrap img {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
    border-radius: 4px;
    /*cursor: zoom-in;*/
}
.price-title{
    font-weight: 700;
}
.price{
    font-size: 24px;
    line-height: 31px;
    text-transform: uppercase;
    max-height: 66px;
    overflow: hidden;
    font-family: 'Open Sans',Arial,sans-serif;
    font-weight: 700;
    width: 100%;
    padding: 0;
    float: none;


}
.color-price-waanbii{
    color: #FA3A11; 
}
.color-box-waanbii{
    background: #FD6342; 
    color:white;
}

.fa-beat {
  animation:fa-beat 5s ease infinite;
}
@keyframes fa-beat {
  0% {
    transform:scale(1);
  }
  5% {
    transform:scale(1.25);
  }
  20% {
    transform:scale(1);
  }
  30% {
    transform:scale(1);
  }
  35% {
    transform:scale(1.25);
  }
  50% {
    transform:scale(1);
  }
  55% {
    transform:scale(1.25);
  }
  70% {
    transform:scale(1);
  }
}

</style>

    