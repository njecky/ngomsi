<div class="container text-center">    
  <h3>Nos nouveaux Produits</h3><br>
  <div class="row">
    <?php
      $select = $db->query('SELECT * FROM produit ORDER BY id DESC');
      //$select = $db->prepare('SELECT * FROM produit ORDER BY id ASC LIMIT ');
      $select->execute();
      while ($produit = $select->fetch(PDO::FETCH_OBJ)) {
    ?>
    <div class="col-sm-4">
      <img src="assets/img/produit/<?=$produit->titre?>"width="250px" height="250px"class="img-responsive" style="width:100%" alt="Image">
      <p><?=$produit->titre?></p>
    </div>
    <?php }?>
  </div>
</div>


<!-- ======= présentation des partenaires ======= -->
  <div class="container">
    <h1>Nos Partenaires</h1>
    <p class="text-center">DÉCORATIONS, Meubles & Décorations, SAMSUNG, ELECTROMENAGER ... Il répare la peau endommagée par les produits éclaircissant et vous assure un teint ... Catégories : Mode Femme, Santé et Beauté</p>
    <div class="row">
      <?php
      $partenairesParge =3;
      $partenairesTotalesReq = $db->query('SELECT id FROM partenaire');
      $partenairesTotales = $partenairesTotalesReq->rowCount();
      $pagesTotales = ceil($partenairesTotales/$partenairesParge);

      if (isset($_GET['p']) AND !empty($_GET['p']) AND $_GET['p']>0 AND $_GET['p'] <= $partenairesTotales) {
        $_GET['p'] =intval($_GET['p']);
        $pageCourante = $_GET['p'];
      }else{
        $pageCourante = 1;
      }

      $depart = ($pageCourante-1)*$partenairesParge;
      $select = $db->prepare('SELECT * FROM partenaire ORDER BY id ASC LIMIT '.$depart.','.$partenairesParge);
      $select->execute();
      while ($partenaire=$select->fetch(PDO::FETCH_OBJ)){
      ?>
      <div class="col-sm-6 col-md-4">
        <div class="service-box">
          <img src="assets/img/partenaire/<?=$partenaire->noms?>" alt="<?=$partenaire->noms?>"class="rounded mx-auto d-block img-thumbnail"width="250px" height="250px">
          <h2 class="titre"><?=$partenaire->noms;?></h2>
          <p class="telephone">
            <?=$partenaire->phone;?>
          </p>
          <a href="<?=$partenaire->site;?>">Cliquée ici</a>
        </div>
      </div>
      <?php
}
?>
    </div>
  </div>
     <ul class="pagination justify-content-center">
  <li class="<?php if($pageCourante == '1'){echo "disabled";}?>"><a href="?p=<?php if($pageCourante != '1'){echo $pageCourante-1;}else{echo $pageCourante;}?> page-item">&laquo;</a></li>
<?php
for ($i=1; $i <=$pagesTotales ; $i++) {
  if ($i == $pageCourante) {
?>
  <li class="active page-item"><a href="?p=<?=$i;?>"><?=$i;?></a></li>
<?php
}else{
  ?>
  <li><a href="?p=<?=$i;?>"><?=$i;?></a></li>
  <?php
}
} 
?>
  <li class="<?php if($pageCourante == $pagesTotales){echo "disabled";}?>"><a href="?p=<?php if($pageCourante != $pagesTotales){echo $pageCourante+1;}else{echo $pageCourante;}?> page-item">&raquo;</a></li>
</ul>
<style>
 h1{
  text-align: center;
  font-weight: bold;
  color: #ff9800;
  padding-bottom: 10px;
  text-transform: uppercase;
}
h1::after{
  content: '';
  background: #ff9800;
  display: block;
  height: 3px;
  width: 170px;
  margin: 20px auto 5px;
}
.service-box{
  text-align: center;
  padding: 35px 15px;
  overflow: hidden;
  position: relative;
  transition: all 0.3s ease 0s;
}
.service-box:hover{
  background: #967128;
}
.service-box:before{
  content: '';
  width: 40px;
  height: 40px;
  border-width: 20px;
  border-style: solid;
  border-color: white white rgba(1,1,1,0.2) rgba(0,0,0,0.2);
  position: absolute;
  top: -40px;
  right: -40px;
  transition: all 0.3s ease 0s;
}
.service-box:hover:before{
  top: 0;
  right: 0;
}
.service-box img{
  font-size: 65px;
  color: #967128;
  margin-bottom: 14px;
  transition: all 0.3s ease 0s;
}
.service-box .titre{
  font-size: 18px;
  font-weight: 900;
  color: #545454;
  line-height: 25px;
  text-transform: capitalize;
  margin: 0 0 16px 0;
  transition: all 0.3s ease 0s;
}
.service-box .telephone{
  font-size: 15px;
  color: #545454;
  line-height: 25px;
  margin: 0;
  transition: all 0.3s ease 0s;
}
.service-box:hover img, .service-box:hover .titre, .service-box:hover .telephone, .service-box:hover a{
  color: white;
}
</style>