<!-- sidebar-wrapper  -->
<main class="page-content main">
  <h1 align="center">Tableau de bord <strong><?=$_SESSION['nom'];?></strong> </h1>
  <hr>
  <div class="row row-cols-1 row-cols-md-2">
    <?php

    $tables = [
      "Administrateurs" => "admin",
      "Fournisseurs"    => "partenaire",
      "Catégories"      => "categorie",
      "Commentaires"    => "commentaire",
      "Commandes"       => "commande",
      "Clients"         => "client",
      "Produits"        => "produit",
      "Mots de passe oublié"  => "recuperation"
    ];

   /* $colors = [
      "admin" => "green",
      "partenaire"    => "red",
      "categorie"      => "red",
      "commentaire"    => "blue-grey",
      "commande"       => "blue",
      "client"         => "blue",
      "produit"        => ""
    ];*/

  ?>
  <?php

    foreach ($tables as $table_name => $table) {
      ?>
  <div class="col mb-3">
    <div class="card">
      <div class="card-body bg-secondary text-white">
        <h5 class="card-title"align="center"><?=$table_name ?></h5>
        <?php $nbrInTable = inTable($table);?>
        <p class="card-text"align="center"><?= $nbrInTable[0];?></p>
      </div>
    </div>
  </div>
  <?php
    }
  ?>
  </div>

  
</main>
