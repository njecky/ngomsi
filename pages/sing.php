<?php

//$cat = $_GET['idcategorie=<?=$categorie->id;?'];
//$art = $db->query("SELECT * FROM produit WHERE categorie_id = ".$cat."");
//$aty = $art->fetchAll();
?>
<div class="row no-gutters">
    <div class="col-6 col-md-2">
        <div id="mobile-filter">
            <div class="py-2 border-bottom ml-3">
                <h6 class="font-weight-bold">Categories</h6>
                <?php
        $categoriesParge =2;
        $categoriesTotalesReq = $db->query('SELECT id FROM categorie');
        $categoriesTotales = $categoriesTotalesReq->rowCount();
        $pagesTotales = ceil($categoriesTotales/$categoriesParge);

        if (isset($_GET['g']) AND !empty($_GET['g']) AND $_GET['g']>0 AND $_GET['g'] <= $categoriesTotales) {
            $_GET['g'] =intval($_GET['g']);
            $pageCourante = $_GET['g'];
        }else{
            $pageCourante = 1;
        }

        $depart = ($pageCourante-1)*$categoriesParge;
        $select = $db->prepare('SELECT * FROM categorie ORDER BY id ASC LIMIT '.$depart.','.$categoriesParge);
        $select->execute();
      while ($categorie=$select->fetch(PDO::FETCH_OBJ)){
      ?>
                <nav class="navbar bg-light">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="?page=sing&idcategorie=<?=$categorie->id;?>"><?=$categorie->libelle;?></a>
                        </li>
                    </ul>
                </nav>
                    <?php
                    }
                    ?>
            </div>
            <div class="container">
                <ul class="pagination justify-content-center" style="border-radius: 50% !important;margin: 0 5px;">
                    <li class="<?php if($pageCourante == '1'){echo "disabled";}?>"><a href="?page=sing&g=<?php if($pageCourante != '1'){echo $pageCourante-1;}else{echo $pageCourante;}?>"style="border-radius: 50% !important;margin: 0 5px;">«</a></li>
                    <?php
for ($i=1; $i <=$pagesTotales ; $i++) {
  if ($i == $pageCourante) {
?>
  <li class="active"><a href="?page=sing&g=<?=$i;?>"style="border-radius: 50% !important;margin: 0 5px;"><?=$i;?></a></li>
<?php
}else{
  ?>
  <li><a href="?page=sing&g=<?=$i;?>"style="border-radius: 50% !important;margin: 0 5px;"><?=$i;?></a></li>
  <?php
}
} 
?>
                    <li class="<?php if($pageCourante == $pagesTotales){echo "disabled";}?>"><a href="?page=sing&g=<?php if($pageCourante != $pagesTotales){echo $pageCourante+1;}else{echo $pageCourante;}?>"style="border-radius: 50% !important;margin: 0 5px;">»</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-8"><!-- products section -->
<section id="products">
    <div class="container">
        <div class="row">
            <?php
                $produitsParPage = 6;
                $produitsTotalesReq = $db->query('SELECT id FROM produit');
                $produitsTotales = $produitsTotalesReq->rowCount();
                $pagesTotales = ceil($produitsTotales/$produitsParPage);

                if (isset($_GET['pa']) AND !empty($_GET['pa']) AND $_GET['pa']>0 AND $_GET['pa'] <= $pagesTotales) {
                    $_GET['pa'] = intval($_GET['pa']);
                    $pageCourante = $_GET['pa'];
                }else{
                    $pageCourante = 1;
                }
                $depart = ($pageCourante-1)*$produitsParPage;
                $select = $db->prepare('SELECT * FROM produit ORDER BY id ASC LIMIT '.$depart.','.$produitsParPage);
                $select->execute();
                while ($s=$select->fetch(PDO::FETCH_OBJ)){
            ?>
            <div class="col-lg-4 col-md-6 col-sm-10 offset-md-0 offset-sm-1">
                <div class="card"><a href="index.php?page=post&id=<?=$s->id?>"><img class="card-img-top" src="assets/img/produit/<?=$s->titre?>?auto=compress&cs=tinysrgb&dpr=1&w=500"alt="<?=$s->titre?>"width="250px" height="250px"></a>
                    <div class="card-body">
                        <h5><b><?=$s->titre;?></b> </h5>
                        <div class="d-flex flex-row my-2">
                            <div class="text-muted"><?= price($s->prix);?></div>
                            <div class="ml-auto"> <button class="border rounded bg-white sign"><span class="fa fa-plus" id="orange"></span></button> <span class="px-sm-1"><?=$s->quantite;?></span> <button class="border rounded bg-white sign"><span class="fa fa-minus" id="orange"></span></button> </div>
                        </div>
                        <?php if ($s->quantite != 0) { ?>
                        <?php if (isset($_SESSION['id'])) { ?>
                            <a href="index.php?page=cart&amp;t=<?= $s->titre;?>&amp;q=<?= $s->quantite;?>&amp;p=<?= $s->prix;?>"><button class="btn btn-outline-dark w-100 rounded my-2">Ajouter au panier</button>
                        <?php  }else{echo'<a href="client/index.php"><button class="btn btn-outline-dark w-100 rounded my-2">Ajouter au panier</button>';}?>
                        <?php }else{echo'<h5 style="color:red;">La quantité épuisé</h5>';} ?></a>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>
    <div class="container">
        <ul class="pagination justify-content-center">
            <li class="<?php if($pageCourante == '1'){echo "disabled";}?>"><a href="?page=sing&pa=<?php if($pageCourante != '1'){echo $pageCourante-1;}else{echo $pageCourante;}?>"><a href="#">«</a></li>
                    <?php
                    for ($i=1; $i <=$pagesTotales ; $i++) {
                        if ($i == $pageCourante) {
                            ?>
            <li class="active"><a href="?page=sing&pa=<?=$i;?>"><?=$i;?></a></li>
                    <?php
                        }else{
                    ?>
            <li><a href="?page=sing&pa=<?=$i;?>"><?=$i;?></a></li>
                <?php
            }
        } 
        ?>
            <li><a class="<?php if($pageCourante == $pagesTotales){echo "disabled";}?>"><a href="?page=sing&pa=<?php if($pageCourante != $pagesTotales){echo $pageCourante+1;}else{echo $pageCourante;}?>">»</a></li>
            </ul>
</div>
</section></div>
</div>
<style type="text/css">
.pagination>li>a, .pagination>li>span { border-radius: 50% !important;margin: 0 5px;}
</style>