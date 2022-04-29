<?php require_once 'functions.php'; ?>
    <header>
            <nav class="navbar navbar-expand-md navbar-dark fixed-top" style="background: #563D7C">
                <a class="navbar-brand" href="index.php?page=home">
                    <i class='bx bxs-hot'></i> Ngomsi Franck Collins
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                    <ul class="navbar-nav mr-auto">
                        <?= nav_menu('nav-link');?>
                    </ul>
                     <form class="form-inline my-2 my-lg-0">
                        <a style="cursor: pointer;" class="nav-link text-white" data-toggle="modal" data-target="#ModalCenter" title="connexion">
                           <i class='bx bx-user-circle bx-sm'></i>
                        </a>
                        <?php if(isset($_SESSION['id'])): ?>
                        <a style="cursor: pointer;" class="nav-link text-white"href="index.php?page=cart" title="cart">
                           <i class='bx bxs-cart bx-sm'></i>
                        </a>
                        <?php endif ?>
                     </form>
                </div>
            </nav>
        </header>
<!-- ======= Carrousel ======= -->
<section class="jumbotron text-center">
    <div class="container">
        <h2 class="jumbotron-heading">E-COMMERCE NGOMSI FRANCK COLLINS</h2>
        <p class="lead text-muted mb-0">Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500...</p>
    </div>
</section>
<!-- End  Carrousel -->





<!-- End  Carrousel -->

<div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
    <div role="document" class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="ModalLongTitle" class="modal-title">
                    AUTHENDIFION DES UTILISATEURS
                </h5>
                <button type="button" class="close" dat-dismiss="modal" aria-label="Close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p> Salut Monsieur ou Madame vous êtes ?</p>
            </div>
            <div class="modal-footer">
                <a href="client/index.php">
                    <button type="button" class="btn btn-secondary">Client</button>
                </a>
                <a href="admin/index.php">
                    <button type="button" class="btn btn-danger">Administrateur</button>
                </a>
                
            </div>
        </div>
    </div>
</div>
