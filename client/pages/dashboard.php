<?php 
//$title = "Administration";
//require 'config/functions.php';
//require '../config/header.php';

?>
   <!-- sidebar-wrapper  -->
   <main class="page-content main">

  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="container">
    <div class="jumbotron mt-3">
      <h1>BIENVENUE <?=$_SESSION['sexe'];?> <strong><?=$_SESSION['nom'];?></strong></h1>
      <p class="lead">This example is a quick exercise to illustrate how the bottom navbar works.</p>
      <pre><?php debug($_SESSION); ?></pre>
    </div>
  </div>


        
    </div> <!-- /container -->

</main>
  <!-- page-content" -->
</div>