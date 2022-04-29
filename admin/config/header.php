<?php

if (isset($_GET['id']) AND $_GET['id'] >0) {
  $getid = intval($_GET['id']);
  $requser = $db->prepare("SELECT * FROM admin WHERE id = ?"); 
  $requser->execute(array($getid));
  $_SESSION = $requser->fetch();
}

$nbre = $db->query('SELECT * FROM commentaire WHERE seen = 0');
$mo = $nbre->rowCount();

if ($page !='login' && $page != 'inter' && $page != '404' && $page !='deconnection') {

?>
		 	 <div class="page-wrapper chiller-theme toggled">
  <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
    <i class="fas fa-bars"></i>
  </a>
  <nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
      <div class="sidebar-brand">
        <a href="index.php?page=dashboard">pro sidebar</a>
        <div id="close-sidebar">
          <i class="fas fa-times"></i>
        </div>
      </div>
      <div class="sidebar-header">
        <div class="user-pic">
           <?php
          if (!empty($_SESSION['avatar'])) {
            ?>
          <img class="img-responsive img-rounded" src="../assets/img/admin/<?=$_SESSION['id']?>"alt="<?=$_SESSION['nom']?>" width="150">
          <?php
        }?>
        </div>
        <div class="user-info">
          <span class="user-name">
            <strong><?=$_SESSION['nom'];?></strong>
          </span>
          <span class="user-role">Administrateur</span>
          <span class="user-status">
            <i class="fa fa-circle"></i>
            <span>Online</span>
          </span>
        </div>
      </div>
      <!-- sidebar-search  -->
      <div class="sidebar-menu">
        <ul>
          <li class="sidebar-dropdown">
            <a href="index.php?page=dashboard">
              <i class='bx bxs-tachometer bx-xs'></i>
              <span>Dashboard</span>
              <span class="badge badge-pill badge-warning">New</span>
            </a>
          </li>
          <li class="sidebar-dropdown">
            <a href="index.php?page=client">
              <i class='bx bxs-user bx-xs'></i>
              <span>Liste des Clients</span>
            </a>
          </li>
           <li class="sidebar-dropdown">
            <a href="index.php?page=categorie">
              <i class='bx bxs-category bx-xs'></i>
              <span>Liste des Catégories</span>
            </a>
          </li>
          <li class="sidebar-dropdown">
            <a href="index.php?page=produit">
              <i class='bx bxs-truck bx-xs'></i>
              <span>Liste des Produits</span>
            </a>
          </li>
          <li class="sidebar-dropdown">
            <a href="index.php?page=ha">
              <i class='bx bxs-business bx-xs'></i>
              <span>Liste des Partenaires</span>
            </a>
          </li>
          <li class="sidebar-dropdown">
            <a href="index.php?page=commande">
              <i class='bx bxs-shopping-bags bx-xs'></i>
              <span>Liste des Commandes</span>
            </a>
          </li>
          <li class="sidebar-dropdown">
            <a href="index.php?page=histoire">
             <i class='bx bx-stats bx-xs'></i>
              <span>Historique des ventes</span>
            </a>
          </li>
          <li class="sidebar-dropdown">
            <a href="../index.php?page=home">
            	<i class='bx bxs-home bx-xs'></i>
              <span>Quitter votre interface</span>
            </a>
          </li>
        </ul>
      </div>
      <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-content  -->
    <div class="sidebar-footer">
      <a href="index.php?page=notification">
        <i class='bx bxs-bell bx-xs'></i>
        <span class="badge badge-pill badge-warning notification"><?=$mo?></span>
      </a>
      <a href="index.php?page=message">
        <i class='bx bxs-envelope bx-xs'></i>
        <span class="badge badge-pill badge-success notification">7</span>
      </a>
      <a href="index.php?page=edit">
        <i class='bx bxs-cog bx-xs'></i>
        <span class="badge-sonar"></span>
      </a>
      <a href="index.php?page=deconnection">
        <i class='bx bx-power-off bx-xs'></i>
      </a>
    </div>
  </nav>
<?php  }?>
